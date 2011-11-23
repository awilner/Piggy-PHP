<?php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
	var $name = 'User';
	var $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please provide a username',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please provide a password',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'repeat_password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please repeat your password',
				'allowEmpty' => false,
			),
			'confirm' => array(
				'rule' => array('validateConfirmPassword'),
				'message' => 'Passwords don\'t match',
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please provide a valid email',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please provide a name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'default_currency_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'DefaultCurrency' => array(
			'className' => 'Currency',
			'foreignKey' => 'default_currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Account' => array(
			'className' => 'Account',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/** validate only run through Model->save() or Model->validates() */
	function validateConfirmPassword($data) {
		if ($this->data['User']['password'] == AuthComponent::password($this->data['User']['repeat_password'])) {
			return true;
		} // fi
		return false;
	}

	/** check username taken or not */
	function beforeValidate() {
		if (empty($this->id)) { // being created, check for existing username
			$vCond = array('User.username'=>$this->data['User']['username']);
			if ($this->find('count',array('conditions'=>$vCond))>0) { // taken
				$this->invalidate('username_taken_error');
				return false;
			} // fi
		} // fi
		return true;
	}
}
?>
