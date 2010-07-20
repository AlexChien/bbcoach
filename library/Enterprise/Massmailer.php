<?php

class Enterprise_Massmailer {

	protected $_config;
	protected $_imagesPath;
	protected $_document;
	protected $_scriptName;
	protected $_texts;
	protected $mail;
	protected $_day;

	public function __construct($scriptName, $day=null) {

		if ($day != null) {
			$this->_day = $day;
		}
		$this->_scriptName = $scriptName;
		$this->_config = Zend_Registry::get('config');

		# init $this->_texts
		$this->_texts = new stdClass();
		
		$smtp_cfg = array('auth' => $this->_config->mail->auth,
		                'username' => $this->_config->mail->username,
		                'password' => $this->_config->mail->password);
		// echo 'auth: '. var_dump($this->_config->mail->auth);
		// echo 'username: '. var_dump($this->_config->mail->username);
		// echo 'password: '. var_dump($this->_config->mail->password);
		// exit;
		// 
		// $smtp_cfg = array('auth' => 'login',
		//                 'username' => 'alex.chien@koocaa.com',
		//                 'password' => 'alexgemalexgem');
		

		$transport = new Zend_Mail_Transport_Smtp($this->_config->mail->smtp,$smtp_cfg);
		
		Zend_Mail::setDefaultTransport($transport);
		Zend_Mail::setDefaultFrom($this->_config->mail->addressFrom, $this->_config->mail->labelFrom);

		$langs = Zend_Registry::get('db')->fetchCol('SELECT DISTINCT(`lang`) FROM `user`');
		foreach ($langs as $lang) {
			$file = APPLICATION_PATH . '/configs/langs/' . $lang . '/emails.ini';
			$this->_texts->$lang = new Zend_Config_Ini($file, $this->_scriptName);
		}
	}

	/**
	 * @desc prepare emailing for each user
	 * @param object $users
	 * @return void
	 */
	public function sendAll($users) {
		$startCounter = count($users);
		$endCounter = 0;
		foreach ($users as $user) {
			$datas = $user;
			$this->_render($datas);
			++$endCounter;
		}
		if($startCounter == $endCounter) {
			$result = date('Y-m-d H:i:s') . ';all mails sent';
			$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../datas/logs/eventlog.csv');
			$logger = new Zend_Log($writer);
			$logger->info($result);
		}
		else {
			$result = date('Y-m-d H:i:s') . ';' . $endCounter . 'mails sent / ' . $startCounter;
			$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../datas/logs/errorlog.csv');
			$logger = new Zend_Log($writer);
			$logger->info($result);
		}
	}

	/**
	 * @desc create each mail object and send it to user
	 * @param object $datas
	 * @return void
	 */
	private function _render($datas) {

		$this->mail = new Zend_Mail('UTF-8');

		$view = new Zend_View();
		$view->setScriptPath($this->_config->mail->scriptsPath);
		$view->setHelperPath($this->_config->mail->helpersPath);
		$view->tplname = $this->_scriptName;

		$lang = $datas->lang;
		$view->texts = $this->_texts->$lang;

		//    switch sur la lang pour header
		switch ($datas->lang) {
			
			case 'befl': case 'befr' : case 'nl' :
                		$view->top = 'top_challenge.jpg';
			break;
			
			default:
                		$view->top = 'top.jpg';
			break;
		}
		//	selection de la video si template youtube
    if ($this->_scriptName == 'youtube') {
      if ($this->_day){
        $view->urlVideo = $view->texts->{video.$this->_day};
        $view->day = $this->_day;
      }
      else{
        $day = Zend_Registry::get('week');
        $video = 'video'.$day;
        $view->urlVideo = $view->texts->$video;
        $view->day = $day;
      }
		}

		$view->assign((array) $datas);
		$view->webhost = $this->_config->site->webhost;

		$this->_document = $view->render($this->_scriptName . '.phtml');

		$this->mail->setHeaderEncoding(Zend_Mime::ENCODING_BASE64);
		// $this->mail->setSubject(utf8_decode($view->texts->subject));
		$this->mail->setSubject($view->texts->subject);
		$this->mail->setBodyHtml($this->_document);
		$this->mail->addTo($datas->email, $datas->firstName);
		$this->mail->send();
	}

}
