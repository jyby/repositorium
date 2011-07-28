<?php
class Tag extends AppModel {
	var $name = 'Tag';
	var $primaryKey = 'asociacion_id';
	var $belongsTo = array(
      'Documento' => array(
        'className' => 'Documento',
        'foreignKey' => 'id_documento'
      ));
	var $validate = array(
		'tag' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'A tag cannot be empty.',
			),
		),
	);

	// devuelve la lista de documentos
	// dados por los tags
	function findDocumentsByTags($tags) {
  		$docs = array();
		foreach ($tags as $tag) {
			$tmp = $this->find('all', array(
		  		'conditions' => array(
					'Tag.tag' => $tag,
		  		), 
		  		'recursive' => -1, 
		  		'fields' => array('Tag.id_documento')
				)
			);
			
			$hola = array();			
			foreach($tmp as $t) {
		  		$hola[] = $t['Tag']['id_documento'];
			}
			$docs[] = $hola;	  
	  }
	  if(count($docs) > 0) {
	  	$res = $docs[0];
	  	for ($i = 1; $i < count($docs); $i++) {
	  		$res = array_intersect($res, $docs[$i]);
	  	}
	  } else {
	  	$res = $this->find('all', array(
	  		'fields' => 'DISTINCT Tag.id_documento',
	  		'recursive' => -1
	  		)
	  	);
	  }	 

	  return $res;
	}
}
?>
