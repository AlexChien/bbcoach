<?php

class Admin_Model_Upload extends Enterprise_Model {

	public function csv () {
		// datas week1 week2 week3
		$query = "SELECT
			  	  CONCAT(DAY(`user`.registration), '/', MONTH(`user`.registration), '/', YEAR(`user`.registration)),
				  IF (`user`.gender = 0, 'M', 'Mme/Mlle') as gender,
			  	  `user`.firstName,
			  	  `user`.lastName,
				  `user`.email,
			  	  `user`.realAge,
				  `user`.weight,
				  `user`.height,
				  `user`.lifeStyle,
				  `user`.waterDrank,
				  `user`.waterFood,
  				  GROUP_CONCAT(`profile`.age) AS age_by_week,
  				  `user`.mailing,
  				  `user`.lang
				FROM
				  `user`,
				  `profile`
				WHERE
				  `user`.id = `profile`.userId
				  GROUP BY
				  `user`.id,
				  `user`.firstName,
				  `user`.lastName,
				  `user`.realAge,
				  `user`.email";
		$result = $this->_db->fetchAll($query);
		$csv = "date d'enregistrement;civilité;prénom;nom;email;âge;poids;taille;style de vie;boisson;nourriture;évolution;opt-in;pays\r\n";
		foreach ($result as &$line) {
			$csv .= implode(';',(array)$line)."\r\n";
		}
		return utf8_decode($csv);
	}

}