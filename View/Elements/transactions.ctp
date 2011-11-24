<?php
  // Add our own currency formats.
  $this->element('currency');
?>
	<h2><?php echo __('Transactions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>payee</th>
			<th>debit</th>
			<th>credit</th>
			<th>status</th>
			<th>balance</th>
	</tr>
	<tr>
			<th>account</th>
			<th colspan="2">category</th>
			<th colspan="2">memo</th>
	</tr>
	<?php
	$i = 0;
	$lastBalance = 0;
	$currency = "";
	foreach ($transactions as $date=>$transactionList):
?>
	<tr><td colspan="5"><?php echo $date; ?>&nbsp;</td></tr>
<?php
		foreach($transactionList as $transaction):
			$lastBalance = $transaction['Transaction']['balance'];
			$currency = $transaction['Transaction']['currency'];
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $transaction['Transaction']['payee']; ?>&nbsp;</td>
		<td><?php if(array_key_exists('debit',$transaction['Transaction'])) echo $this->Number->currency($transaction['Transaction']['debit'],$transaction['Transaction']['currency']); ?>&nbsp;</td>
		<td><?php if(array_key_exists('credit',$transaction['Transaction'])) echo $this->Number->currency($transaction['Transaction']['credit'],$transaction['Transaction']['currency']); ?>&nbsp;</td>
		<td><?php echo $transaction['Transaction']['status']; ?>&nbsp;</td>
		<td><?php echo $this->Number->currency($transaction['Transaction']['balance'],$transaction['Transaction']['currency']); ?>&nbsp;</td>
	</tr>
	<tr<?php echo $class;?>>
		<td><?php echo $transaction['Transaction']['other_account']; ?>&nbsp;</td>
		<td colspan="2"><?php echo $transaction['Category']['path']; ?>&nbsp;</td>
		<td colspan="2"><?php echo $transaction['Transaction']['memo']; ?>&nbsp;</td>
	</tr>
<?php 		endforeach; ?>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3"><?php echo __('Balance for ').$date.':';?>&nbsp;</td>
		<td><?php echo $this->Number->currency($lastBalance,$currency); ?>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5"><hr></td>
	</tr>
<?php endforeach; ?>
	</table>
