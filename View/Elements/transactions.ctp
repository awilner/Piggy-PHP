<?php
  // Add our own currency formats.
  $this->element('currency');

  // Set variables for SlickGrid
  $script = "var columns = [
	{id: \"payee\", name: \"". __('Payee') ."\",cssClass: \"transaction payee\"},
	{id: \"debit\", name: \"". __('Debit') ."\",cssClass: \"transaction value\"},
	{id: \"credit\", name: \"". __('Credit') ."\",cssClass: \"transaction value\"},
	{id: \"status\", name: \"". __('Status') ."\",cssClass: \"transaction status\"},
	{id: \"balance\", name: \"". __('Balance') ."\",cssClass: \"transaction value\"}
];";
  echo $this->Html->scriptBlock($script);
  echo $this->Html->script("transaction_remotemodel");
  echo $this->Html->script("transaction_slickgrid");
?>
<!--<div id="test" style="width:100%;height:600px;"><?php //var_dump($transactions); ?></div>-->
<div id="paginator" style="width:100%;"><?php echo $this->Paginator->numbers(); ?></div>
<table cellpadding="0" cellspacing="0" class="transaction">
	<thead id="transaction_header">
		<tr class="transaction_upper">
			<th class="transaction"><?php echo __('Payee');?></th>
			<th class="transaction"><?php echo __('Debit');?></th>
			<th class="transaction"><?php echo __('Credit');?></th>
			<th class="transaction"><?php echo __('Status');?></th>
			<th class="transaction"><?php echo __('Balance');?></th>
		</tr>
		<tr class="transaction_lower">
			<th class="transaction"><?php echo __('Account');?></th>
			<th colspan="2" class="transaction"><?php echo __('Category');?></th>
			<th colspan="2" class="transaction"><?php echo __('Memo');?></th>
		</tr>
	</thead>
	<tbody id="transaction_body">
	<?php
	$i = 0;
	$lastBalance = 0;
	$currency = "";
	foreach ($transactions as $date=>$transactionList):
?>
	<tr><td colspan="5" class="transaction_date"><?php echo $date; ?>&nbsp;</td></tr>
<?php
		foreach($transactionList as $transaction):
			$lastBalance = $transaction['Transaction']['balance'];
			$currency = $transaction['Transaction']['currency'];
			$altrow = null;
			if ($i++ % 2 == 0) {
				$altrow = ' altrow';
			}
	?>
	<tr class="transaction_upper<?php echo $altrow;?>">
		<td class="transaction payee"><?php echo $transaction['Transaction']['payee']; ?>&nbsp;</td>
		<td class="transaction value"><?php if(array_key_exists('debit',$transaction['Transaction'])) echo $this->Number->currency($transaction['Transaction']['debit'],$transaction['Transaction']['currency']); ?>&nbsp;</td>
		<td class="transaction value"><?php if(array_key_exists('credit',$transaction['Transaction'])) echo $this->Number->currency($transaction['Transaction']['credit'],$transaction['Transaction']['currency']); ?>&nbsp;</td>
		<td class="transaction status"><?php echo $transaction['Transaction']['status']; ?>&nbsp;</td>
		<td class="transaction value<?php if($transaction['Transaction']['balance'] < 0) echo ' negative'; ?>"><?php echo $this->Number->currency($transaction['Transaction']['balance'],$transaction['Transaction']['currency']); ?>&nbsp;</td>
	</tr>
	<tr class="transaction_lower<?php echo $altrow;?>">
		<td class="transaction"><?php echo $transaction['Transaction']['other_account']; ?>&nbsp;</td>
		<td colspan="2" class="transaction"><?php echo $transaction['Category']['path']; ?>&nbsp;</td>
		<td colspan="2" class="transaction"><?php echo $transaction['Transaction']['memo']; ?>&nbsp;</td>
	</tr>
<?php 		endforeach; ?>
	<tr>
		<td class="transaction_noborder">&nbsp;</td>
		<td colspan="3" class="transaction_noborder"><?php echo __('Balance for %s:',$date);?>&nbsp;</td>
		<td class="transaction_noborder value<?php if($lastBalance < 0) echo ' negative'; ?>"><?php echo $this->Number->currency($lastBalance,$currency); ?>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5" class="transaction_noborder"><hr></td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>
