<?php

/**
 * @name Default_Model_Validation
 * @desc validate user account and send mail
 * @author Pascal
 *
 */
class Default_Model_Validation extends Enterprise_Model {
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @desc validate user
	 * @param string $userKey
	 * @return boolean
	 */
	public function validate($userKey) {
		//TODO: more complex validation process: if user is already validated, send another message
		$datas = array('valid' => 1);
		$where = "loginDirect = '" . $userKey . "'";
		$validated = $this->_db->update('user', $datas, $where);
		$query = "SELECT email, lang, loginDirect FROM user WHERE " . $where;
		$result = $this->_db->fetchRow($query);
		$mail = ($validated == 1) ? self::sendNotification($result) : false;
		return $mail;
	}

	/**
	 * @desc send mail notification after account validation
	 * @param object $result
	 * @return boolean
	 */
	private static function sendNotification($result) {
		$mail = new Enterprise_Mailer();
		$mailDatas = new stdClass();
		$mailDatas->lang = $result->lang;
		$mailDatas->scriptName = 'semaine-1';
		$mailDatas->view->week = $mailDatas->scriptName;
		$mailDatas->view->email = $result->email;
		$mailDatas->view->userKey = $result->loginDirect;
		$mail->build();
		$mail->render($mailDatas);
		return true;
	}
}