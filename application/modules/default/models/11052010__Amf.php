<?php

/**
 * @name Amf
 * @desc amf class contains all amf called methods
 * @author Pascal CESCATO
 * @copyright Pascal CESCATO & 4D-euroSCG
 */
class Default_Model_Amf extends Enterprise_Model {

	/**
	 * @var object $amfObject
	 * @desc this object is returned to the Amf_Server and sent to Amf module
	 */
	protected $amfObject;
	/**
	 * @desc construction de l'objet amf renvoyé par les public methods
	 */
	public function __construct() {
		parent::__construct();
		$this->amfObject = new stdClass();
	}

	/**
	 * @param object $params
	 * @return object $this->amfObject
	 */
	public function directLogin($params) {
		$query = "SELECT id AS userId, lang
				  FROM user
				  WHERE loginDirect = :loginDirect
				  AND valid = 1";
		$bind = (is_object($params)) ? array(':loginDirect' => $params->userKey) : array(':loginDirect' => $params);
		//$bind = array(':loginDirect' => $params->userKey);
		$result = $this->_db->fetchRow($query, $bind);
		if(!empty($result)) {
			$this->amfObject->userId = (string) $result->userId;
			$this->amfObject->lang = $result->lang;
			$this->amfObject->week = (int) $this->setWeek($result->userId);
			return $this->amfObject;
		}
		else {
			return false;
		}
	}

	/**
	 * @param object $params
	 * @return object $this->amfObject
	 */
	public function normalLogin($params) {
		$query = "SELECT id AS userId, lang
				  FROM user
				  WHERE email = :email
				  AND password = :password
				  AND valid = 1";
		$bind = array(':email' => $params->email, ':password' => md5($params->pass));
		$result = $this->_db->fetchRow($query, $bind);
		if(!empty($result)) {
			$this->amfObject->userId = (string) $result->userId;
			$this->amfObject->lang = $result->lang;
			$this->amfObject->week = (int) $this->setWeek($result->userId);
		}
		else {
			$this->amfObject->found = false;
		}
		return $this->amfObject;
	}

	/**
     *  supprime le profil d'un user 
	 *
	 * @param int $ID
	 */
    public function unsubscribeNl($ID) {
    	
    	// on recuperre l' id de l' user
    	$query = "SELECT id AS userId
                  FROM user
                  WHERE loginDirect = :id";
        $bind = array(':id' => $ID);
    	$result = $this->_db->fetchRow($query, $bind);
    	
    	if(!empty($result)) {

			$userID = $result->userId;
			
			// on suprime ses enregistrements dans la table profile
			$queryDel = "DELETE FROM profile where userId = :userID";
			$bindDel = array(':userID' => $userID);	
			$this->_db->query($queryDel, $bindDel);
			
            //  lol
            return true;
			
    	} else {
    		return false;
    	}
    	
    }
	
	
	
	/**
	 * @param object $params
	 * @return object $this->amfObject
	 */
	public function unlog($params) {
		//
	}

	/**
	 * @param object $params
	 * @return object $this->amfObject
	 */
	public function week0($params) {
		$datas = (array) $params->rate;
		$datas['week'] = 0;
		$datas['registration'] = null;
		$datas['userId'] = (int) $params->userId;
		$this->registerWeek($datas, $datas['userId']);
		$id = 'id = ' . $params->userId;
		$datas = (array) $params->db;
		$affectedRows = $this->_db->update('user', $datas, $id);
		$this->amfObject->success = ($affectedRows == 1) ? true : false;
		return $this->amfObject;
	}

	/**
	 * @param object $params
	 */
	public function week1($params) {
		$datas = (array) $params->rate;
		$datas['week'] = 1;
		$this->registerWeek($datas, $params->userId);
		$this->amfObject->success = true;
		return $this->amfObject;
	}

	/**
	 * @param object $params
	 */
	public function week2($params) {
		$query = "SELECT hydrat, age, intel, physic, spirit FROM profile WHERE userId = :userId and week = 1";
		$bind = array(':userId' => $params->userId);
		$result = $this->_db->fetchRow($query, $bind);
		$datas = (array) $result;
		$datas['week'] = 2;
		$this->registerWeek($datas, $params->userId);
		$this->amfObject->success = true;
		return $this->amfObject;
	}

	/**
	 * @param object $params
	 */
	public function week23($params) {
		$datas = (array) $params->rate;
		$datas['week'] = 2;
		$this->registerWeek($datas, $params->userId);
		//
		$datas['week'] = 3;
		$this->registerWeek($datas, $params->userId);
		
		$this->amfObject->success = true;
		return $this->amfObject;
	}

	/**
	 * @param object $params
	 */
	public function week3($params) {
		$datas = (array) $params->rate;
		$datas['week'] = 3;
		$this->registerWeek($datas, $params->userId);
		$this->amfObject->success = true;
		return $this->amfObject;
	}

	/**
	 *
	 * @param object $params
	 */
	public function week4($params) {
		$datas = (array) $params->rate;
		$datas['week'] = 4;
		$this->registerWeek($datas, $params->userId);
		$this->amfObject->success = true;
		return $this->amfObject;
	}

	/**
	 * @param object $params
	 */
	public function week5($params) {
		$datas = (array) $params->rate;
		$datas['week'] = 5;
		$this->registerWeek($datas, $params->userId);
		$this->amfObject->success = true;
		return $this->amfObject;
	}

	/**
	 * @param object $params
	 * @return object $this->amfObject
	 */
	public function profil($params) {
		$tmp = strtotime('-1 week');
		$date = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m', $tmp), date('d', $tmp), date('Y', $tmp)));
		$bind = array(':userId' => $params->userId);	

		$query = "SELECT usr.firstName, usr.lastName, usr.realAge, usr.height, usr.weight, usr.gender, usr.lifeStyle,
				  prf.hydrat, prf.intel, prf.spirit, prf.physic
				  FROM user AS usr, profile AS prf
				  WHERE usr.id = prf.userId
				  AND usr.id = :userId
				  AND  prf.week = ";
		$query .= $params->week;
				 /* IN (
					SELECT MAX( week )
					FROM profile
					WHERE userId = :userId
					)";*/
		$result = $this->_db->fetchRow($query, $bind);

		# here is evolution array datas
		$query = "SELECT age
				  FROM profile
				  WHERE userId = :userId
				  ORDER BY week ASC";
		$subResult = $this->_db->fetchCol($query, $bind);

		$this->amfObject = $result;
		$this->amfObject->evolution = $subResult;

		return $this->amfObject;
	}

	/**
	 * @desc DB registration for all weeks
	 * @param array $datas
	 */
	private function registerWeek($datas, $userId) {
		$query = "SELECT COUNT(*) AS rst
				  FROM profile
				  WHERE userId = :userId AND
				  week = :week";
		$bind = array(':userId' => $userId, ':week' => $datas['week']);
		$result = $this->_db->fetchOne($query, $bind);
		if($result == 1) {
			$where[] = 'userId =' . $userId;
			$where[] = 'week =' . $datas['week'];
			$a = $this->_db->update('profile', $datas, $where);
		}
		else {
			$datas['userId'] = $userId;
			$datas['registration'] = null;
			$this->_db->insert('profile', $datas);

		}

		return;
	}

	/**
	 * @param object $params
	 * @return object $this->amfObject
	 */
	public function registration($params) {
		$isId = (empty($params->userId)) ? false : true;
		# added ->registration for correct MySQL timestamp when inserting in `user` table
		switch ($isId) {
			case false : # new row
				$query = "SELECT COUNT(*) FROM user WHERE email = :email";
				$bind = array(':email' => $params->email);
				$result = $this->_db->fetchOne($query, $bind);
				if($result == 0) {
					$aParams = (array) $params;
					$aParams['registration'] = null;
					$aParams['password'] = md5($params->password);
					$committed = $this->_db->insert('user', $aParams);
				}
				else {
					$committed = 0;
				}
				if($committed == 1) {
					$datas = array();
					$this->amfObject->userId = $this->_db->lastInsertId();
					$this->amfObject->success = true;
					$id = 'id = ' . $this->amfObject->userId;
					# calculating value passed in _GET for direct login, and update the row in `user` table
					$datas['loginDirect'] = sha1($this->amfObject->userId) . sha1($params->email);
					$this->_db->update('user', $datas, $id);

					self::sendNotification($params, $datas['loginDirect']);
				}
				else {
					$this->amfObject->success = false;
					$this->amfObject->error = true;
				}
				break;
			case true : # update existing row
				$aParams = (array) $params;
				$aParams['registration'] = null;
				$aParams['password'] = md5($params->password);

				$id = 'id = ' . $params->userId;
				# calculating value passed in _GET for direct login, and update the row in `user` table
				$aParams['loginDirect'] = sha1($this->amfObject->userId) . sha1($params->email);
				if($this->_db->update('user', $aParams, $id)) {
					$this->amfObject->userId = $params->userId;
					$this->amfObject->success = true;
					self::sendNotification($params, $aParams['loginDirect']);
				}
				else {
					$this->amfObject->success = false;
					$this->amfObject->error = true;
				}
				break;
		}
		return $this->amfObject;
	}

	/**
	 * @desc calculate the week id from registration (must be registration +7d) and from last registered week
	 * @return int $week
	 */
	private function setWeek($userId) {
		$query = "SELECT week, registration
				  FROM profile
				  WHERE userId = :userId
				  AND week
				  IN (
					SELECT MAX( week )
					FROM profile
					WHERE userId = :userId
					)";
		$bind = array(':userId' => $userId);
		$result = $this->_db->fetchRow($query, $bind);
		$week = (strtotime($result->registration) > strtotime("-1 week") && $result->week > 0) ? $result->week : $result->week + 1;
		return $week;
	}

	private static function sendNotification($datas, $loginDirect) {
		$mail = new Enterprise_Mailer('UTF-8');
		$mailDatas = new stdClass();
		$mailDatas->lang = $datas->lang;
		$mailDatas->scriptName = 'confirmation';
		$mailDatas->view->email = $datas->email;
		$mailDatas->view->password = $datas->password;
		$mailDatas->view->userKey = $loginDirect;
		$mail->build();
		$mail->render($mailDatas);
	}
	
	/**
	 * function d'upload via amfphp
	 *
	 * @param std_class $data
     * 
     * @return boolean $bool 
	 */
	private function upload($data) 
	{
		return $data;		
	}

}