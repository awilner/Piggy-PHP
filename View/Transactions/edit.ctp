<div class="transactions form">
<?php echo $this->Form->create('Transaction');?>
	<fieldset>
 		<legend><?php __('Edit Transaction'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('from_account_id');
		echo $this->Form->input('to_account_id');
		echo $this->Form->input('date');
		echo $this->Form->input('value');
		echo $this->Form->input('payee');
		echo $this->Form->input('category_id');
		echo $this->Form->input('memo');
		echo $this->Form->input('ofx_fitid');
		echo $this->Form->input('last_modified');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Transaction.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Transaction.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Transactions', true), array('action' => 'index'));?></li>
	</ul>
</div>