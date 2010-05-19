<?php

class Enterprise_Controller extends Zend_Controller_Action {

	protected $_auth;
	protected $_config;

	public function init() {
		parent::init();
		Zend_Session::start();
		$this->_config = Zend_Registry::get('config');
		$this->_auth = Zend_Auth::getInstance();
		$this->view->webhost = $this->_config->site->webhost;
		$models = $this->_request->getParam('module') . '/models';
		set_include_path('../application/modules/' . $models . PATH_SEPARATOR . get_include_path());
	}
}