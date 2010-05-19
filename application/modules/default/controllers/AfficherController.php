<?php

/**
 * AfficherController
 *
 * @author
 * @version
 */

require_once 'Zend/Controller/Action.php';

class AfficherController extends Enterprise_Controller {
	/**
	 * @desc there's no homepage for this controller, so we redirect to site homepage
	 */
	public function indexAction() {
		$this->_redirect('/');
	}

	/**
	 * @desc display email
	 * @param void
	 * @return void
	 */
	public function emailAction() {

		$this->_helper->viewRenderer->setNoRender();
		$datas = $this->_request->getQuery();

		#
		$templates = array();
		$templates[] = 'confirmation';
		$templates[] = 'semaine-1';
		$templates[] = 'semaine-1b';
		$templates[] = 'semaine-2';
		$templates[] = 'semaine-2b';
		$templates[] = 'semaine-3';
		$templates[] = 'semaine-3b';
		$templates[] = 'semaine-4';
		$templates[] = 'semaine-4b';
		$templates[] = 'semaine-5';
		$templates[] = 'youtube';
		# we verify if we have a valid identifier
		if(empty($datas['id']) || strlen($datas['id']) != 80) {
			$this->_redirect('/');
			die();
		}
		elseif(!in_array($datas['name'], $templates)) {
			$this->_redirect('/');
			die();
		}
		else {
			# 1rst - search userId
			$aff = new Default_Model_Affichage();
			$lang = $aff->user($datas['id']);

			# if there's no registered user, we go to homepage
			if(false === $lang) {
				$this->_redirect('/');
				die();
			}
			else {
				
				# display the mail
				$this->view->lang = $lang;
				$this->view->browser = true;
				$this->view->userKey = $datas['id'];
				$_texts = $aff->texts($lang, $datas['name']);
				
		        //   switch sur la lang pour header
		        switch ($lang) {
		            
		            case 'befl': case 'befr' : case 'nl' :
		                $this->view->top = 'top_challenge.jpg';
		            break;
		            
		            default:
		                $this->view->top = 'top.jpg';
		            break;
		        }
		         
				$texts = new stdClass();
				foreach ($_texts as $k=>$t) $texts->$k = $t;
				$this->view->texts = $texts;

				//	selection de la video si template youtube
				if ($datas['name'] == 'youtube') {
					$this->view->urlVideo = $this->view->texts->{video.$this->_request->getParam('day')};

				}

				$this->view->webhost = $this->_config->site->webhost;
				$this->view->tplname = $datas['name'];
				$this->view->setScriptPath($this->_config->mail->scriptsPath);
				$this->view->setHelperPath($this->_config->mail->helpersPath);

				$view = $this->view->render($datas['name'] . '.phtml');
				echo $view;
			}
		}
	}

}

