<?php
class ChecksController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'Checks';
	var $uses = array('Document', 'User', 'Repository', 'ConstituentsKit', 'Attachfile');

	function check_title(){
		 $q=$_GET["q"];
		 $con = mysql_connect('localhost', 'root', '');
		 if (!$con)
		   {
		   die('Could not connect: ' . mysql_error());
		   }
		
		 mysql_select_db("repositorium", $con);
		
		 $sql="COUNT id FROM documents WHERE documents.title = '".$q."'";
		
		 $result = mysql_query($sql);
		 if($result!=0){
				echo 'divTitle.innerHTML=There is already a document with similar title';
			}
		
		 mysql_close($con);
	}
	function index(){
		}
}
?>