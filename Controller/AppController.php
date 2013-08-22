<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
        public $components = array(
                'Auth' => array(
                        'loginRedirect' => array('controller' => 'accounts', 'action' => 'index'),
                        'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
                        'ajaxLogin' => '../Users/login'
                        ),
                'Session',
                'RequestHandler');
//		'DebugKit.Toolbar');
        var $helpers = array(
                'Js' => array('Jquery'),
                'Session',
                'Form',
                'Html',
                'Number');

//      function beforeFilter()
//      {
//              parent::beforeFilter();
//              $this->set('isAjax',$this->RequestHandler->isAjax());
//      }

        function isAuthorized($account)
        {
                $accountId = Sanitize::escape($account);

                $this->loadModel('Account');
                $this->Account->id = $accountId;
                if( $this->Account->field('user_id') == $this->Auth->user('id') )
                        return true;

                return false;
        }
}
