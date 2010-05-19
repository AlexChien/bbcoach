<?php

/**
 * @name Admin_UploadController
 * @desc controller for datas upload
 *
 * @author Pascal CESCATO
 * @copyright EuroRSCG
 */

class Admin_UploadController extends Enterprise_Controller {
	/**
	 * @desc upload datas in cvs format
	 */
	public function datasAction() {
		$datas = new Admin_Model_Upload();
		$this->view->datas = $datas->csv();
		$this->getResponse()
		->setHeader('Content-Disposition', 'attachment; filename=BBCoaches.csv')
		->setHeader('Content-Type', 'application/force-download')
		->setHeader('Content-Type', 'application/octet-stream')
		->setHeader('Content-Type', 'application/download')
		->setHeader('Content-Description', 'File Transfer');
	}
}

