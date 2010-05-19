<?php

class Admin_Model_Identification extends Enterprise_Model {

	protected $_auth;
	public static function getIdentification($username, $password) {

		$adapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('db'));
		$adapter->setTableName('admin')->setIdentityColumn('username')->setCredentialColumn('password');
		$adapter->setIdentity($username)->setCredential(md5($password));
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($adapter);
		switch ($result->getCode()) {
			case Zend_Auth_Result::SUCCESS :
				$datas['user'] = $username;
				$storage = $auth->getStorage();
				$storage->write($datas);
				return true;
				break;
			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
			default :
				return false;
				break;
		}
		return false;
	}

}