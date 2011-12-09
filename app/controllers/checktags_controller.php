<?php
class CheckTagsController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'CheckTags';
	var $uses = array('Document', 'User', 'Repository', 'ConstituentsKit', 'Attachfile');

	function check_tag(){
		
	}
	function index(){
		 $q=$_GET["q"];
		 $con = mysql_connect('localhost', 'root', '');
		 if (!$con){
		   die('Could not connect: ' . mysql_error());
		   }
		   
		 mysql_select_db("repositorio", $con);
		
		 //por modificar segun nueva estructura de datos para tags
		 $sql="select count(*) from tags where tag= '".$q."'";
		
		 $query = mysql_query($sql);
		 $result= mysql_result($query,0);
		 if($result!=0){
		 	echo '<strong>There is already a document with similar tags</strong>';
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