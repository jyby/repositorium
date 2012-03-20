<?php
class CheckTitlesController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckTitle';
	var $uses = array('Document', 'Repository');

	function check_title(){
		//echo 'Entro al check_title';
		 $this->layout = '';
		 $this->autoRender = false;
		//$this->redirect(array('controller' => 'documents', 'action' => 'download'));
		$q=$_GET["q"];
		$repo = $this->requireRepository();
		$id= $repo['Repository']['id'];
		
		$result= $this->Document->find('count', array('conditions' =>array('Document.title' => trim($q),'Document.repository_id' => $id)));
		
		if($result!=0){
		 	echo '<strong>A document with a similar title already exists</strong>';
			//return false;
			die();
			}
		else{
			 echo'';
			 //return false;
			 die();
			}
			die();
			//$this->redirect($this->referer());
	}
	function index(){
		echo 'En algun lado pidio el index de checktitles_controller y no deberia!!';
	//die();
		 // $q=$_GET["q"];
		 // $repo = $this->requireRepository();
		 // $id= $repo['Repository']['id'];
		
		 // $result= $this->Document->find('count', array('conditions' =>array('Document.title' => $q,'Document.repository_id' => $id)));
		
		 // if($result!=0){
		 	// echo '<strong>There is already a document with similar title</strong>';
			// die();
			// }
		 // else {
			 // echo'';
			 // die();
			 // }
		 }
}
?>