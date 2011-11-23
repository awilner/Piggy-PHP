<div class="balances view">
<h2><?php  __('Balance');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Account Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $balance['Balance']['account_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $balance['Balance']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Balance'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $balance['Balance']['balance']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Balance', true), array('action' => 'edit', $balance['Balance']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Balance', true), array('action' => 'delete', $balance['Balance']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $balance['Balance']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Balances', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Balance', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
