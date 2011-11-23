<?php
App::uses('Sanitize', 'Utility');

class ImportController extends AppController {
	var $name = 'Import';
	var $uses = array('Account','AccountType','FinancialInstitution','Category','Transaction','Wizard.Wizard');
	var $components = array('Import');//,'Wizard.Wizard');

	function beforeFilter()
	{
		//$this->Wizard->steps = array('file', 'account', 'category', 'security', 'price', 'transaction', 'memorized', 'budget', 'bill');
	}

	function wizard($step = null)
	{
		//$this->Wizard->process($step);
		$this->_processFile();
		$this->render('index');
	}

	function confirm()
	{
	}

        private function _importAccounts(&$list)
        {
                $results = array();
                foreach($list as $name => $properties)
                {
                        // First try to find out if there already exists an account with matching name.
                        $account = $this->Account->find('first',array('conditions'=>array('Account.name'=>Sanitize::escape($name),'Account.user_id'=>$this->Auth->user('id'))));
                        if(!$account)
                        {
                                // Find the account type.
                                switch($properties['T'])
                                {
				case 'MONEYMRKT':
				case 'Invst':
				case 'Port':
                                        $accountType = $this->AccountType->field('id',array('AccountType.ofx_type'=>'MONEYMRKT'));
					break;
				
				case 'SAVINGS':
				case 'Savings':
                                        $accountType = $this->AccountType->field('id',array('AccountType.ofx_type'=>'SAVINGS'));
					break;
				
				case 'CREDITLINE':
				case 'CCard':
                                        $accountType = $this->AccountType->field('id',array('AccountType.ofx_type'=>'CREDITLINE'));
					break;

				case 'Oth A':
					$accountType = $this->AccountType->field('id',array('AccountType.name'=>'Asset'));
					break;
				
				
				case 'Oth L':
                                        $accountType = $this->AccountType->field('id',array('AccountType.name'=>'Liability'));
					break;
				
                                case 'CHECKING':
                                case 'Bank':
                                case 'Cash':
				// For now, Oth A and Oth L stay here, as default.
				default:
                                        $accountType = $this->AccountType->field('id',array('AccountType.ofx_type'=>'CHECKING'));
                                        break;
                                }

                                // Find the institution.
				// Since QIF contains no institution data, this is left as unknown.
                                $financialInstitution = $this->FinancialInstitution->field('id',array('FinancialInstitution.name'=>'UNKNOWN'));

                                // Create a fresh model object.
                                $this->Account->create(array(
                                        'user_id'=>$this->Auth->user('id'),
                                        'name'=>Sanitize::escape($name),
                                        'account_type_id'=>$accountType,
                                        'financial_institution_id'=>$financialInstitution,
                                        'currency_id'=>$this->Auth->user('default_currency_id')
                                ));

				// If the account has a limit, store it.
				if( array_key_exists( 'L', $properties ) )
				{
					$limit = floatval(str_replace(',', '', Sanitize::clean($properties['L'])));
					$this->Account->set('limit',$limit);
				}

				// Save the account in the database.
                                $this->Account->save();
                                //array_push($results,"Account ".$name." created.");
                        }
                        //else
                                //array_push($results,"Account ".$name." already exists, skipping.");
                }

                return $results;
        }

	private function _importCategories(&$list)
	{
		$results = array();
		foreach($list as $name => $properties)
		{
			// Split the properties by lines.
			$tokens = preg_split("/\n/",$properties,-1,PREG_SPLIT_NO_EMPTY);

			foreach( $tokens as $token )
			{
				// Split each line into the first letter and the rest.
				$key = substr($token,0,1);
				$value = rtrim(substr($token,1));

				// Now analyze each property.
				switch( $key )
				{
				case 'N': // Name
					$hierarchy = preg_split("/:/",Sanitize::escape($value),-1,PREG_SPLIT_NO_EMPTY);
					$category = Sanitize::clean($value);
					break;
				case 'D': // Description.
					//$description = Sanitize::escape($value);
				case 'T': // Tax-related?
				case 'R': // IRS code?
				case 'E': // Expense
				case 'I': // Income
				case 'B': // TODO: Budget - ignored for now.
				default:
					// Ignore some properties.
					break;
				}
			}

			// Create category hierarchy.
			//array_push($results,"Processing category $category");
			$parent_id = null;
			foreach( $hierarchy as $node )
			{
				// Check if the node exists.
				$cat = $this->Category->find('first',array('conditions'=>array('Category.parent_id'=>$parent_id,'Category.name'=>$node)));
				if(!$cat)
				{
					// Category does not exist, create.
					$newCategory = array();
					$newCategory['Category']['parent_id'] = $parent_id;
					$newCategory['Category']['name'] = $node;
					$this->Category->create();
					$this->Category->save($newCategory);
					$parent_id = $this->Category->id;

					//array_push($results,"Category $category - creating $node");
				}
				else
				{
					//array_push($results,"Category $category - $node already exists");
					$parent_id = $cat['Category']['id'];
				}
			}

			//array_push($results,"Created category $category");
		}	
			
		return $results;
	}

	private function _importTransactions(&$list)
	{
		$results = array();
		// Import transactions. TODO: make imported transactions pending.
		foreach($list as $accountName => $transactions)
                {
			$newTransactionList = array();

			// Find the account id by name.
			$accountId = $this->Account->field('id',array('name'=>Sanitize::escape($accountName)));

/////////////////////////////////////////////////////////////////////////////////////////////
			// TODO: We're going to skip investment accounts for now.
			$accountTypeId = $this->Account->field('account_type_id',array('id'=>$accountId));
			if( $accountTypeId == 3 )
				continue;
/////////////////////////////////////////////////////////////////////////////////////////////

			// If the number of transactions is over a threshold, increase the php time limit.
			if( count($transactions) > 1000 )
			{
				set_time_limit(60);
				ini_set("memory_limit","64M");
			}

			foreach($transactions as $transaction)
			{
				// Reset the values.
				$date = null;
				$ammount = null;
				$payee = null;
				$memo = null;
				$otherAccountId = null;
				$category = null;
				$status = null;

                        	// Split the properties by lines.
                        	$tokens = preg_split("/\n/",$transaction,-1,PREG_SPLIT_NO_EMPTY);

	                        foreach( $tokens as $token )
	                        {
	                                // Split each line into the first letter and the rest.
	                                $key = substr($token,0,1);
	                                $value = rtrim(substr($token,1));

	                                // Now analyze each property.
	                                switch( $key )
	                                {
	                                case 'D': // Date
						$date = $this->Import->parseQifDate($value);
	                                        break;
	                                case 'T': // Ammount
						$ammount = $this->Import->parseMoney($value);
						break;
	                                case 'P': // Payee
						$payee = Sanitize::escape($value);
						break;
	                                case 'M': // Memo
						$memo = Sanitize::escape($value);
						break;
	                                case 'L': // Category (or transfer)
						// First we check if this is a transfer.
						if(preg_match("/^\\[(.+)\\]$/",$value))
						{
							$transfer = trim($value,"[]");
							// If this is a transfer to the same account, this is probably the opening balance, so we
							// leave the other account as empty. If not, find the other account`s id. 
							if($transfer != $accountName)
								$otherAccountId = $this->Account->field('id',array('name'=>Sanitize::escape($transfer)));
						}
						else
						{
							// If this is not a transfer, find out the id of the category.
							$hierarchy = preg_split("/:/",Sanitize::escape($value),-1,PREG_SPLIT_NO_EMPTY);
							foreach($hierarchy as $level)
								$category = $this->Category->field('id',array('Category.parent_id'=>$category,'Category.name'=>$level));
						}
						break;
	                                case 'C': // Cleared status
						if($value == '*'||$value == 'c'||$value == 'C')
							$status = 'C';
						else if($value == 'X'||$value == 'x'||$value == 'R'||$value == 'r')
							$status = 'R';
						else
							$status = 'P';

						break;
					case 'I': // Share price (for security transactions).
					case 'Y': // Security name.
					case 'Q': // Quantity of shares.
					case 'O': // Commission cost.
					case 'N': // Check number or operation type.
						// TODO: ignored for now.
	                                default:
	                                        // Ignore some properties.
	                                        break;
	                                }
	                        }

				// Prepare to store the transaction.
				$newTransaction = array();
				if($ammount == null)
					continue;
				// TODO: for now we skip transactions with no value, but investments may have some.
				//	array_push($results,array('date'=>$date,'ammount'=>$ammount,'payee'=>$payee,'memo'=>$memo,'category'=>$category,'acc'=>$otherAccountId,'status'=>$status));
					
				if($ammount < 0)
				{
					// This is the From account.
					$newTransaction['from_account_id'] = $accountId;
					$newTransaction['value'] = -$ammount;
					if($otherAccountId)
						$newTransaction['to_account_id'] = $otherAccountId;
				}
				else
				{
					// This is the To account.
					$newTransaction['to_account_id'] = $accountId;
					$newTransaction['value'] = $ammount;
					if($otherAccountId)
						$newTransaction['from_account_id'] = $otherAccountId;
				}
				$newTransaction['date'] = $date;

				if($payee)
					$newTransaction['payee'] = $payee;

				if($category)
					$newTransaction['category_id'] = $category;

				if($memo)
					$newTransaction['memo'] = $memo;

				if($status)
					$newTransaction['status'] = $status;

				// Check if the transaction already exists - this may be a duplicate.
				$conditions = array(
					'from_account_id' => array_key_exists('from_account_id',$newTransaction)?$newTransaction['from_account_id']:null,
					'to_account_id' =>  array_key_exists('to_account_id',$newTransaction)?$newTransaction['to_account_id']:null,
					'value' => $newTransaction['value'],
				);
				if($this->Transaction->find('count',array('conditions'=>$conditions)) > 0)
				{
					// This is probably a duplicate. Force marking it as pending.
					// TODO: find a better solution to this.
					$newTransaction['status'] = 'P';

					//if(!array_key_exists($accountName,$results))
					//	$results[$accountName] = array();
					//array_push($results[$accountName],array('date'=>$date,'ammount'=>$ammount,'payee'=>$payee,'memo'=>$memo,'category'=>$category,'acc'=>$otherAccountId,'status'=>$status));
				}
				//else
				array_push($newTransactionList,$newTransaction);
				//if(!array_key_exists($accountName,$results))
				//	$results[$accountName] = array();
				//$i++;
				//if($i%10 == 0)
				//	array_push($results[$accountName],array('date'=>$date,'ammount'=>$ammount,'payee'=>$payee,'memo'=>$memo,'category'=>$category,'acc'=>$otherAccountId,'status'=>$status));
	                }
			$results[$accountName] = $this->Transaction->saveAll(array_values($newTransactionList));
		}
		return $results;
	}

	private function _processFile() {
		if($this->data) {
			$fileDescription = $this->data['Import']['File'];

			// Check if the file uploaded successfully.
			if ((!isset($fileDescription['error']) || $fileDescription['error'] != 0) &&
			    (empty( $fileDescription['tmp_name']) || $fileDescription['tmp_name'] == 'none')) {
				$this->Session->setFlash('File upload failed');
				return false;
			}

			// Read the file.
			$file = file_get_contents($fileDescription['tmp_name']);

			// Try to convert the file to UTF-8.
			$file = mb_convert_encoding($file, 'UTF-8', mb_detect_encoding($file, 'UTF-8, ISO-8859-1', true));

			// If the file is a QIF or an OFX 1.x, convert it.
			if(preg_match('/\.qif$/i',$fileDescription['name'])) {
				$parsed = $this->Import->parseQif($file);

				// We start by counting the total ammount of entries.
				foreach($parsed as $type => $section)
				{
					switch ($type)
					{
					case "tags":
						// Tags are currently not supported.
						break;

					case "categories":
						$import['categories'] = $this->_importCategories( $section );
						break;

					case "securities":
					case "memorized":
					case "prices":
						break;

					case "accounts":
						$import['accounts'] = $this->_importAccounts( $section );
						break;

					case "transactions":
						$import['transactions'] = $this->_importTransactions( $section );
						break;
					}
				}
			}
			//else if(preg_match('^OFXHEADER',$file)) {
			//	$file = $this->Import->ofx1ToOfx2($file);
			//}

			$this->set(compact('import'));

			// Redirect to the next step.
			return false;
		}
	}

	private function _afterComplete()
	{
	}
}
?>
