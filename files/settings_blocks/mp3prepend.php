<?php
// ** SpeechyAPi
$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
$list = $speechyApi->getMp3List();
$list = $list['data']['mp3list'];
?>

<?php 
	$action = isset($_REQUEST['action'])?$_REQUEST['action']:false;
	if($action === "mp3upload"){
		var_dump($_FILES);die;
	}
?>

<h2><?php echo __("Upload Mp3" , "speechy"); ?></h2>
<div class="mp3prepend">
	<div class="form">
		<form action="?page=speechy-plugin&tab=mp3prepend" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="mp3upload">
			<label for="mp3name">File Name</label>
			<input name="mp3name" type="text"/>
			<label for="mp3file">Mp3 File (Max. size is 8MB)</label>
			<input name="mp3file" type="file"/>
			<input name="submit" type="submit" class="button button-primary" value="Upload"/>
		</form>
	</div>
	
	<div class="list">
		<?php if(!empty($list)):?>
			<table class="table">
				<tr>
					<th>No.</th>
					<th>Name</th>
					<th></th>
				</tr>
				<?php $c = 1;?>
				<?php foreach ($list as $k=>$v):?>
					<tr>
						<td><?=$c++?></td>
						<td><?=$v['name']?></td>
						<td>
							<a href="<?=$v['url']?>" target="_blank">Download</a>
							<a href="?page=speechy-plugin&tab=mp3prepend&action=mp3remove&id=<?=$v['id']?>">Remove</a>
						</td>
					</tr>
				<?php endforeach;?>
			</table>
		<?php else:?>
			<h4>No Mp3 found.</h4>
		<?php endif;?>
	</div>
</div>