<?php

class Default_Model_Facebook extends Enterprise_Model {

	public function init() {
		parent::init();
	}

	// added param age
	public function getTexts($key, $param, $age) {
		$section = ($param == 'lang' && !empty($age)) ? 'agelang' : $param;
		if($param == 'id') {
			$datas = $this->_getId($key);

			// modification for age
			if(!empty($age)) $datas->age = $age;
			$lang = $datas->lang;
		}
		else {
			$lang = $key;
		}
		$file = APPLICATION_PATH . '/configs/langs/' . $lang . '/facebook.ini';
		$texts = new Zend_Config_Ini($file, $section);
		$viewTexts = new stdClass();
		$viewTexts->lang = $lang;
		if(!empty($datas) && $section = 'id') {
			$viewTexts->title = sprintf($texts->title, $datas->firstName, $datas->age);
			$viewTexts->metaname = sprintf($texts->metaname, $datas->intel, $datas->physic, $datas->spirit);
		}
		elseif($section == 'age') {
			$viewTexts->title = $texts->title;
			$viewTexts->metaname = $texts->metaname;
			$viewTexts->lang = $lang;
		}
		elseif($section == 'agelang') {
			$viewTexts->title = sprintf($texts->title, $age);
			$viewTexts->metaname = $texts->metaname;
			$viewTexts->lang = $lang;
		}
		else {
			$viewTexts->title = $texts->title;
			$viewTexts->metaname = $texts->metaname;
			$viewTexts->lang = $lang;
		}
		return $viewTexts;
	}

	private function _getId($id) {
		$bind = array(':userId' => $id);
		$query = "SELECT usr.firstName, usr.lastName, usr.realAge, usr.height, usr.weight, usr.gender, usr.lifeStyle, usr.lang,
				  prf.week, prf.registration, prf.age, prf.intel, prf.spirit, prf.physic
				  FROM user AS usr, profile AS prf
				  WHERE usr.id = prf.userId
				  AND usr.id = :userId
				  AND  prf.week
				  IN (
					SELECT MAX( week )
					FROM profile
					WHERE userId = :userId
					)";
		$result = $this->_db->fetchRow($query, $bind);
		return $result;
	}

}