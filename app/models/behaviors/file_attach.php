<?php
App::import('Model', 'Folio');
class fileAttachBehavior extends Modelbehavior{
	private $data;
	private $session;
	private $fileData;
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
  		$this->fileData = $this->data['Document']['fileAttach'];
  		return true;
	}
	
	function afterSave(&$model, $query){
		if($this->fileData['size'] > 0) {
			$newfolio = new Folio();
			$newfolio->set('filename',$this->fileData['name']);
			$newfolio->set('type',$this->fileData['type']);
			$newfolio->set('size',$this->fileData['size']);
			$newfolio->set('document_id',$model->id);
			
			// prepare file for blob
			$fp      = fopen($this->fileData['tmp_name'], 'r');
			$content = fread($fp, filesize($this->fileData['tmp_name']));
			//$content = addslashes($content);
			fclose($fp);
			
			$newfolio->set('content',$content);
			if($newfolio->save())
				return true;
		} else{
			$this->session->setFlash('A file is requiered');
			return false;
		}
		
		return false;
	}
} 
?>