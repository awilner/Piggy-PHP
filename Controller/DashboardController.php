<?php
class DashboardController extends AppController
{
	var $name = 'Dashboard';
	//var $uses = array('Account','NavMenu');
 
	function patch()
	{
		// TODO: for now, send all requests to the accounts controller.
		$this->redirect(array_merge(array('controller'=>'accounts','action'=>'patch'),$this->passedArgs));
	}
}
?>
