<h2><?php echo __("Your payment Info" , "speechy"); ?></h2>
<?php
// ** SpeechyAPi
$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
$payments = $speechyApi->getInvoices(); 
?>



<?php
if($payments ['error'] == 0){
	?>
	<table class="table">
		<tr>
			<th>Date</th>
			<th>Amount</th>
		</tr>
<?php
	$payment_list = $payments['data'];
	// Array ( [0] => Array ( [invoiceNo] => 5bab5eec4d-0001 [date] => 1514982426 [paid] => 1 [periodStart] => 1514982426 [periodEnd] => 1514982426 [tax] => [taxPercent] => [subTotal] => 900 [total] => 900 [currency] => usd [discount] => 0 [lineitems] => Array ( [0] => Array ( [id] => sub_C4JyeZ0BUuRmWk [description] => 1x Blogger (@ $0.09) [amount] => 900 [currency] => usd ) ) ) )
	
	foreach ( $payment_list as $payment){
		?>
		<tr>
		<?php
		$payment_amount = $payment['total'] / 100;
		$payment_date = date('Y.m.d', $payment['date']);
		$lineitems = $payment['lineitems'];
		foreach ( $lineitems as $item){
$plan = $item['description'];
		}
		echo "<td>Date: ".$payment_date."</td><td>US$".$payment_amount." </td>";
		?>
		</tr>
		<?php
	}

}else{
	?>
	<h4>No data to show.</h4>
	<?php
}
