<?php
if(isset($accounts))
{

  // Add our own currency formats.
  $this->element('currency');
?>
<ul id="account_list">
  <li id="account_overview"><a href="<?php echo Router::url('/accounts/index/'); ?>" onclick="go('<?php echo Router::url('/accounts/index/'); ?>');return false;"><?php echo __("Overview"); ?></a></li>
<?php foreach($accounts as $type=>$list): ?>
  <li class="account_separator"><hr></li>
  <li class="account_group">
    <div class="toggle" onclick="toggleMenu('<?php echo $type; ?>')"/>
    <a href="<?php echo Router::url('/accounts/index/'.$type); ?>" onclick="go('<?php echo Router::url('/accounts/index/'.$type); ?>');return false;"><?php echo __($totals[$type]['name']); ?></a>
  </li>
  <ul id="account_group_<?php echo $type; ?>">
  <?php foreach($list as $account): ?>
    <li class="account">
      <a href="<?php echo Router::url('/accounts/index/'.$account['id']); ?>" onclick="go('<?php echo Router::url('/accounts/index/'.$account['id']); ?>');return false;">
	<?php echo $account['name']; ?>
        <span class="value<?php if($account['balance'] < 0) echo " negative"; ?>"><?php echo $this->Number->currency($account['balance'],$account['currency']); ?></span>
      </a>
    </li>
  <? endforeach; ?>
  </ul>
  <li class="account_group_total">
    <span class="value<?php if($totals[$type]['balance'] < 0) echo " negative"; ?>"><?php echo $this->Number->currency($totals[$type]['balance'],$userDefaultCurrency); ?></span>
  </li>
<? endforeach; ?>
  <li class="net_worth_separator"><hr></li>
  <li id="net_worth">
    <span class="account" scope="row"><?php echo __("Net Worth"); ?></span>
    <span class="value<?php if($netWorth < 0) echo " negative"; ?>"><?php echo $this->Number->currency($netWorth,$userDefaultCurrency); ?></span>
  </li>
</ul>
<div class="button" onclick="location.href='<?php echo Router::url('/accounts/add');?>';" style="cursor:pointer;"><?php echo __("Add an account"); ?></div>
<?php
}
?>
