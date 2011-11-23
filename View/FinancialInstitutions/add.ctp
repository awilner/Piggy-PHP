<div class="financialInstitutions form">
<?php echo $this->Form->create('FinancialInstitution');?>
	<fieldset>
 		<legend><?php __('Add Financial Institution'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('ofx_bankid');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Financial Institutions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Accounts', true), array('controller' => 'accounts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Account', true), array('controller' => 'accounts', 'action' => 'add')); ?> </li>
	</ul>
</div>