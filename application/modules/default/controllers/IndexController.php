<?php

class IndexController extends Enterprise_Controller {

	public function init() {
		parent::init();
	}

	/**
	 * @desc default action
	 * with _resquest->getParam in order to see if there's something particular to do
	 */
	public function indexAction() {
		# add lang param to lauch flash in the right lang
		if($this->_request->getParam('lang')) {
			$this->view->userLang = $this->_request->getParam('lang');
		}
		
		// force lang to Chinese
		$this->view->userLang = 'cn';

		if($this->_request->getParam('userKey')) {
			$this->view->userKey = $this->_request->getParam('userKey');
		}
		elseif($this->_request->getParam('validKey')) {
			$this->view->validKey = $this->_request->getParam('validKey');
			$validation = new Default_Model_Validation();
			$validation->validate($this->_request->getParam('validKey'));
		}
		elseif($this->_request->getParam('facebook')) {
			
			$key = $this->_request->getParam('facebook');

			// added for age
			$age = null;
			if($this->_request->getParam('age')) $age = (int) $this->_request->getParam('age');

			$this->view->facebookKey = $key;
			$facebook = new Default_Model_Facebook();
			$param = (!empty($key) && is_numeric($key)) ? 'id' : 'lang';

			// modified for age
			//$datas = $facebook->getTexts($key, $param);
			$datas = $facebook->getTexts($key, $param, $age);
			$this->view->lang = ($param == 'lang') ? $key : $datas->lang;
			$this->view->title = $datas->title;
			$this->view->metaname = $datas->metaname;
					
			//   suivant la langue l' img pour facebook est differente.
		    switch (trim($this->view->lang)) {
                
                case 'befl': case 'befr': case 'nl':
                    $this->view->fbimg = 'evian_lvc_fb.jpg';
                break;
                
                default:
                    $this->view->fbimg = 'evian_lvt_fb.jpg';
                break;
            }

			
		}
	}
	
	/**
	 * Action de suppression d' un profile 
	 * acces depuis un e-mail
	 */
	public function unsubscribeAction() {
	
	     //  $this->_helper->viewRenderer->setNoRender();
	     
	     //    on recuperre la clef de l' user & la langue
	     $urlID    = $this->_getParam('id', 0);
	     $lang   = $this->_getParam('lang', 0);
	
	     //    et on suprime le profil pour la des-insciption
	     $user = new Default_Model_Amf;
	     $unset = $user->unsubscribeNl($urlID);
	     
	     //    si suppression
	     if($unset===true) {
			$file = APPLICATION_PATH . '/configs/langs/' . $lang . '/emails.ini';
			$texts = new Zend_Config_Ini($file, 'mail');
			
			//   sortie brut de pomme
			echo $texts->unsubscribeSuccess;        	
	     }
	
	 }

}