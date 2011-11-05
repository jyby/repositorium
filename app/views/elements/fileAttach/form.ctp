<div class="input required">
<label for="DocumentFileAttach">Attach a File</label>
<?php
	$javascript->link('multifile.js', false);
?>
</div>

<!--  ensayo -->
<input id="attached_files" type="file" name="attachedfile_1" >
</br>
Files:
<!-- This is where the output will appear -->
<div id="files_list"></div>
<script>
	<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
	var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 3 );
	<!-- Pass in the file element -->
	multi_selector.addElement( document.getElementById( 'attached_files' ) );
</script>