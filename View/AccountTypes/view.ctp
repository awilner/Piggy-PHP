<div class="accountTypes view">
<h2><?php  __('Account Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $accountType['AccountType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $accountType['AccountType']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ofx Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $accountType['AccountType']['ofx_type']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Account Type', true), array('action' => 'edit', $accountType['AccountType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Account Type', true), array('action' => 'delete', $accountType['AccountType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $accountType['AccountType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Account Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Account Type', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
