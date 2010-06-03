<?php

class TestController extends Enterprise_Controller {
	protected $_dba;
	protected $_date;
	public function init() {
		parent::init();
		$this->_dba = Zend_Registry::get('db');
		$this->_date = date("Y-m-d H:i:s", strtotime('-1 week'));
	}

	public function indexAction() {
	}

	public function __razAction() {
		$queries = array();
		$queries[] = "TRUNCATE TABLE user";
		$queries[] = "TRUNCATE TABLE profile";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(1, '2010-03-01 15:05:40', 'Pierre', 'Durand', 'us', 20, 2, 3, 4, 3, 5, 3, '1.0', '2.0', '1.0', '1.0', 'pierre.durand@mail.com', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', '356a192b7913b04c54574d18c28d46e6395428ab9da78baea3166eed5b30d84b6dbb2da26819ba37', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(2, '2010-03-01 15:05:40', 'Louis', 'Dupond', 'us', 18, 2, 3, 4, 3, 5, 2, '1.0', '2.0', '1.0', '1.0', 'louis.dupond@mail.com', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 'da4b9237bacccdf19c0760cab7aec4a8359010b045fd327dbd5a98daab72be389edfe0bcdb529af6', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(3, '2010-03-01 15:05:40', 'Lise', 'Lecourt', 'us', 45, 2, 3, 4, 3, 5, 3, '1.0', '2.0', '1.0', '1.0', 'lise.lecourt@mail.com', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', '77de68daecd823babbb58edb1c8e14d7106e83bb9f57265137d6512b85da5c2eb47ce8c9e31349f3', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(4, '2010-03-01 15:05:40', 'Karl', 'Soum', 'us', 21, 2, 3, 4, 3, 5, 1, '1.0', '2.0', '1.0', '1.0', 'karl.soum@mail.com', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', '1b6453892473a467d07372d45eb05abc2031647a549714d927217716bcee59e53d543bf01579d64a', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(5, '2010-03-01 15:05:40', 'Sophie', 'Lagrange', 'us', 40, 2, 3, 4, 3, 5, 3, '1.0', '2.0', '1.0', '1.0', 'sophie.lagrange@mail.com', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 'ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4911a360957e40c20f498f3c00237bdcb080fbc54', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(6, '2010-03-01 15:05:40', 'Colin', 'Maillard', 'us', 30, 2, 3, 4, 3, 5, 2, '1.0', '2.0', '1.0', '1.0', 'colin.maillard@mail.com', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 'c1dfd96eea8cc2b62785275bca38ac261256e2780a9cdf7b5195ff9be499d9df03e050c8c0003245', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(7, '2010-03-01 15:05:40', 'Paul', 'Fon', 'us', 30, 2, 3, 4, 3, 5, 1, '1.0', '2.0', '1.0', '1.0', 'paul.fon@mail.com', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', '902ba3cda1883801594b6e1b452790cc53948fda30a80677c37c68e8d98923b68dc995591b8b808b', 1)";
		$queries[] = "INSERT INTO `user` (`id`, `registration`, `firstName`, `lastName`, `lang`, `realAge`, `height`, `weight`, `gender`, `pregnancy`, `breastFeeding`, `lifeStyle`, `waterDrank`, `waterFood`, `waterLost`, `waterIdeal`, `email`, `mailing`, `coaching`, `password`, `loginDirect`, `valid`) VALUES(8, '2010-03-01 15:05:40', 'Germain', 'Testeur', 'us', 31, 2, 3, 4, 3, 5, 3, '1.0', '2.0', '1.0', '1.0', 'germain.testeur@mail.com', 1, 1, '5f4dcc3b5aa765d61d8327deb882cf99', 'fe5dbbcea5ce7e2988b8c69bcfdfde8904aabc1fb01ed7b89d3e40fd0267e3881e0692f16b7014f5', 1)";

		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-05 21:22:22', 2, 0, 25, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 2, 1, 22, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-05 21:22:22', 3, 0, 48, 15, 23, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 3, 1, 47, 15, 28, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 3, 2, 44, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-05 21:22:22', 7, 0, 48, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 7, 1, 47, 15, 22, 20, 28)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 7, 2, 44, 15, 25, 14, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 7, 3, 42, 15, 19, 22, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-05 21:22:22', 8, 0, 48, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 8, 1, 47, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 8, 2, 44, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 8, 3, 42, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-05 21:22:22', 4, 0, 40, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-05 21:22:22', 5, 0, 25, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 5, 1, 22, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-05 21:22:22', 6, 0, 48, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 6, 1, 47, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-06 21:22:22', 6, 2, 44, 15, 25, 20, 20)";
		$queries[] = "INSERT INTO profile (id, registration, userId, week, age, hydrat, intel, physic, spirit) VALUES ('', '2010-03-05 21:22:22', 1, 0, 40, 15, 25, 20, 20)";

		foreach ($queries as &$q) {
			$this->_dba->exec($q);
		}

		$query = "SELECT CONCAT(usr.firstName, ' ', usr.lastName) AS name, prf.week, usr.registration, usr.email
				  FROM user AS usr, profile AS prf
				  WHERE usr.id = prf.userId AND
				  prf.week IN (
					SELECT MAX( week )
					FROM profile
					WHERE userId = usr.id
					)";
		$result = $this->_dba->fetchAll($query);
		$this->view->date = $this->_date;
		$this->view->results = $result;
	}

	public function displayAction() {
		$query = "SELECT CONCAT(usr.firstName, ' ', usr.lastName) AS name, prf.week, usr.registration, usr.email
				  FROM user AS usr, profile AS prf
				  WHERE usr.id = prf.userId AND
				  prf.week IN (
					SELECT MAX( week )
					FROM profile
					WHERE userId = usr.id
					)";
		$result = $this->_dba->fetchAll($query);
		$this->view->date = $this->_date;
		$this->view->results = $result;
	}

	public function sevenAction() {
		$this->_dba->exec("UPDATE profile SET registration  = '{$this->_date}' WHERE 1");
		$this->_forward('display');

	}

	public function testamfAction() {
		$this->_helper->viewRenderer->setNoRender();
		$amf = new Default_Model_Amf();
		$params = new stdClass();
		$params->rate->hydrat = 1;
		$params->rate->age = 47;
		$params->userId = 1;
		Zend_Debug::dump($amf->week23($params));
		die();
	}

	public function testdirectloginAction() {
	}


	public function weekAction(){
		$this->_helper->viewRenderer->setNoRender();
		$params = new stdClass();
		$params->userId = 1;
		$amf = new Default_Model_Amf();

		Zend_Debug::dump($amf->week0($params));
		die();
	}


	public function testdlAction() {
		$this->_helper->viewRenderer->setNoRender();
		$amf = new Default_Model_Amf();
		$params = "1574bddb75c78a6fd2251d61e2993b5146201319d8db4a6ebf1be5c7e9d6be045064d6a2cdc26560";
		Zend_Debug::dump($amf->directLogin($params));
		die();
	}

	public function massAction() {
		$mail = new Enterprise_Mailer('UTF-8');
		$mailDatas = new stdClass();
		$mailDatas->lang = 'cn';
		$mailDatas->scriptName = 'youtube';
		$mailDatas->view->email = 'alex.chien@koocaa.com';
		$mailDatas->view->password = 'password';
		$mailDatas->view->userKey = 'password';
		$mail->build();
		$mail->render($mailDatas);
		die();
	}
	
	public function monitoringAction()
	{
		print_r($this->_request->getParams());	
		echo $this->_request->getParam('week');
		
		if ($this->_request->getParam('week') == '1') {
			
			echo '<br />--------------- 发送邮件 : 第一周 ---------------<br />';
			
			$mail = new Enterprise_Mailer('UTF-8');
			$mailDatas = new stdClass();
			$mailDatas->lang = 'cn';
			$mailDatas->scriptName = 'monitoring';
			$mailDatas->view->semaine = 'Monitoring: 第一周';
			$mailDatas->view->email = array('alex.chien@koocaa.com', 'alexchien97@gmail.com', 'johnsonqu@gmail.com');
			$mail->build();
			$mail->render($mailDatas);
			
		} else {
			
            echo '<br />--------------- 发送邮件 : 空周 ---------------<br />';
            
            $mail = new Enterprise_Mailer('UTF-8');
            $mailDatas = new stdClass();
            $mailDatas->lang = 'cn';
            $mailDatas->scriptName = 'monitoring';
            $mailDatas->view->semaine = 'Monitoring: 空周';
            $mailDatas->view->email = array('alex.chien@koocaa.com', 'alexchien97@gmail.com', 'johnsonqu@gmail.com');
            $mail->build();
            $mail->render($mailDatas);			
			
			
		}
	}
	
}


