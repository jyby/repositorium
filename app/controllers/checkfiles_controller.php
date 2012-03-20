<?php
class CheckFilesController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckFile';
	var $uses = array('Document', 'Repository','Attachfile');

	function check_file(){
		echo 'Entro al check_file';
		//$this->redirect(array('controller' => 'documents', 'action' => 'download'));
		$q=$_GET["q"];
		echo $q;
		$repo = $this->requireRepository();
		$id= $repo['Repository']['id'];
		
		$result= $this->Document->find('count', array('conditions' =>array('Document.title' => $q,'Document.repository_id' => $id)));
		
		if($result!=0){
		 	echo '<strong>A document with a similar file already exists</strong>';
			die();
			}
		else{
			 echo'Llego al else de check file algo esta como el ......';
			 die();
			}
			die();
			//$this->redirect($this->referer());
	}
	function index(){
		echo 'En algun lado pidio el index de checkfiles_controller y no deberia!!';
	//die();
		 }
}
?>