<?php

/**
 * @name Default_Model_Affichage
 * @desc model used to display emails in browser
 * @author Pascal CESCATO
 * @copyright Pascal CESCATO & 4D-euroSCG
 */
class Default_Model_Affichage extends Enterprise_Model {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * @desc search for user and return lang
	 * @param unknown_type $loginDirect
	 * @return boolean(flase) or string($val)
	 */
	public function user($loginDirect) {
		$query = "SELECT lang
				  FROM user
				  WHERE loginDirect = :loginDirect
				  AND valid = 1";
		$bind = array(':loginDirect' => $loginDirect);
		$result = $this->_db->fetchOne($query, $bind);
		$val = (empty($result)) ? false : $result;
		return $val;
	}

	/**
	 * @desc take texts in ini files, depending on lang and section choosed
	 * @param string $lang
	 * @param string $section
	 * @return object $texts
	 */
	public function texts($lang, $section) {
		$file = APPLICATION_PATH . '/configs/langs/' . $lang . '/emails.ini';
		$texts = new Zend_Config_Ini($file, $section);
		return $texts;
	}

}