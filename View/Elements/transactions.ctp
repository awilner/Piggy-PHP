<?php
  // Add our own currency formats.
  $this->element('currency');
?>
	<h2><?php echo __('%s - Transactions',$account);?></h2>
	<?php echo $this->element('timeline'); ?>
	<table cellpadding="0" cellspacing="0" class="transaction">
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
	</table>
