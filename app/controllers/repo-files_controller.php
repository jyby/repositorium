<?php
/**
 * repo-files_controller.php
 *r
 * 
 * @package   controller
 * @author    Carlos Gajardo Maureira cgajardo@ing.uchile.cl
 * @copyright Copyright (c) 2011 
 */

class Repo-filesController extends AppController {

	var $helpers = array('Js' => array('Jquery'));
	var $uses = array('Document', 'Repo-file');
	
	/**
	 * Document Model
	 * @var Document
	 */
	var $Document;
	
	function download($id=null) {
		$repo = $this->requireRepository();
		
		if(is_null($id)) {
			exit();
		}
		
		Configure::write('debug', 0);
		$file = $this->Repo-file->findById($id);
		header('Content-type: ' . $file['Repo-file']['type']);
		header('Content-length: ' . $file['Repo-file']['size']); 
		header('Content-Disposition: attachment; filename="'.$file['Repo-file']['filename'].'"');
		echo $file['Repo-file']['content'];
		exit();
	}
}
?>
