<ul id="nav_menu">
<?php if(isset($navMenu)) foreach($navMenu as $key=>$name):
	// Skip transactions tab if no specific account is selected.
	if(isset($accountId) && !is_numeric($accountId) && $key == 'transactions')
		continue;
?>
  <li class="nav_menu_tab<?php if($selectedTab == $key) echo ' selected'; ?>" id="nav_menu_<?php echo $key; ?>">
<?php
	if($selectedTab != $key)
	{
		// Assemble link for this nav tab.
		$link = '/'.$key.'/index/';

		if(isset($accountId) && $accountId != 'general')
			$link .= $accountId;

		// Get the correct link in relation to the cake root.
		$link = Router::url($link);
?>
    <a href="<?php echo $link; ?>" onclick="go('<?php echo $link; ?>');return false;">
<?php
	}

	// Write the tab content.
	echo __($name);

	// If needed, close the anchor tag.
        if($selectedTab != $key)
        {
?>
    </a>
<?php
        }
?>
  </li>
<?php endforeach; ?>
</ul>
