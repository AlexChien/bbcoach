<?php

/**
 * logsController
 *
 * @author
 * @version
 */

require_once 'Zend/Controller/Action.php';

class Admin_logsController extends Enterprise_Controller {
	public function indexAction() {
	}

	public function errorlogAction() {
		$this->_forward('displaylog', 'logs', 'admin', array('log' => 'error'));
	}

	public function eventlogAction() {
		$this->_forward('displaylog', 'logs', 'admin', array('log' => 'event'));
	}

	public function displaylogAction() {
		$this->view->log = $this->_getParam('log');
		$this->view->datas = new Admin_Model_Logs($this->_getParam('log'));
	}

}

