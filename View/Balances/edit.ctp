<div class="balances form">
<?php echo $this->Form->create('Balance');?>
	<fieldset>
 		<legend><?php __('Edit Balance'); ?></legend>
	<?php
		echo $this->Form->input('account_id');
		echo $this->Form->input('date');
		echo $this->Form->input('balance');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Balance.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Balance.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Balances', true), array('action' => 'index'));?></li>
	</ul>
</div>