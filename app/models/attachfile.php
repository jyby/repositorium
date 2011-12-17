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
		//devuelve la cantidad de archivos del documento nuevo que ya existen
	function findFilesCount($repo_id = null, $files = array()) {
			if(is_null($repo_id)) {
			return null;
		}
		//echo '<pre>';
		//echo 'El files que le llego a findFilesCount es el siguiente';
		//print_r($files);
		//echo '</pre>';
				$docs = array();
		foreach ($files as $file) {
			$tmp = $this->find('all', array(
			  		'conditions' => array(
						'Attachfile.filename' => $file,
						'Document.repository_id' => $repo_id
					),
			  		'fields' => array('Attachfile.document_id')
				)
			);
				
			$hola = array();
			foreach($tmp as $t) {
				$hola[] = $t['Attachfile']['document_id'];
			}
			$docs[] = $hola;
		}
				if(count($docs) > 0) {
				//echo 'Entro al if de count>0';
				//echo '<pre>';
				//echo '$docs es:';
				//print_r($docs);
				//echo '</pre>';
		}

		return count($docs);
	}
	function fallar(){
		print("fail");
	}
	
}
?>