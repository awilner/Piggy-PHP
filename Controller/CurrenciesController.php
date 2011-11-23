<?php
class CurrenciesController extends AppController {

	var $name = 'Currencies';

	function index() {
		$this->Currency->recursive = 0;
		$this->set('currencies', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid currency', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('currency', $this->Currency->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Currency->create();
			if ($this->Currency->save($this->data)) {
				$this->Session->setFlash(__('The currency has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The currency could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid currency', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Currency->save($this->data)) {
				$this->Session->setFlash(__('The currency has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The currency could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Currency->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for currency', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Currency->delete($id)) {
			$this->Session->setFlash(__('Currency deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Currency was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>