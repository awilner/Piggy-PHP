<?php
class Account extends AppModel {
	var $name = 'Account';

	var $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'account_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'financial_institution_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'currency_id' => array(
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
		//'User' => array(
		//	'className' => 'User',
		//	'foreignKey' => 'user_id',
		//	'conditions' => '',
		//	'fields' => '',
		//	'order' => ''
		//),
		'AccountType' => array(
			'className' => 'AccountType',
			'foreignKey' => 'account_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		//'FinancialInstitution' => array(
		//	'className' => 'FinancialInstitution',
		//	'foreignKey' => 'financial_institution_id',
		//	'conditions' => '',
		//	'fields' => '',
		//	'order' => ''
		//),
		'Currency' => array(
			'className' => 'Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/*var $hasMany = array(
		'Balance' => array(
			'className' => 'Balance',
			'foreignKey' => 'account_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Balance.date DESC'
		)
	);*/

	function getList($userId,$defaultCurrencyId,$type = null, $showHidden = false)
	{
		// Load Balance model.
		$balanceModel = ClassRegistry::init('Balance');

		// TODO: convert currency if needed.
		// TODO: hidden accounts not implemented yet, list by type neither - parameters are currently ignored.
		$accounts = array();
		$totals = array();
		$netWorth = 0;

		// Assemble array of options for the query.
		$options = array(
			'fields' => array('Account.id','Account.name','Currency.symbol','AccountType.name','AccountType.type'),
			'conditions' => array('user_id' => $userId),
			'order' => array('account_type_id','financial_institution_id','Account.name'),
		);
		$list = $this->find('all', $options);

		// Process results.
		foreach($list as $account)
		{
			if(!array_key_exists($account['AccountType']['type'],$accounts))
			{
				$accounts[$account['AccountType']['type']] = array();
				$totals[$account['AccountType']['type']]['balance'] = 0;
				$totals[$account['AccountType']['type']]['name'] = $account['AccountType']['name'];
			}

			$balance = $balanceModel->current($account['Account']['id']);

			array_push($accounts[$account['AccountType']['type']],
				array(
					'id' => $account['Account']['id'],
					'name' => $account['Account']['name'],
					'balance' => $balance,
					'currency' => $account['Currency']['symbol'],
					'type' => $account['AccountType']['type']
				)
			);
			$totals[$account['AccountType']['type']]['balance'] += $balance;
			$netWorth += $balance;
		}

		// Get the user's default currency.
		$userDefaultCurrency = $this->Currency->field('symbol',array('id'=>$defaultCurrencyId));

		return compact('userDefaultCurrency','totals','netWorth','accounts');
	}

	function getType($accountId)
	{
		$options = array(
                        'fields' => array('AccountType.type'),
                        'conditions' => array('Account.id'=>$accountId)
                );
		$result = $this->find('first',$options);

		if($result)
			return $result['AccountType']['type'];
	}

}
?>
