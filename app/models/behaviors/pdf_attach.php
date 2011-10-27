<?php
class pdfAttachBehavior extends Modelbehavior{
	private $data;
	private $session;
	private $last_saved_file;
	
	function setUp(&$model, &$config){
		if (isset($config['data'])) {
			$this->data =& $config['data'];
			$this->session =& $config['session'];
		}
	}
	
	/**
	 * Validate form
	 * 
	 * @param $model
	 * @param $query
	 * @return boolean
	 */
	function beforeSave(&$model, $query){
		$fileTypeOK = false;
		$folder = "docfiles/";
	  	if(!empty($this->data['Document']['pdfAttach'])) {	
	  		$folder_path = WWW_ROOT.$folder;
	
	  		if(!is_dir($folder_path)) {
	  			mkdir($folder_path);
	  		}
	
	  		if(is_uploaded_file($this->data['Document']['pdfAttach']['tmp_name'])){
	  			$type = 'application/pdf';
	  			// check filetype is ok
  				if($type == $this->data['Document']['pdfAttach']['type']) {
  					$fileTypeOK = true;
  					$savedFile = move_uploaded_file($this->data['Document']['pdfAttach']['tmp_name'],
  					$folder_path . $this->data['Document']['pdfAttach']['name']);
  					$this->last_saved_file = $this->data['Document']['pdfAttach'];
  					unset($this->data['Document']['pdfAttach']);
  					return true;
  				}else{
	  				$this->session->setFlash('File type not allowed');
  				}
	  		}
	  	} else{
	  		$this->session->setFlash('A file is requiered');
	  	}
		return false;
	}
	
	function afterSave(&$model, $query){
		//print_r($model->id);
		return true;
	}
} 
?>