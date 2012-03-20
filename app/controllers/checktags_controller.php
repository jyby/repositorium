<?php
class CheckTagsController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckTag';
	var $uses = array('Document', 'Repository','Tag');
	/**
	 * Document Model
	 * @var Document
	 */
	var $Document;
	
	function check_tag(){
		// echo 'Entro al check_tag';
		// echo '<pre>';
		// print_r($_GET);
		// echo '</pre>';
		
		//$this->redirect(array('controller' => 'documents', 'action' => 'download'));
		$q=$_GET["q"];
		// echo 'El Q que llego es:';
		// echo $q;
		$tags = explode(',', $q);
		$repo = $this->requireRepository();
		$id= $repo['Repository']['id'];
		//$tags_val=$this->Tag->findTagsCount($id, $tags);
		//$tags_val=$this->Document->Tag->findTagsCount($id, $tags);
		//$tags_val=$Document->Tag->findTagsCount($id, $tags);
		$tags_val=$this->Tag->findTagsCount($id, $tags,'');
		//echo $tags_val;
		///$result= $this->Document->find('count', array('conditions' =>array('Document.title' => $q,'Document.repository_id' => $id)));
		
		if($tags_val > 0){
		 	echo '<strong>There are already '.$tags_val.' document(s) with the same tags</strong>';
			die();
			}
		else{
			 echo'<strong>Tags are ok</strong>';
			 //echo'<strong>There are no problem with your tags</strong>';
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