<?php
class ConstituentsController extends AppController {

	var $name = 'Constituents';
	var $uses = array('Repository', 'Kit', 'ConstituentsKit', 'Constituent');
	
  	function index() {
  		
  		$repo = $this->requireRepository();
  		
  		$this->Repository->id = $repo['Repository']['id'];
  		
  		if(!empty($this->data)) {
  			// adding Constituents to a new Kit
  			$selectConstituents = $this->data['Repository']['Constituents'];
  			$this->Kit->save();
  			foreach($selectConstituents as $constituent){
  				$this->ConstituentsKit->create();
  				$this->ConstituentsKit->set('kit_id', $this->Kit->id);
  				$this->ConstituentsKit->set('constituent_id', $constituent);
  				$this->ConstituentsKit->save();
  			}
  			// update Repository kit_id
  			$this->data = $this->Repository->read();
  			$this->data['Repository']['kit_id'] = $this->Kit->id;
  			$this->Repository->save($this->data);
  		}
  		
  		$this->data = $this->Repository->read();
  		$constituents =  $this->Constituent->find('superlist', array('fields'=>array('id','name','description'), 'separator'=>': '));
  		$thisRepoConstituents = $this->ConstituentsKit->find('all',array('conditions' => array(
					'ConstituentsKit.kit_id' => $this->data['Repository']['kit_id']),'recursive' => -1));
  		
  		foreach($constituents as $key => $value){
  			# cgajardo: fix to persist "content" selection even when it's actually disabled, using javascript
  			if($key == 0){
  				$constituents[0] = array(
  						'name' => $value." (required)",
  				  		'value' => '0',
  				  		'onClick' => 'this.checked=true');
  				continue;
  			}
  			
  			$constituents[$key] = array(
  				'name' => $value,
  			  	'value' => $key,
  			  	'checked' => 'false');
  			
  			foreach ($thisRepoConstituents as $thisRepoConstituent){
  				if( $thisRepoConstituent['ConstituentsKit']['constituent_id'] == $key){
  					$constituents[$key]['checked'] = 'true';
  					break;
  				}
  			}
  		}
		
  		$params = array(
  			'repo' => $this->requireRepository(),
  			'menu' => 'menu_expert',
  			'current' => 'constituents',
  			'title' => 'Update Constituents'
  		); 
  
  		$this->set($params);
  		$this->set(compact('constituents'));
  	}
	
}
?>