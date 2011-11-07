<label for="AttachFile">File(s):</label>
<?php 
	foreach($files as $file){
		// TODO cgajardo: improve to block unwanted downloads 
		echo "<a href='/repositorium/attachfiles/download/".$file['Attachfile']['id']."'>".$file['Attachfile']['filename']."</a></br>";
	} 
?>
