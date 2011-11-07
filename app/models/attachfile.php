<?php
class Attachfile extends AppModel {
	var $name = 'Attachfile';
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