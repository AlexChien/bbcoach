<?php

/**
 * @name AmfController
 * @desc main amf server controller, all treatments between flash and zend framework application go throw the Zend_Amf_Server
 * @author Pascal CESCATO
 * @copyright Pascal CESCATO & 4D-euroSCG
 * @version 1.0
 */

class AmfController extends Enterprise_Controller {

	/**
	 * @var object $server
	 */
	protected $server;

	/**
	 * @desc init the Zend_Amf_Server
	 */
	public function init() {
		parent::init();
		$this->_helper->viewRenderer->setNoRender();
		$this->server = new Zend_Amf_Server();
		$this->server->setProduction(true);
	}

	public function indexAction() {
		$this->server->addDirectory(APPLICATION_PATH . '/modules/default/');
		$this->server->setClass('Default_Model_Amf');
		echo ($this->server->handle());
	}

}