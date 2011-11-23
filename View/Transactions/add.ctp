<div class="transactions form">
<?php echo $this->Form->create('Transaction');?>
	<fieldset>
 		<legend><?php __('Add Transaction'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Transactions', true), array('action' => 'index'));?></li>
	</ul>
</div>