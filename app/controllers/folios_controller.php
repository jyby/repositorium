<?php
/**
 * folios_controller.php
 *r
 * 
 * @package   controller
 * @author    Carlos Gajardo Maureira cgajardo@ing.uchile.cl
 * @copyright Copyright (c) 2011 
 */

class FoliosController extends AppController {

	var $helpers = array('Js' => array('Jquery'));
	var $uses = array('Document', 'Folio');
	
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
		$file = $this->Folio->findById($id);
		header('Content-type: ' . $file['Folio']['type']);
		header('Content-length: ' . $file['Folio']['size']); 
		header('Content-Disposition: attachment; filename="'.$file['Folio']['filename'].'"');
		echo $file['Folio']['content'];
		exit();
	}
}
?>
