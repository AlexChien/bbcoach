<?php

class UploadController extends Enterprise_Controller {

	public $path;
	public $userID;
	
    public function init() 
    {   	
        parent::init();
        $this->userID = intval($this->_request->getParam('userID'));   
    }
    
    /**
     * Upload une image sans passer par AMFPHP
     *
     * @param $bytesArray equivalent de $_FILES
     * 
     * @return boolean $bool  
     */
    public function loadAction()
    {
    	$this->path = "/images/upload/tmp"; 
    	if (is_array($_FILES['Filedata'])) {
	        // on concidere que l' upload a reussi (fichier temporaire)
	    	$upload = self::upload($_FILES['Filedata']);   
	    		
	    	$doUpload = new Default_Model_Photo();
	    	$insert = $doUpload->sauvegardeTmp($this->userID, $upload);
    	} 
    }

    /**
     * upload le fichier
     * @param array $file
     */
    function upload($file)
    {
    	
    	// le fichier
    	$fichier = basename($file['name']);

    	// les extentions & l' extention du fichier en cours
    	$extensions = array('.png', '.gif', '.jpg', '.jpeg');
    	$extension = strrchr($file['name'], '.'); 
		
    	// l'extention ne correspond po
    	if(!in_array($extension, $extensions)) {
		     return 'erreur=1';
		}
    	
		//    on tente le deplacement du fichier 
        if(move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$this->path.'/'.$this->userID.$extension)) {
            //  upload OK
            return $extension;
		} else {
            //  upload NOK
			return 'erreur=2';
		}		
		   	
    }
    
}