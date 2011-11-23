<div class="form">
<?php echo $this->Form->create('Account');?>
	<fieldset>
 		<legend><?php __('Add Account'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('account_type_id');
		echo $this->Form->input('financial_institution_id');
		echo $this->Form->input('currency_id',array('selected' => $userDefaultCurrency));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
