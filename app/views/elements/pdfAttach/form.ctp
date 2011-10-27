<div class="input required">
<label for="DocumentPdfAttach">Attach a PDF file</label>
<?php
	echo $this->Form->create('Document', array('action' => 'add', 'type' => 'file', 'class' => 'input'));
	echo $this->Form->file('pdfAttach');
?>
</div>