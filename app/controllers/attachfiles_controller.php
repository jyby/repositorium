<?php
/**
 * Attachfiles_controller.php
 *r
 * 
 * @package   controller
 * @author    Carlos Gajardo Maureira cgajardo@ing.uchile.cl
 * @copyright Copyright (c) 2011 
 */

class AttachfilesController extends AppController {

	var $helpers = array('Js' => array('Jquery'));
	var $uses = array('Document', 'Attachfile');
	
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
		$file = $this->Attachfile->findById($id);
		header('Content-type: ' . $file['Attachfile']['type']);
		header('Content-length: ' . $file['Attachfile']['size']); 
		header('Content-Disposition: attachment; filename="'.$file['Attachfile']['filename'].'"');
		echo $file['Attachfile']['content'];
		exit();
	}
}
?>
