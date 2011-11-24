<?php
App::uses('Sanitize', 'Utility');
class AppController extends Controller {
	public $components = array(
		'Auth' => array(
			'loginRedirect' => array('controller' => 'accounts', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
			'ajaxLogin' => '../Users/login'
			),
		'Session',
		'RequestHandler');
	var $helpers = array(
		'Js' => array('Prototype'),
		'Session',
		'Form',
		'Html',
		'Number');

//	function beforeFilter()
//	{
//		parent::beforeFilter();
//		$this->set('isAjax',$this->RequestHandler->isAjax());		
//	}

	function isAuthorized($account)
	{
		$accountId = Sanitize::escape($account);

		$this->loadModel('Account');
		$this->Account->id = $accountId;
		if( $this->Account->field('user_id') == $this->Auth->user('id') )
			return true;

		return false;
	}
}
?>
