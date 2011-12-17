<?php
class CheckTitlesController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckTitle';
	var $uses = array('Document', 'Repository');

	function check_title(){
		
	}
	function index(){
		 $q=$_GET["q"];
		 $repo = $this->requireRepository();
		 $id= $repo['Repository']['id'];
		
		 $result= $this->Document->find('count', array('conditions' =>array('Document.title' => $q,'Document.repository_id' => $id)));
		
		 if($result!=0){
		 	echo '<strong>There is already a document with similar title</strong>';
			die();
			}
		 else {
			 echo'';
			 die();
			 }
		 mysql_close($con);
		}
}
?>