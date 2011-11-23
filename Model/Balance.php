<?php
class Balance extends AppModel {
	var $name = 'Balance';
	var $validate = array(
		'account_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

//	var $belongsTo = array(
//		'Account' => array(
//			'className' => 'Account',
//			'foreignKey' => 'account_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
//	);

	function current($accountId)
	{
		$options = array(
			'conditions' => array('account_id' => $accountId,'date <'=>date('Y-m-d')),
			'order' => array('date DESC')
		);
		$balance = $this->find('first',$options);
		if($balance)
			return $balance['Balance']['balance'];
	}

	function ending($accountId)
	{
		$options = array(
			'conditions' => array('account_id' => $accountId),
			'order' => array('date DESC')
		);
		$balance = $this->find('first',$options);
		if($balance)
			return $balance['Balance']['balance'];
	}

}
?>
