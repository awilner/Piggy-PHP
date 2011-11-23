<div class="financialInstitutions form">
<?php echo $this->Form->create('FinancialInstitution');?>
	<fieldset>
 		<legend><?php __('Edit Financial Institution'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('ofx_bankid');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('FinancialInstitution.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('FinancialInstitution.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Financial Institutions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Accounts', true), array('controller' => 'accounts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Account', true), array('controller' => 'accounts', 'action' => 'add')); ?> </li>
	</ul>
</div>