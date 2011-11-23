<?php
    echo $session->flash('auth');
    echo $this->Form->create('User',array('action'=>'register'));
?>
<fieldset>
	<legend><?php __('Register'); ?></legend>
<?
    echo $this->Form->input('username',array('after'=>$form->error('username_taken_error','Sorry! This username has been taken. Please choose another one')));
    echo $this->Form->input('password', array('type'=>'password', 'value'=>''));
    echo $this->Form->input('repeat_password', array('label'=>'Repeat Password', 'type'=>'password', 'value'=>''));
    echo $this->Form->input('name');
    echo $this->Form->input('email');
    echo $this->Form->input('default_currency_id');
?>
</fieldset>
<? echo $this->Form->end(__('Register')); ?>
