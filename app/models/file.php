<?php
class File extends AppModel {
	var $name = 'file';
	var $displayField = 'file';

	var $belongsTo = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
}
?>