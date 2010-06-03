<?php

class Enterprise_Mailer extends Zend_Mail {

	protected $_config;
	protected $_imagesPath;
	protected $_document;
	protected $_scriptName;
	
	public function init($opt) {
		parent::init($opt);
	}

	public function build() {
		$this->_config = Zend_Registry::get('config');
		$smtp_cfg = array('auth' => $this->_config->mail->auth,
		                'username' => $this->_config->mail->username,
		                'password' => $this->_config->mail->password);
		$transport = new Zend_Mail_Transport_Smtp($this->_config->mail->smtp, $smtp_cfg);
		$this->setDefaultTransport($transport);
		
	}

	public function render($datas) {

		$this->_scriptName = $datas->scriptName;
		# html mail
		//	needed: email, passwd, scriptname
		$file = APPLICATION_PATH . '/configs/langs/' . $datas->lang . '/emails.ini';

		$texts = new Zend_Config_Ini($file, $this->_scriptName);
		$view = new Zend_View();
		$view->setScriptPath($this->_config->mail->scriptsPath);
		$view->setHelperPath($this->_config->mail->helpersPath);
		
		//    switch sur la lang pour header
		switch ($datas->lang) {
			
			case 'befl': case 'befr' : case 'nl' :
                $view->top = 'top_challenge.jpg';
			break;
			
			default:
                $view->top = 'top.jpg';
			break;
		}

		//	$texts->lang = $datas->lang;
		$view->texts = $texts;
		$view->lang = $datas->lang;
		$view->assign((array) $datas->view);
		$view->webhost = $this->_config->site->webhost;
		$view->tplname = $this->_scriptName;
        	
		//    on gere le setFrom ici car localisé
        	$this->setFrom($this->_config->mail->addressFrom, $this->_config->mail->labelFrom);
        
		$this->view->lang = $datas->lang;
		
       		$this->_document = $view->render($this->_scriptName . '.phtml');

		$this->setHeaderEncoding(Zend_Mime::ENCODING_BASE64);
		// $this->setSubject(utf8_decode($texts->subject));
		$this->setSubject($texts->subject, 'utf-8');
		$this->setBodyHtml($this->_document, 'utf-8');
		$this->addTo($datas->view->email);

		$this->send();
	}

}
