<?php
class CheckTagsController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckTag';
	var $uses = array('Document', 'Repository','Tag');

	function check_tag(){
		echo 'Entro al check_tag';
		//$this->redirect(array('controller' => 'documents', 'action' => 'download'));
		$q=$_GET["q"];
		$repo = $this->requireRepository();
		$id= $repo['Repository']['id'];
		
		$result= $this->Document->find('count', array('conditions' =>array('Document.title' => $q,'Document.repository_id' => $id)));
		
		if($result!=0){
		 	echo '<strong>There is already a document with similar title</strong>';
			die();
			}
		else{
			 echo'';
			 die();
			}
			die();
			//$this->redirect($this->referer());
	}
	function index(){
		echo 'En algun lado pidio el index de checktags_controller y no deberia!!';
	//die();
		 }
}