<?php 
// Credentials can be get from http://speechy-portal.s3-website-us-east-1.amazonaws.com/
// Voices are listed at http://docs.aws.amazon.com/polly/latest/dg/voicelist.html

use Html2Text\Html2Text;

define('API_URL', "https://kw3nkaycwd.execute-api.us-east-1.amazonaws.com/prod");
require_once(__DIR__ . "/Html2Text.php");
require_once(__DIR__ . "/Html2TextException.php");

class SpeechyAPi{

	private $idKey = "";
	private $secretKey = "";
	
	public function SpeechyAPi($idKey, $secretKey){
		$this->idKey = $idKey;
		$this->secretKey = $secretKey;
	} 
	
	public function getSentences($content){
		$content = str_replace(chr(0xC2).chr(0xA0), " ", $content); // if there is any \u00a0, we need to replace it with spaces because it causes 2 byte instead of 1 as space.
		$content =  preg_replace("/\([^)]+\)/","",$content); // Quiting any content between square brackets.
		
		$arr = preg_split("/(?<!\..)([\?\!\.]+)\s(?!.\.)/",$content,-1, PREG_SPLIT_DELIM_CAPTURE); // Regex Ref. https://en.wikipedia.org/wiki/Sentence_boundary_disambiguation

		$i = 0;
		$sentences[$i] = "";
		foreach ($arr as $v){
			if(preg_match("/^((?![A-Z|a-z|0-9]).)*$/", $v) != 0) { // We have to join delimitter in sentences.
				$sentences[$i] .= $v." ";
				$sentences[++$i] = "";
			}
			else
				$sentences[$i] .= $v;
		}
		return $sentences;
	}
	
	public function processAudioToContent($html) {
		$contentList = [];
		$tmpContent = "";
		$blockSize = 400;
		// Setting escape characters in our format
		
		$html = str_replace("&amp;", "#amp;", $html);
		$html = str_replace("&lt;", "#lt;", $html);
		$html = str_replace("&gt;", "#gt;", $html);
		$html = str_replace("&nbsp;", "", $html);
		
		$html = preg_replace("/<.*?>(*SKIP)(*FAIL)|&/", "#amp;", $html);
		$html = preg_replace("/<.*?>(*SKIP)(*FAIL)|</", "#lt;", $html);
		$html = preg_replace("/<.*?>(*SKIP)(*FAIL)|>/", "#gt;", $html); // &nbsp;
		$html = str_replace("<amazon:effect", "<amazoneffect", $html);
		$html = str_replace("</amazon:effect>", "</amazoneffect>", $html);
		
		$content = Html2Text::convert($html, true);
		$sentenceList = $this->getSentences($content);
		
		$repairedXMLList = [];
		foreach ($sentenceList as $sentence){
			$x = new DOMDocument;
			@$x->loadHTML(mb_convert_encoding($sentence, 'HTML-ENTITIES', 'UTF-8'));
			$tmp = $x->saveXML();
			$tmp = str_ireplace("</p>", "", $tmp); // because Dom adds <p> We have to remove it.
			$tmp = str_ireplace("<p>", "", $tmp);
			$startIndex = stripos($tmp, "<html><body>") + strlen("<html><body>");
			$endIndex = stripos($tmp, "</body></html>");
			//$repairedXMLList[] = $tmp;
			@$repairedXML = substr($tmp, $startIndex, $endIndex - $startIndex);
			$repairedXML = mb_convert_encoding($repairedXML, 'UTF-8', 'HTML-ENTITIES');
			
			// Resetting escape characters
			$repairedXML = str_replace("#amp;", "&amp;", $repairedXML);
			$repairedXML = str_replace("#lt;", "&lt;", $repairedXML);
			$repairedXML = str_replace("#gt;", "&gt;", $repairedXML);
			$repairedXML = str_replace("<amazoneffect", "<amazon:effect", $repairedXML);
			$repairedXML = str_replace("</amazoneffect>", "</amazon:effect>", $repairedXML);
			$repairedXMLList[] = $repairedXML;
		}
		//print_r($repairedXMLList);die;
		
		$tmpContent = "";
		foreach ($repairedXMLList as $v){
			if(strlen($tmpContent . " " . $v) > $blockSize){
				$contentList[] = $tmpContent; 
				$tmpContent = "";
			}
			$tmpContent = $tmpContent . " " . $v;
		}
		if(trim($tmpContent) != "")
			$contentList[] = $tmpContent; 
		return $contentList;
	}
	
	private function _callApi($rel, $method = 'get', $data){
		
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, API_URL . "/$rel");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = "Authorization: Basic " . base64_encode($this->idKey . ":" . $this->secretKey); // Here we are passing credentials in headers after encoding to base64.
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		if($method == "post"){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		}
		
		$result = curl_exec ($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
		curl_close ($ch);
		if($status_code == 200){
			$resp = json_decode($result, true);
			return $resp;
		}
		else{
			return array(
				"error" => 1,
				"errorCode" => $status_code,
				"message" => "Error Code : $status_code"
			);
		}
	}
	
	public function getUsage(){
		$resp = $this->_callApi("get-usage", "post", []);
		return $resp;
	}
	
	public function getInvoices(){
		$resp = $this->_callApi("get-invoices", "post", []);
		return $resp;
	}
	
	public static function getPostIdFromRequest(){
		if($_REQUEST['error'] == 0)
			return $_REQUEST['post_id'];
		return false;
	}
	
	public function createAudio($postId, $html, $voice = "Amy", $callbackUrl = false){
		$contentList = $this->processAudioToContent($html);
		if(count($contentList) == 0) return false;
		
		$jsonArr = array(
			"post_id" => $postId,
			"contentlist" => $contentList,
			"voice" => $voice,
			"callback_url" =>$callbackUrl
		);
		if($callbackUrl !== false) $resp = $this->_callApi("create-audio-delayed", "post", $jsonArr);
		else $resp = $this->_callApi("create-audio", "post", $jsonArr);
		return $resp;
	}
	
	public function deleteAudio($postId){
		$jsonArr = array(
			"post_id" => $postId
		);
		$resp = $this->_callApi("delete-audio", "post", $jsonArr);
		return $resp;
	}
	
}