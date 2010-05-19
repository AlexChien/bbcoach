<?php

/**
 * @name Cli_Model_Youtube
 * @desc retrieve all users for each day of week 2 in order to send them an email
 * @author Pascal CESCATO
 * @copyright EuroRSCG
 *
 */
class Cli_Model_Youtube {

	/**
	 * @desc create Massmailer object and send mails
	 */
	public function __construct() {
		$mail = new Enterprise_Massmailer('youtube');
		$result = self::_getUsers();
		if(is_array($result)) {
			$mail->sendAll($result);
		}
		else {
			# error log
			$result = date('Y-m-d H:i:s') . ';' . $result;
			$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../datas/logs/errorlog.csv');
			$logger = new Zend_Log($writer);
			$logger->info($result);
		}
	}

	/**
	 * @desc get users for second week
	 * @param void
	 * @return object $result
	 */
	private static function _getUsers() {
		$query = "SELECT usr.firstName, usr.email, usr.lang, usr.loginDirect as userKey
		  		  FROM profile AS prf, user AS usr
				  WHERE usr.id = prf.userId
				  AND usr.coaching = 1
				  AND DATEDIFF( NOW( ) , prf.registration ) = :day
				  AND week = 2
				  AND prf.userId NOT IN (
					  SELECT userId
					  FROM profile
					  WHERE userId = usr.id
					  AND week > 2
					  )";
		$bind = array(':week' => Zend_Registry::get('week'));
		try {
			$result = Zend_Registry::get('db')->fetchAll($query, $bind);
		} catch (Exception $e) {
			$result = $e->getMessage();
		}
		return $result;
	}
}