<div class="financialInstitutions view">
<h2><?php  __('Financial Institution');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $financialInstitution['FinancialInstitution']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $financialInstitution['FinancialInstitution']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ofx Bankid'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $financialInstitution['FinancialInstitution']['ofx_bankid']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Financial Institution', true), array('action' => 'edit', $financialInstitution['FinancialInstitution']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Financial Institution', true), array('action' => 'delete', $financialInstitution['FinancialInstitution']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $financialInstitution['FinancialInstitution']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Financial Institutions', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Financial Institution', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accounts', true), array('controller' => 'accounts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Account', true), array('controller' => 'accounts', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Accounts');?></h3>
	<?php if (!empty($financialInstitution['Account'])):?>
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
		foreach ($financialInstitution['Account'] as $account):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $account['id'];?></td>
			<td><?php echo $account['user_id'];?></td>
			<td><?php echo $account['name'];?></td>
			<td><?php echo $account['account_type_id'];?></td>
			<td><?php echo $account['financial_institution_id'];?></td>
			<td><?php echo $account['currency_id'];?></td>
			<td><?php echo $account['ofx_acctid'];?></td>
			<td><?php echo $account['current_balance'];?></td>
			<td><?php echo $account['ending_balance'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'accounts', 'action' => 'view', $account['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'accounts', 'action' => 'edit', $account['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'accounts', 'action' => 'delete', $account['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $account['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Account', true), array('controller' => 'accounts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
