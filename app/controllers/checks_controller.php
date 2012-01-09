<?php
class ChecksController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'Checks';
	var $uses = array('Document', 'User', 'Repository', 'ConstituentsKit', 'Attachfile');

	function check_title(){
		
	}
	function index(){
		 $q=$_GET["q"];
		 $con = mysql_connect('localhost', 'root', '');
		 if (!$con){
		   die('Could not connect: ' . mysql_error());
		   }
		
		 mysql_select_db("repositorium", $con);
		
		 $sql="select count(*) from documents where title= '".$q."'";
		
		 $query = mysql_query($sql);
		 $result= mysql_result($query,0);
		 if($result!=0){
		 	echo '<strong>There is already a document with similar title</strong>';
			}
		 die('');
		 mysql_close($con);
		}
}
?>