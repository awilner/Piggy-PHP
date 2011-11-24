<?php
    if($isAjax)
?>
<div id="main_display">
<?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('User', array('action' => 'login'));
?>
<fieldset>
	<legend><?php echo __('Login'); ?></legend>
<?
    echo $this->Form->input('username');
    echo $this->Form->input('password');
?>
</fieldset>
<?php echo $this->Form->end(__('Login')); ?>
<?php
    if($isAjax)
?>
</div>
