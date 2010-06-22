<?php

class Cli_Model_Relance {

	/**
	 * @desc create Massmailer object and send mails
	 */
	public function __construct($interval, $type) {
		$scriptName = 'semaine-' . Zend_Registry::get('week') . $type;
		$mail = new Enterprise_Massmailer($scriptName);
		$result = self::_getUsers($interval, $type);
		if(is_array($result)) {
			$mail->sendAll($result);
		}
		else {
			# error log
			$result = date('Y-m-d H:i:s'). ';' . $result;
			$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../datas/logs/errorlog.csv');
			$logger = new Zend_Log($writer);
			$logger->info($result);
		}
	}

	/**
	 * @desc get users for mailings (3days and each week mailing)
	 * @param void
	 * @return object $result
	 */
	private static function _getUsers($interval, $relance) {
		$query = "SELECT distinct usr.firstName, usr.email, usr.lang, usr.loginDirect as userKey
		  		  FROM profile AS prf, user AS usr
				  WHERE usr.id = prf.userId
				  AND usr.coaching = 1";
		# conditionnal line:
		# for first of each week email, $relance = null (empty), so we just take rows with registration date < :interval
		# for reminder email, which is sent every :interval days, $relance = b (not empty)
		$query .= (empty($relance)) ? " AND DATEDIFF(NOW(), prf.registration) = :interval" : " AND MOD(DATEDIFF(NOW(), prf.registration ), :interval ) = 0";
		$query .= " AND week = :week
				      AND prf.userId NOT IN (
					    SELECT userId
					    FROM profile
					    WHERE userId = usr.id
					    AND week > :week
					  )";
		# TODO verify if condition has to be "Zend_Registry::get('week')" OR "Zend_Registry::get('week')-1"
		$bind = array(':week' => Zend_Registry::get('week') - 1, ':interval' => $interval);
		try {
			$result = Zend_Registry::get('db')->fetchAll($query, $bind);
// $gdbo = Zend_Registry::get('db');
// echo var_dump($gdbo);
// echo var_dump($query);
// echo var_dump($bind);
// echo var_dump($result);exit;
		} catch (Exception $e) {
			$result = $e->getMessage();
		}
		return $result;
	}
}