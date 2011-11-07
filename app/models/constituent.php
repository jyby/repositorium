<?php
class Constituent extends AppModel {
	var $name = 'Constituent';
	var $displayField = 'name';

	var $hasMany = array(
		'ConstituentsKit' => array(
			'className' => 'ConstituentsKit',
			'foreignKey' => 'constituent_id',
			'dependent' => true,
		)
	);
	
	
	// Method to find list with one key and many values
	// @author: http://nuts-and-bolts-of-cakephp.com/2008/09/04/findlist-with-three-or-combined-fields/
	function find($type, $options = array()) {
		switch ($type) {
			case 'superlist':
				if(!isset($options['fields']) || count($options['fields']) < 3) {
					return parent::find('list', $options);
				}
	
				if(!isset($options['separator'])) {
					$options['separator'] = ' ';
				}
	
				$options['recursive'] = -1;
				$list = parent::find('all', $options);
	
				for($i = 1; $i <= 2; $i++) {
					$field[$i] = str_replace($this->alias.'.', '', $options['fields'][$i]);
				}
	
				return Set::combine($list, '{n}.'.$this->alias.'.'.$this->primaryKey,
				array('%s'.$options['separator'].'%s',
	                                       '{n}.'.$this->alias.'.'.$field[1],
	                                       '{n}.'.$this->alias.'.'.$field[2]));
				break;
	
			default:
				return parent::find($type, $options);
			break;
		}
	}
}
?>