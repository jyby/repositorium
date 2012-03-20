<?php
App::import('Model', 'Attachfile');
class attachFileBehavior extends Modelbehavior{
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
  		$this->fileData = $this->data['files'];
  		if(count($this->fileData) <= 1){
  			return false;
  		}
  		return true;
	}
	
	function afterSave(&$model, $query){
		$files_tmp=array();
		foreach ($this->fileData as $file){
			if($file['error']==4){
				continue;
			}
			if($file['size'] > 0) {
				$newfolio = new Attachfile();
				$newfolio->set('filename',$file['name']);
				$newfolio->set('type',$file['type']);
				$newfolio->set('size',$file['size']);
				$newfolio->set('document_id',$model->id);
					
				// prepare file for blob
				$fp      = fopen($file['tmp_name'], 'r');
				$content = fread($fp, filesize($file['tmp_name']));
				fclose($fp);
					
				$newfolio->set('content',$content);
				
				if(!$newfolio->save()){
					$this->session->setFlash('Error saving file: '.$file['name']);
					return false;
				}
			} else{
				$this->session->setFlash('A file is requiered');
				return false;
			}
		}
		return true;
	}
} 
?>