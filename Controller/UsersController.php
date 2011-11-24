<?php
class UsersController extends AppController {

	var $name = 'Users';

	function beforeFilter() {
		$this->Auth->allow('register');
	}

	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		$defaultCurrencies = $this->User->DefaultCurrency->find('list');
		$this->set(compact('defaultCurrencies'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$defaultCurrencies = $this->User->DefaultCurrency->find('list');
		$this->set(compact('defaultCurrencies'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function login() {
		$this->set('isAjax', $this->RequestHandler->isAjax());
        	if ($this->Auth->login()) {
			$this->redirect($this->Auth->redirect());
		} else {
			$this->Session->setFlash(__('Invalid username or password, try again'));
		}
	}

        function logout() {
        	$this->redirect($this->Auth->logout());
    	}

	function register() {
		$this->Auth->logout();
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Auth->login($this->data); // autologin
				$this->redirect(array('action'=>'index'));
			} // fi
		} // fi
		$defaultCurrencies = $this->User->DefaultCurrency->find('list');
		$this->set(compact('defaultCurrencies'));
	}
}
?>
