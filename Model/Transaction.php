<?php
class Transaction extends AppModel {
	var $name = 'Transaction';

	var $validate = array(
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

	var $belongsTo = array(
		'FromAccount' => array(
			'className' => 'Account',
			'foreignKey' => 'from_account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ToAccount' => array(
			'className' => 'Account',
			'foreignKey' => 'to_account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	// Create an instance of Balance.
	private static $balance;

	function __construct($id=false,$table=null,$ds=null)
	{
		parent::__construct($id, $table, $ds);

		// Create the Balance object.
		if(self::$balance == null)
		{
			self::$balance = ClassRegistry::init('Balance');
		}
	}

	private function _removeFromBalances($account,$value,$startDate,$endDate = null)
	{
		// Check if the transaction is the only one for the given date and account.
		$count = $this->find('count',array('conditions'=>array('OR'=>array('to_account_id'=>$account,'from_account_id'=>$account),'date'=>$startDate)));
		if($count <= 1)
		{
			// This is the last transaction for the account and date, we need to remove the balance.
			if(!self::$balance->deleteAll(array('date'=>$date,'account_id'=>$account), false))
				return false;
		}

		// Now subtract the value from all balances up to the end date (not including) for the given account
		$fields = array('balance'=>'balance - '.$value);
		$conditions = array('account_id'=>$account,'date >='=>$startDate);
		if( $endDate )
			$conditions['date <'] = $endDate;
		return self::$balance->updateAll($fields,$conditions); 
	}

	private function _addToBalances($account,$value,$startDate,$endDate = null)
	{
                // Check if the account already has a balance for the given date.
		$count = self::$balance->find('count',array('conditions'=>array('account_id'=>$account,'date'=>$startDate)));
                if($count == 0)
                {
                        // This is the first transaction for the account and date, we need to insert a balance.
			// First we have to copy the last balance.
			$lastBalance = self::$balance->field('balance',array('account_id'=>$account,'date <'=>$startDate),'date DESC');
			if($lastBalance == null)
				$lastBalance = 0;
			$newBalance = array();
			$newBalance['Balance']['account_id'] = $account;
			$newBalance['Balance']['date'] = $startDate;
			$newBalance['Balance']['balance'] = $lastBalance;
			self::$balance->create();
                        if(!self::$balance->save($newBalance))
				return false;
                }

                // Now add the value to all balances up to the end date (not including) for the given account
                $fields = array('balance'=>'balance + '.$value);
                $conditions = array('account_id'=>$account,'date >='=>$startDate);
                if( $endDate )
                        $conditions['date <'] = $endDate;
                return self::$balance->updateAll($fields,$conditions);
	}

	function beforeSave($options)
	{
		// If the transaction is pending, ignore.
		if(array_key_exists('status',$this->data[$this->alias]) && $this->data[$this->alias]['status'] == 'P')
			return true;

		// Adjust balances as needed. First we get some essential fields.
		$fromAccount = array_key_exists('from_account_id',$this->data[$this->alias])?$this->data[$this->alias]['from_account_id']:null;
		$toAccount = array_key_exists('to_account_id',$this->data[$this->alias])?$this->data[$this->alias]['to_account_id']:null;
		$value = $this->data[$this->alias]['value'];
		$date = $this->data[$this->alias]['date'];
		$status = array_key_exists('status',$this->data[$this->alias])?$this->data[$this->alias]['status']:null;

		// Check if we are inserting or updating.
		if( $this->id )
		{
			// Updating. Retrieve old values.
			$oldValues = $this->find('first', array('conditions'=>array('Transaction.id'=>$$this->id)));
			$oldFromAccount = $oldValues[$this->alias]['from_account_id'];
			$oldToAccount = $oldValues[$this->alias]['to_account_id'];
			$oldValue = $oldValues[$this->alias]['value'];
			$oldDate = $oldValues[$this->alias]['date'];
			$oldStatus = $oldValues[$this->alias]['status'];

			// First check if the accounts changed (or if the transaction status changed from pending to something else).
			if($fromAccount != $oldFromAccount || ($oldStatus == 'P' && $status != $oldStatus))
			{
				if($fromAccount != $oldFromAccount)
				{
					// The from account changed, simply treat this as a delete from the old account and an insert into the new one.
					if($oldFromAccount && !$this->_removeFromBalances($oldFromAccount,-$oldValue,$oldDate))	return false;
				}
				if($fromAccount && !$this->_addToBalances($fromAccount,-$value,$date)) return false;
			}
			else if($fromAccount)
			{
				// Check if the date changed.
				if($date != $oldDate)
				{
					// Update the value between the old date and the new date. We use the old value because we deal with value changes below.
					if($date < $oldDate)
					{
						if(!$this->_removeFromBalances($fromAccount,-$oldValue,$oldDate,$oldDate)) return false;
						if(!$this->_addToBalances($fromAccount,-$oldValue,$date,$oldDate)) return false;
					}
					else
					{
						if(!$this->_removeFromBalances($fromAccount,-$oldValue,$oldDate,$date)) return false;
						if(!$this->_addToBalances($fromAccount,-$oldValue,$date,$date)) return false;
					}
				}

				// Check if the value changed.
				if($oldValue != $value && !$this->_addToBalances($fromAccount,$oldValue-$value,$date))
					return false;
			}

			// First check if the accounts changed (or if the transaction status changed from pending to something else).
			if($toAccount != $oldToAccount || ($oldStatus == 'P' && $status != $oldStatus))
			{
				if($toAccount != $oldToAccount)
				{
					// The to account changed, simply treat this as a delete from the old account and an insert into the new one.
					if($oldToAccount && !$this->_removeFromBalances($oldToAccount,$oldValue,$oldDate)) return false;
				}
				if($toAccount && !$this->_addToBalances($toAccount,$value,$date)) return false;
			}
			else if($toAccount)
			{
				// Check if the date changed.
				if($date != $oldDate)
				{
					// Update the value between the old date and the new date. We use the old value because we deal with value changes below.
					if($date < $oldDate)
					{
						if(!$this->_removeFromBalances($toAccount,$oldValue,$oldDate,$oldDate)) return false;
						if(!$this->_addToBalances($toAccount,$oldValue,$date,$oldDate)) return false;
					}
					else
					{
						if(!$this->_removeFromBalances($toAccount,$oldValue,$oldDate,$date)) return false;
						if(!$this->_addToBalances($toAccount,$oldValue,$date,$date)) return false;
					}
				}

				// Check if the value changed.
				if($oldValue != $value && !$this->_addToBalances($toAccount,$value-$oldValue,$date)) return false;
			}
		}
		else
		{
			// Inserting new transaction. Add the value to the balances for both accounts.
			if($fromAccount && !$this->_addToBalances($fromAccount,-$value,$date)) return false;
			if($toAccount && !$this->_addToBalances($toAccount,$value,$date)) return false;
		}
		return true;
	}

	function beforeDelete($cascade)
	{
		// If the transaction is pending, ignore.
		if($this->data[$this->alias]['status'] == 'P')
			return true;

		// Adjust balances as needed. First we get some essential fields.
		$fromAccount = $this->data[$this->alias]['from_account_id'];
		$toAccount = $this->data[$this->alias]['to_account_id'];
		$value = $this->data[$this->alias]['value'];
		$date = $this->data[$this->alias]['date'];

		if($fromAccount && !$this->_removeFromBalances($fromAccount,-$value,$date)) return false;
		if($toAccount && !$this->_removeFromBalances($toAccount,$value,$date)) return false;
		return true;
	}

	// Retrieve a list of transactions for a given account and a given date. Pending transactions are ignored.
	function listTransactions($account,$startDate = null,$endDate=null)
	{
		$transactions = array();

		$conditions = array ('OR'=> array('to_account_id'=>$account, 'from_account_id'=>$account),'status !='=>'P');
		if($startDate != null)
			$conditions['date >='] = $startDate;
		if($endDate != null)
			$conditions['date <='] = $endDate;

		// Get the results.
		$results = $this->find('all', array('conditions'=>$conditions,'order'=>'date'));

		// Now get the full path to the category of each transaction.
		if($results)
		{
			// Get the account's currency.
			$currency = $this->FromAccount->find('first',array('fields'=>'Currency.symbol','conditions'=>array('FromAccount.id'=>$account)));

			// Get the last balance.
			if(isset($startDate))
				$lastBalance = self::$balance->field('balance',array('account_id'=>$account,'date <'=>$startDate),'date DESC');
			else
				$lastBalance = 0;

			foreach($results as &$transaction)
			{
				// Group transactions by date.
				if(!array_key_exists($transaction[$this->alias]['date'],$transactions))
					$transactions[$transaction[$this->alias]['date']] = array();

				// Set the currency.
				$transaction[$this->alias]['currency'] = $currency['Currency']['symbol'];

				// Get the full path of the category.
				$pathList = $this->Category->getPath($transaction[$this->alias]['category_id'],'name');
				$path = array();
				for($i = 0; $i < count($pathList); $i++)
					array_push($path,$pathList[$i]['Category']['name']);
				$transaction['Category']['path'] = implode(':',$path);

				// Establish the name of the other account, if any. At the same time, adjust value sign
				// depending on whether the transaction is a credit or a debit for the current account.
				$fromAccount = $transaction[$this->alias]['from_account_id'];
				$toAccount = $transaction[$this->alias]['to_account_id'];
				if($fromAccount == $account)
				{
					$transaction[$this->alias]['other_account'] = $transaction['ToAccount']['name'];
					$transaction[$this->alias]['debit'] = $transaction[$this->alias]['value'];
					$transaction[$this->alias]['value'] = -$transaction[$this->alias]['value'];
				}
				else
				{
					$transaction[$this->alias]['other_account'] = $transaction['FromAccount']['name'];
                                        $transaction[$this->alias]['credit'] = $transaction[$this->alias]['value'];
				}

				// Calculate balance.
				$lastBalance += $transaction[$this->alias]['value'];
				$transaction[$this->alias]['balance'] = $lastBalance;

				// Finally, add the transaction to the list.
				array_push($transactions[$transaction[$this->alias]['date']],$transaction);
			}
		}
		return $transactions;
	}

	function listPending($account,$startDate = null,$endDate=null)
	{
	}

}
?>
