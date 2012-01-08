<?php
class CheckTextsController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckText';
	var $uses = array('Document', 'User', 'Repository', 'ConstituentsKit', 'Attachfile');

	function check_text(){
		
	}
	function index(){
		 $q=$_GET["q"];
		 $repo = $this->requireRepository();
		 $id= $repo['Repository']['id'];
		 $con = mysql_connect('localhost', 'root', '');
		 if (!$con){
		   die('Could not connect: ' . mysql_error());
		   }
		
		 mysql_select_db("repositorio", $con);
		
		 $sql="SELECT COUNT(*) FROM documents WHERE content= '".$q."' AND repository_id ='".$id."'";

		 $query = mysql_query($sql);
		 $result= mysql_result($query,0);

		 if($result!=0){
		 	echo '<strong>There is already a document with similar text</strong>';
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