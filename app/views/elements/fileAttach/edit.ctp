<div style="clear: both; height: 10px;"></div>
<div class="input textarea required">
<label for="DocumentFile">File</label>
<?php 
	foreach($folios as $folio){
		// TODO cgajardo: improve to block unwanted downloads 
		echo "<a href='/repositorium/attachfiles/download/".$folio['Attachfile']['id']."'>".$folio['Attachfile']['filename']."</a>";
	} 
?>
</div>
<div style="clear: both; height: 10px;"></div>