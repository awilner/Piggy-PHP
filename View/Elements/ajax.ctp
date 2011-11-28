<?php
	if(isset($page_header)) echo '<h1 id="page_header">'.$page_header.'</h1>';
	if(isset($month) && isset($year))
		echo '<div id="timeline">'.$this->element('timeline').'</div>';
	else
		echo '<div id="timeline"></div>';
	if(isset($navMenu)) echo $this->element('navmenu');
	if(isset($overview)) echo '<div id="main_display">'.$this->element('overview').'</div>';
	if(isset($transactions)) echo '<div id="main_display">'.$this->element('transactions').'</div>';
?>
