<?php 
	echo $this->Form->input('Document.content', array('class' => 'ingresar-documento', 'label' => 'Content', 'rows' => 14, 'cols' => 80, 'default' => '', 'onChange'=>'CheckContent(DocumentContent.value)'));
?>