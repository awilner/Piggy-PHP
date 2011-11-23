<div class="financialInstitutions index">
	<h2><?php __('Financial Institutions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('ofx_bankid');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($financialInstitutions as $financialInstitution):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $financialInstitution['FinancialInstitution']['id']; ?>&nbsp;</td>
		<td><?php echo $financialInstitution['FinancialInstitution']['name']; ?>&nbsp;</td>
		<td><?php echo $financialInstitution['FinancialInstitution']['ofx_bankid']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $financialInstitution['FinancialInstitution']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $financialInstitution['FinancialInstitution']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $financialInstitution['FinancialInstitution']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $financialInstitution['FinancialInstitution']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Financial Institution', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Accounts', true), array('controller' => 'accounts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Account', true), array('controller' => 'accounts', 'action' => 'add')); ?> </li>
	</ul>
</div>