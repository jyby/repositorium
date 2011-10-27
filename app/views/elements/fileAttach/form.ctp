<div class="input required">
<label for="DocumentFileAttach">Attach a File</label>
<?php
	echo $this->Form->create('Document', array('action' => 'add', 'type' => 'file', 'class' => 'input'));
	echo $this->Form->file('fileAttach');
?>
</div>