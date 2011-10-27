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
	  	if(!empty($this->data['Document']['fileAttach'])) {
	  		$fileData = $this->data['Document']['fileAttach'];
	  		//$newfolio = new Folio();
	  		//$newfolio->save();
	  		//print_r($newfolio);
	  		//$newfolio->set('filename','carlos');
	  		//$newfolio->save();
	  		//$newfolio = array('Folio'=> array('filename'=>'carlos', 'size' => '8'));
	  		//$this->Folio->set('filename','carlos');
	  		//$this->Folio->save();
// 	  		$model->Folio->create();
// 	  		$model->Folio->set('filename','carlos');
// 			$model->Folio->set('size','carlos');
// 			$model->Folio->set('type','txt');
			//$this->File->set('content',);
			//$this->File->set('documents_id',);
	  		//$model->save($newfolio);
// 			if($model->save($newfolio)){
// 				print("guarde");
// 			} else{
// 				print("falle");
// 			}
	  		
	  		//$this->data['Document']['fileAttach']
	  	} else{
	  		$this->session->setFlash('A file is requiered');
	  	}
		return false;
	}
	
	function afterSave(&$model, $query){
		//print_r($model->id);
		print_r($fileData);
		return true;
	}
} 
?>