<?php
/**
 * @name Default_Model_Photo
 * @desc model used to save img in mysql
 * @author Romain Calmon
 * @copyright BETC digital
 */
class Default_Model_Photo extends Enterprise_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Insert en base une photo
     *
     * @param int $userID
     * @param string $extention
     * @return bool
     */
    public function sauvegardeTmp($userID, $extention) 
    {	
        $result = $this->_db->insert('photo', array('userID' => $userID, 'extention' => $extention, 'valid' => '1'));
        if ($result=='1') {
        	return true;
        } else {
        	return false;
        }
    }
    
    /**
     * Verifie en base si une image existe
     *
     * @param int $userID
     */
    public function isImgExist($userID)
    {    	
    	$query = "SELECT extention FROM photo WHERE userID = ':userID' AND valid = '1'";
        $bind = array(':userID' => $userID);
        $result = $this->_db->fetchOne($query, $bind);
        //print_r($result);
    }
    
}