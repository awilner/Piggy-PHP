<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('main');
		echo $this->Html->css('leftmenu');
		echo $this->Html->css('navmenu');
		echo $this->Html->css('transactions');

		echo $this->Html->script('prototype');
		echo $this->Html->script('scriptaculous.js?load=effects'); 
		echo $this->Html->script('updater.js'); 
		echo $this->Html->script('resize.js'); 

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<div id="nav_menu_bar">
				<?php echo $this->element('navmenu'); ?>
			</div>

			<div id="left_menu_list">
				<?php echo $this->element('accountlist'); ?>
			</div>

			<div id="main_content">
				<div id="headings">
					<h1 id="page_header"><?php if(isset($page_header)) echo $page_header; ?></h1>
					<div id="timeline">
						<?php if(isset($month) && isset($year)) echo $this->element('timeline'); ?>
					</div>
				</div>
				<div id="loading_div" style="display: none;">
			    		<?php echo $this->Html->image('ajax-loader.gif'); ?>
				</div>
				<div id="main_display">
					<?php echo $content_for_layout; ?>
				</div>
			</div>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
