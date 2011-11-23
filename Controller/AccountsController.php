<?php
class AccountsController extends AppController {

	var $name = 'Accounts';

	var $components = array('NavMenu');

//	function beforeFilter()
//	{
//		parent::beforeFilter();
//		$this->Account->authUserId = $this->Auth->user('id');
//		$this->Account->authUserDefaultCurrencyId = $this->Auth->user('default_currency_id');
//	}

	function beforeRender()
	{
		parent::beforeRender();

		// If we are dealing with ajax, no need to reselect accounts.
		if($this->request->isAjax())
			return;

		// Set the account list.
		$this->set($this->Account->getList($this->Auth->user('id'), $this->Auth->user('default_currency_id')));
	}

	function index($type = null)
	{
		// In order to maintain a pattern accross tabs, we redirect to view if an account id is passed.
		if(is_numeric($type))
			$this->redirect(array('action' => 'view',$type));

		// Check if type is valid.
		$type = $this->NavMenu->checkType($type);
		$this->set('currentAccountOverview',Sanitize::html($type));

		if($type == $this->NavMenu->checkType(null))
		{
			// Show general overview.
			$this->set('currentAccountOverview','Global');
		}

		// Set the idata needed for nav menu.
		$this->set('navMenu', $this->NavMenu->menu($type));
		$this->set('selectedTab','overview');
		$this->set('accountId',$type);

		// If the request is ajax, use ajax component.
                if($this->request->isAjax())
                        $this->render('/Elements/ajax','ajax');
	}

	function view($id = null)
	{
		if(!$id)
			$this->redirect(array('action' => 'index'));

		// Make sure the user is allowed to see the account.
		$id = Sanitize::escape($id);
		if( !$this->isAuthorized($id) )
		{
			$this->Session->setFlash(__('Invalid account', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->Account->id = $id;
		$this->set('currentAccountOverview',$this->Account->field('name'));

		// Set the idata needed for nav menu.
	        $type = $this->NavMenu->checkType($this->Account->getType($id));
		$this->set('navMenu', $this->NavMenu->menu($type));
		$this->set('selectedTab','overview');
		$this->set('accountId',$id);

		// If the request is ajax, use ajax component.
                if($this->request->isAjax())
                        $this->render('/Elements/ajax','ajax');
	}

	function add() {
		if (!empty($this->data)) {
			$this->Account->create();
			$this->Account->set('user_id',$this->Auth->user('id'));
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('The account has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account could not be saved. Please, try again.', true));
			}
		}
		$accountTypes = $this->Account->AccountType->find('list');
		$financialInstitutions = $this->Account->FinancialInstitution->find('list');
		$currencies = $this->Account->Currency->find('list');
		$userDefaultCurrency = $this->Auth->user('default_currency_id');
		$this->set(compact('accountTypes','financialInstitutions','currencies','userDefaultCurrency'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid account', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('The account has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Account->read(null, $id);
		}
		$users = $this->Account->User->find('list');
		$accountTypes = $this->Account->AccountType->find('list');
		$this->set(compact('users', 'accountTypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for account', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Account->delete($id)) {
			$this->Session->setFlash(__('Account deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Account was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
