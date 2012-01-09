<?php
class CheckContentsController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckText';
	var $uses = array('Document', 'User', 'Repository', 'ConstituentsKit', 'Attachfile');

	function check_text(){
		
	}
	function index(){
		//echo 'Entro al check_text(index todavia)';
		$q=$_GET["q"];
		$repo = $this->requireRepository();
		$id= $repo['Repository']['id'];

		$result= $this->Document->find('count', array('conditions' =>array('Document.content' => trim($q),'Document.repository_id' => $id )));
		
		if($result!=0){
		 	echo '<p class=error><strong>A document with a similar text already exists</strong></p>';
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