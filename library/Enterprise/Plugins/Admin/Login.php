<?php

class Enterprise_Plugins_Admin_Login extends Zend_Controller_Plugin_Abstract {
	protected $_auth;
	public function __construct() {
		$this->_auth = Zend_Auth::getInstance();
	}
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$module = $this->_request->getParam('module');
		if($module == 'admin') {
			# $this->_auth->referer : pour reprendre les opérations sans passer par l'index
			if(empty($this->_auth->referer)) {
				$uri = $this->getRequest()->getRequestUri();
				$this->_auth->referer = $uri;
			}
			else {
				$uri = $this->_auth->referer;
			}
			if(!$this->_auth->hasIdentity()) {
				// not yet authenticated
				if(strpos($uri, 'login') === false) {
					$request->setModuleName('admin');
					$request->setControllerName('index');
					$request->setActionName('identification');
				}
			}
			else {
				// already authenticated
				$this->getRequest()->setRequestUri($uri);
			}
		}
	}
}