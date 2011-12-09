<?php

class SimilarityCoefficient extends AppModel {
    var $name = 'SimilarityCoefficient';
	     var $hasOne = array(
		 'Repository' => array( 
		 'className' => 'Repository',
		 'foreignKey' => 'repository_id',
		 'dependent' => false
		 )
	 ); 
}

?>
