<?php
	if(isset($navMenu)) echo $this->element('navmenu');
	if(isset($currentAccountOverview)) echo '<div id="main_display">'.$this->element('overview').'</div>';
	if(isset($transactions)) echo '<div id="main_display">'.$this->element('transactions').'</div>';
?>
