<?php
class TransactionsController extends AppController {

	var $name = 'Transactions';

	var $components = array('NavMenu');

	function beforeRender()
	{
		parent::beforeRender();

		// If we are dealing with ajax, no need to reselect accounts.
		if($this->request->isAjax())
			return;

		// Set the account list.
		$this->set($this->Account->getList($this->Auth->user('id'), $this->Auth->user('default_currency_id')));
	}

	function index($accountId,$yearMonth=null)
	{
		if(!$accountId || !is_numeric($accountId))
			$this->redirect(array('controller'=>'accounts','action' => 'index'));

		// Make sure the user is allowed to see the account.
		$accountId = Sanitize::escape($accountId);
		if(!$this->isAuthorized($accountId))
		{
			$this->Session->setFlash(__('Invalid account', true));
                        $this->redirect(array('controller'=>'accounts','action' => 'overview'));
		}

		// If a year and month are specified, check if they are valid.
		if($yearMonth != null && !is_numeric($yearMonth))
			$yearMonth = null;
		else if($yearMonth != null)
			$yearMonth = Sanitize::escape($yearMonth);

		// If no month is given or the given one is invalid, use current month.
		if($yearMonth == null)
			$yearMonth = date('Ym');

		// Prepare the start and end date.
		$startDate = substr($yearMonth,0,4).'-'.substr($yearMonth,4,2);
		$endDate = $startDate.'-31';
		$startDate .= '-01';

		// Get the list of transactions.
		$transactions = $this->Transaction->listTransactions($accountId,$startDate,$endDate);
		$this->set(compact('transactions'));

		// Set the data needed for nav menu.
	        $type = $this->NavMenu->checkType($this->Account->getType($accountId));
		$this->set('navMenu', $this->NavMenu->menu($type));
		$this->set('selectedTab','transactions');
		$this->set('accountId',$accountId);

		// If this is an AJAX request, render it appropriately.
		if($this->request->isAjax())
                        $this->render('/Elements/ajax','ajax');
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('transaction', $this->Transaction->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Transaction->create();
			if ($this->Transaction->save($this->data)) {
				$this->Session->setFlash(__('The transaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Transaction->save($this->data)) {
				$this->Session->setFlash(__('The transaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Transaction->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for transaction', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Transaction->delete($id)) {
			$this->Session->setFlash(__('Transaction deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Transaction was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
