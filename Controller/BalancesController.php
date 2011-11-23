<?php
class BalancesController extends AppController {

	var $name = 'Balances';

	function index() {
		$this->Balance->recursive = 0;
		$this->set('balances', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid balance', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('balance', $this->Balance->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Balance->create();
			if ($this->Balance->save($this->data)) {
				$this->Session->setFlash(__('The balance has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The balance could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid balance', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Balance->save($this->data)) {
				$this->Session->setFlash(__('The balance has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The balance could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Balance->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for balance', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Balance->delete($id)) {
			$this->Session->setFlash(__('Balance deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Balance was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>