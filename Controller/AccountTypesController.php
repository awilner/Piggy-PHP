<?php
class AccountTypesController extends AppController {

	var $name = 'AccountTypes';

	function index() {
		$this->AccountType->recursive = 0;
		$this->set('accountTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid account type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('accountType', $this->AccountType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->AccountType->create();
			if ($this->AccountType->save($this->data)) {
				$this->Session->setFlash(__('The account type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account type could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid account type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->AccountType->save($this->data)) {
				$this->Session->setFlash(__('The account type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The account type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AccountType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for account type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AccountType->delete($id)) {
			$this->Session->setFlash(__('Account type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Account type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>