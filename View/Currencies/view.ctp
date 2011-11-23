<div class="currencies view">
<h2><?php  __('Currency');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $currency['Currency']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Symbol'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $currency['Currency']['symbol']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $currency['Currency']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Currency', true), array('action' => 'edit', $currency['Currency']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Currency', true), array('action' => 'delete', $currency['Currency']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $currency['Currency']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Currencies', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Currency', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
