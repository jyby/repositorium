<?php
class CheckContentsController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckText';
	var $uses = array('Document', 'User', 'Repository', 'ConstituentsKit', 'Attachfile');

	function check_text(){
		
	}
	function index(){
		 $q=$_GET["q"];
		 $repo = $this->requireRepository();
		 $id= $repo['Repository']['id'];

		 $result= $this->Document->find('count', array('conditions' =>array('Document.content' => $q,'Document.repository_id' => $id )));
		
		 if($result!=0){
		 	echo '<p class=error><strong>There is already a document with similar text</strong></p>';
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