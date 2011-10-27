<?php
class Folio extends AppModel {
	var $name = 'Folio';
	var $displayField = 'filename';

	var $belongsTo = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function fallar(){
		print("fail");
	}
	
}
?>