<?php

/**
 * @name Admin_IndexController
 * @desc Admin index controller
 * @author Pascal CESCATO
 * @copyright EuroRSCG
 * @version
 */

class Admin_IndexController extends Enterprise_Controller {
	/**
	 * The default action - show the home page for admin module
	 */
	public function indexAction() {
		# nothing to do, just display the page with link inside
	}

	public function identificationAction() {
		$formConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/identification.ini');
		$form = new Zend_Form($formConfig);
		if($this->_request->isPost()) {
			$username = $this->_request->getParam('username');
			$password = $this->_request->getParam('password');

			if(!empty($username) && !empty($password)) {
				$this->view->identity = Admin_Model_Identification::getIdentification($username, $password);
			}
		}
		$this->view->form = $form;
	}

}