<?php

/**
 * TestController
 *
 * @author
 * @version
 */

require_once 'Zend/Controller/Action.php';

class Cli_TestController extends Zend_Controller_Action {

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

	public function razAction() {
		$date = date('Y-m-d H:i:s', strtotime("-1 week"));
		$queries = array();
		$queries[] = "TRUNCATE TABLE user";
		$queries[] = "TRUNCATE TABLE profile";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(1, '2010-03-01 15:05:40', 'Pierre', 'Durand', 'fr', 20, 2, 3, 4, 3, 5, 3, '1.0', '2.0', '1.0', '1.0', 'Aurelien.Vialet@betc.eurorscg.fr', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', '356a192b7913b04c54574d18c28d46e6395428ab9da78baea3166eed5b30d84b6dbb2da26819ba37', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(2, '2010-03-01 15:05:40', 'Louis', 'Dupond', 'fr', 18, 2, 3, 4, 3, 5, 2, '1.0', '2.0', '1.0', '1.0', 'noemie.atlan@betc.eurorscg.fr', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 'da4b9237bacccdf19c0760cab7aec4a8359010b045fd327dbd5a98daab72be389edfe0bcdb529af6', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(3, '2010-03-01 15:05:40', 'Lise', 'Lecourt', 'fr', 45, 2, 3, 4, 3, 5, 3, '1.0', '2.0', '1.0', '1.0', 'Gaston.Annebicque@betc.eurorscg.fr', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', '77de68daecd823babbb58edb1c8e14d7106e83bb9f57265137d6512b85da5c2eb47ce8c9e31349f3', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(4, '2010-03-01 15:05:40', 'Karl', 'Soum', 'fr', 21, 2, 3, 4, 3, 5, 1, '1.0', '2.0', '1.0', '1.0', 'Jeremy.Boutier@betc.eurorscg.fr', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', '1b6453892473a467d07372d45eb05abc2031647a549714d927217716bcee59e53d543bf01579d64a', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(5, '2010-03-01 15:05:40', 'Colin', 'Maillard', 'fr', 30, 2, 3, 4, 3, 5, 2, '1.0', '2.0', '1.0', '1.0', 'pascal.cescato@competences-web.fr', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 'c1dfd96eea8cc2b62785275bca38ac261256e2780a9cdf7b5195ff9be499d9df03e050c8c0003245', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(6, '2010-03-01 15:05:40', 'Paul', 'Fon', 'fr', 30, 2, 3, 4, 3, 5, 1, '1.0', '2.0', '1.0', '1.0', 'Julien.Peschard@betc.eurorscg.fr', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', '902ba3cda1883801594b6e1b452790cc53948fda30a80677c37c68e8d98923b68dc995591b8b808b', 1)";

		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '{$date}', 1, 0, 25, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '{$date}', 2, 0, 22, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '{$date}', 3, 0, 48, 15, 23, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '{$date}', 4, 0, 47, 15, 28, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '{$date}', 5, 0, 44, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '{$date}', 6, 0, 48, 15, 25, 20, 20)";
		$db = Zend_Registry::get('db');
		foreach ($queries as &$q) {
			$db->exec($q);
		}
	}
}