<?php
  // Add our own currency formats.
  $this->element('currency');
?>
	<h2><?php echo __('Transactions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>date</th>
			<th>account</th>
			<th>payee</th>
			<th>category</th>
			<th>memo</th>
			<th>value</th>
			<th>status</th>
	</tr>
	<?php
	$i = 0;
	foreach ($transactions as $transaction):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $transaction['Transaction']['date']; ?>&nbsp;</td>
		<td><?php echo $transaction['Transaction']['other_account']; ?>&nbsp;</td>
		<td><?php echo $transaction['Transaction']['payee']; ?>&nbsp;</td>
		<td><?php echo $transaction['Category']['path']; ?>&nbsp;</td>
		<td><?php echo $transaction['Transaction']['memo']; ?>&nbsp;</td>
		<td><?php echo $this->Number->currency($transaction['Transaction']['value'],$transaction['Transaction']['currency']); ?>&nbsp;</td>
		<td><?php echo $transaction['Transaction']['status']; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
