<div class="accounts form">
<?php echo $this->Form->create('Account');?>
	<fieldset>
 		<legend><?php __('Edit Account'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('account_type_id');
		echo $this->Form->input('financial_institution_id');
		echo $this->Form->input('currency_id');
		echo $this->Form->input('ofx_acctid');
		echo $this->Form->input('current_balance');
		echo $this->Form->input('ending_balance');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Account.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Account.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Accounts', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Account Types', true), array('controller' => 'account_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Account Type', true), array('controller' => 'account_types', 'action' => 'add')); ?> </li>
	</ul>
</div>