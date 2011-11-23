<?php
class FinancialInstitutionsController extends AppController {

	var $name = 'FinancialInstitutions';

	function index() {
		$this->FinancialInstitution->recursive = 0;
		$this->set('financialInstitutions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid financial institution', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('financialInstitution', $this->FinancialInstitution->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->FinancialInstitution->create();
			if ($this->FinancialInstitution->save($this->data)) {
				$this->Session->setFlash(__('The financial institution has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The financial institution could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid financial institution', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->FinancialInstitution->save($this->data)) {
				$this->Session->setFlash(__('The financial institution has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The financial institution could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->FinancialInstitution->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for financial institution', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->FinancialInstitution->delete($id)) {
			$this->Session->setFlash(__('Financial institution deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Financial institution was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>