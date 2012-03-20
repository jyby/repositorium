<?php

class WarnedDocument extends AppModel {
    var $name = 'WarnedDocument';
	var $belongsTo = array(
	'WarningCreator' => array(
	'className' => 'Document',
	'foreignKey' => 'id_created_warning_document'
	),
	'PrevExisting' => array(
	'className' => 'Document',
	'foreignKey' => 'id_existing_document'
	)
    );
}

?>
