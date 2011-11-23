<?php 
/* App schema generated on: 2011-11-23 09:37:01 : 1322066221*/
class AppSchema extends CakeSchema {
	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $account_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'ofx_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1)),
		'tableParameters' => array()
	);
	var $accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'account_type_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'financial_institution_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'currency_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'ofx_acctid' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'limit' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '19,4', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => array('user_id', 'name'), 'unique' => 1), 'account_type_id' => array('column' => 'account_type_id', 'unique' => 0), 'financial_institution_id' => array('column' => 'financial_institution_id', 'unique' => 0), 'currency_id' => array('column' => 'currency_id', 'unique' => 0)),
		'tableParameters' => array()
	);
	var $balances = array(
		'account_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'date' => array('type' => 'date', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'balance' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '19,4', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => array('account_id', 'date'), 'unique' => 1)),
		'tableParameters' => array()
	);
	var $categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => NULL, 'comment' => ''),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => NULL, 'comment' => ''),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name_parent' => array('column' => array('name', 'parent_id'), 'unique' => 1), 'parent_id' => array('column' => 'parent_id', 'unique' => 0)),
		'tableParameters' => array()
	);
	var $currencies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'symbol' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1), 'symbol' => array('column' => 'symbol', 'unique' => 1)),
		'tableParameters' => array()
	);
	var $financial_institutions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'ofx_bankid' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1)),
		'tableParameters' => array()
	);
	var $transactions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'from_account_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'to_account_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'date' => array('type' => 'date', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'value' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '19,4', 'collate' => NULL, 'comment' => ''),
		'payee' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'memo' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'ofx_fitid' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'last_modified' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'collate' => NULL, 'comment' => ''),
		'status' => array('type' => 'string', 'null' => false, 'length' => 1, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'from_account_id' => array('column' => 'from_account_id', 'unique' => 0), 'to_account_id' => array('column' => 'to_account_id', 'unique' => 0), 'category_id' => array('column' => 'category_id', 'unique' => 0)),
		'tableParameters' => array()
	);
	var $user_roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 2, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name' => array('column' => 'name', 'unique' => 1)),
		'tableParameters' => array()
	);
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'charset' => 'utf8'),
		'role' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'default_currency_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'username' => array('column' => 'username', 'unique' => 1), 'email' => array('column' => 'email', 'unique' => 1), 'default_currency_id' => array('column' => 'default_currency_id', 'unique' => 0), 'role' => array('column' => 'role', 'unique' => 0)),
		'tableParameters' => array()
	);
}
?>