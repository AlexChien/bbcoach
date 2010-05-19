<?php

/**
 * @name ClientController
 * @desc CLI interface for emailing, launched by crontab
 *
 * @author PAscal CESCATO
 * @copyright EuroRSCG
 */

require_once 'Zend/Controller/Action.php';

class Cli_ClientController extends Zend_Controller_Action {

	protected $_config;
	public function init() {
		parent::init();
		$this->_helper->viewRenderer->setNoRender();
		$this->_config = Zend_Registry::get('config');
	}

	/**
	 * @desc send mail after 3 days
	 * @param void
	 * @return void
	 */
	public function semaineAction() {
		include_once(APPLICATION_PATH . '/modules/cli/models/Relance.php');
		new Cli_Model_Relance($this->_config->relance->firstMail, null);
	}

	/**
	 * @desc send mail after 7 days and each 7 days while week is not validated
	 * @param void
	 * @return void
	 */
	public function relanceAction() {
		include_once(APPLICATION_PATH . '/modules/cli/models/Relance.php');
		new Cli_Model_Relance($this->_config->relance->every, 'b');
	}

	/**
	 * send youtube mail every day in week 2
	 * @param void
	 * @return void
	 */
	public function youtubeAction() {
		# in this case Zend_Registry::get('week') will be used as day of the week in model
		include_once(APPLICATION_PATH . '/modules/cli/models/Youtube.php');
		new Cli_Model_Youtube();
	}
}