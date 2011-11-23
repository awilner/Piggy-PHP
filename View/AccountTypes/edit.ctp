<div class="accountTypes form">
<?php echo $this->Form->create('AccountType');?>
	<fieldset>
 		<legend><?php __('Edit Account Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('ofx_type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('AccountType.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('AccountType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Account Types', true), array('action' => 'index'));?></li>
	</ul>
</div>