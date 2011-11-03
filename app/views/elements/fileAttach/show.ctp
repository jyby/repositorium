<label for="DocumentFile">File</label>
<?php 
	foreach($files as $file){
		// TODO cgajardo: improve to block unwanted downloads 
		echo "<a href='/repositorium/folios/download/".$file['Folio']['id']."'>".$file['Folio']['filename']."</a>";
	} 
?>
