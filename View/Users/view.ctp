<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['role']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Default Currency'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($user['DefaultCurrency']['name'], array('controller' => 'currencies', 'action' => 'view', $user['DefaultCurrency']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Currencies', true), array('controller' => 'currencies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Default Currency', true), array('controller' => 'currencies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accounts', true), array('controller' => 'accounts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Account Owner', true), array('controller' => 'accounts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Accounts');?></h3>
	<?php if (!empty($user['AccountOwner'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Account Type Id'); ?></th>
		<th><?php __('Financial Institution Id'); ?></th>
		<th><?php __('Currency Id'); ?></th>
		<th><?php __('Ofx Acctid'); ?></th>
		<th><?php __('Current Balance'); ?></th>
		<th><?php __('Ending Balance'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AccountOwner'] as $accountOwner):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $accountOwner['id'];?></td>
			<td><?php echo $accountOwner['user_id'];?></td>
			<td><?php echo $accountOwner['name'];?></td>
			<td><?php echo $accountOwner['account_type_id'];?></td>
			<td><?php echo $accountOwner['financial_institution_id'];?></td>
			<td><?php echo $accountOwner['currency_id'];?></td>
			<td><?php echo $accountOwner['ofx_acctid'];?></td>
			<td><?php echo $accountOwner['current_balance'];?></td>
			<td><?php echo $accountOwner['ending_balance'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'accounts', 'action' => 'view', $accountOwner['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'accounts', 'action' => 'edit', $accountOwner['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'accounts', 'action' => 'delete', $accountOwner['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $accountOwner['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Account Owner', true), array('controller' => 'accounts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
