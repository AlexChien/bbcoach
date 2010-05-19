<?php

class PhotoController extends Enterprise_Controller {
	
    public $path;
    public $userID;
	public $retour;
	
    public function init() 
    {
        parent::init();

        //  @todo mettre ça dans config.ini        
        $this->path = "/images/upload/"; 
        $this->userID = intval($this->_request->getParam('userID'));
        
    }
    
    public function getImg($userID, $folder)
    {
        //    si le parametre est un int
        if (is_int($userID)) {        	
            /*
			$photo = new Default_Model_Photo();
            $photo->isImgExist($this->userID);
        	*/
        	// on va chercher le media en BDD (extention)
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->path.$folder.'/'.$this->userID.'.jpg')) {
                $url = 'http://'.$_SERVER['SERVER_NAME'].$this->path.$folder.'/'.$this->userID.'.jpg';
                return 'retour=1&img='.$url;
            } else {        
                return 'retour=0&img=imgdoesn\'texist';
            }
        }
    	
    }
    
    /**
     * affiche la photo tmp pour l' upload
     * 
    */
    public function tmpAction() 
    {
    	 //  on appel la bonne methode
        $this->view->msg = self::getImg($this->userID, 'tmp');  
    }
    
    /**
     * affiche la photo tmp pour l' upload
     * 
    */
    public function detailAction() 
    {
         //  on appel la bonne methode
        $this->view->msg = self::getImg($this->userID, 'detail');           
    }
        
    /**
     * affiche la photo tmp pour l' upload
     * 
    */
    public function fullAction() 
    {
         //  on appel la bonne methode
        $this->view->msg = self::getImg($this->userID, 'full');            
    }    
    
}