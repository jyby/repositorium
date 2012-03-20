<?php
/**
 * admin_documentos.php
 * 
 * CRUD sobre documentos
 * 
 * @package   controllers
 * @author    Mauricio Quezada <mquezada@dcc.uchile.cl>
 * @copyright Copyright (c) 2011 
 */

class AdminDocumentosController extends AppController {
  
  var $uses = array('Criteria', 'Document', 'CriteriasDocument', 'Tag', 'User', 'Expert', 'Attachfile', 'ConstituentsKit');
  var $helpers = array('Text', 'Number');
  var $paginate = array(
	'CriteriasDocument' => array(
	  'limit' => 5,
	  'order' => array(
		'total_respuestas' => 'desc'
	  )
	)
  );

  function beforeFilter() {
  	$user = $this->getConnectedUser();
  	$repo = $this->getCurrentRepository();

	if(is_null($repo)) {
		$this->Session->setFlash("Must be in a repository");
		$this->redirect('/');
	}
  	
  	if($this->isAnonymous() || (!$this->isAdmin() && !$this->isExpert())) {
  		$this->Session->setFlash('You do not have permission to access this page');
  		$this->redirect('/');
  	}  		 

	if($this->Session->check('CriteriasDocument.limit'))
		$this->paginate['CriteriasDocument']['limit'] = $this->Session->read('CriteriasDocument.limit');
	if($this->Session->check('CriteriasDocument.order'))
		$this->paginate['CriteriasDocument']['order'] = $this->_strToArray($this->Session->read('CriteriasDocument.order'));	
	if(!isset($this->paginate['CriteriasDocument']['conditions'])) {
		$conditions = array(
			'Criteria.repository_id' => $repo['Repository']['id']
		); 
		$this->paginate['CriteriasDocument']['conditions'] = $conditions;
	}
  }


  function index() {
	$this->redirect(array('action'=>'no_validados'));
  }
  
  function _beforeList($confirmado, $all = false) {
  	$repo = $this->getCurrentRepository();
  	if(is_null($repo)) {
  		$this->Session->setFlash("Must be in a repository");
  		$this->redirect('/');
  	}
  	$criterio_list = $this->Criteria->find('list', array('conditions' => array('Criteria.repository_id' => $repo['Repository']['id'])));
  	if(!empty($criterio_list)) {
  		$keys = array_keys($criterio_list);
  		$criterio_n = $keys[0];
  	} else {
  		$criterio_n = 0;
  	}
  	  	
  	if(!empty($this->data)) {
  		if(!empty($this->data['Criteria']['question'])) {
  			$criterio_n = $this->data['Criteria']['question'];
  			$this->Session->write('CriteriasDocument.criterio', $criterio_n);  		
  		}
  		
  		if(!empty($this->data['Document']['limit'])) {
  			$this->paginate['CriteriasDocument']['limit'] = $this->data['Document']['limit'];
  			$this->Session->write('CriteriasDocument.limit', $this->data['Document']['limit']);
  		}
  		
  		if(!empty($this->data['CriteriasDocument']['order'])) {  			
  			$this->paginate['CriteriasDocument']['order'] = $this->_strToArray($this->data['CriteriasDocument']['order']);
  			$this->Session->write('CriteriasDocument.order', $this->_arrayToStr($this->paginate['CriteriasDocument']['order']));  			
  		}
  		
  		if(!empty($this->data['CriteriasDocument']['filter'])) {
  			$this->Session->write('CriteriasDocument.filter', $this->data['CriteriasDocument']['filter']);
  		}
  	}
  	
  	// filter
  	$cond = array();
  	if($this->Session->check('CriteriasDocument.filter')) {
  		$cond = $this->_strToFilterArray($this->Session->read('CriteriasDocument.filter'));
  	} else {
  		$cond = array('1' => '1');
  	}
  	
  	if($all) {
  		$data = $this->paginate('CriteriasDocument', array(
		  'CriteriasDocument.criteria_id' => ($this->Session->read('CriteriasDocument.criterio') ? $this->Session->read('CriteriasDocument.criterio') : $criterio_n),
		  $cond		  		  
		));	
  	} else {
  		$data = $this->paginate('CriteriasDocument', array(
		  'CriteriasDocument.criteria_id' => ($this->Session->read('CriteriasDocument.criterio') ? $this->Session->read('CriteriasDocument.criterio') : $criterio_n),
		  'CriteriasDocument.validated' => $confirmado,
		  $cond
		));  		
  	}
  	
	return compact('criterio_list', 'criterio_n', 'data');
  }
  
  function set_warned_table($document_id){
  $repo = $this->getCurrentRepository();
  $id= $repo['Repository']['id'];
  $data_result=$this->Document->find('all', array('conditions' =>array('Document.id' => $document_id,'Document.repository_id' => $id)));
  return $document_id;
  //return $data_result;
  }
  function validados() {
  	$d = $this->_beforeList(1);
	$current = 'validados';
	$criterio_n = $this->Session->read('CriteriasDocument.criterio') ? $this->Session->read('CriteriasDocument.criterio') : $d['criterio_n'];
	$criterio_list = $d['criterio_list'];
	$data = $d['data'];	
	$limit = $this->Session->read('CriteriasDocument.limit') ? $this->Session->read('CriteriasDocument.limit') : $this->paginate['CriteriasDocument']['limit'];
	$ordering = $this->Session->read('CriteriasDocument.order') ? $this->Session->read('CriteriasDocument.order') : $this->_arrayToStr($this->paginate['CriteriasDocument']['order']);
	$filter = $this->Session->read('CriteriasDocument.filter') ? $this->Session->read('CriteriasDocument.filter') : 'all';
	$repo = $this->getCurrentRepository();
	$menu = 'menu_expert';
	
	$this->set(compact('criterio_n', 'criterio_list', 'data', 'current', 'limit', 'ordering', 'filter', 'repo', 'menu'));
	$this->render('listar');
  }

  function no_validados() {	
	$d = $this->_beforeList(0);
	$current = 'no_validados';
	$criterio_n = $this->Session->read('CriteriasDocument.criterio') ? $this->Session->read('CriteriasDocument.criterio') : $d['criterio_n'];
	$criterio_list = $d['criterio_list'];
	$data = $d['data'];
	$limit = $this->Session->read('CriteriasDocument.limit') ? $this->Session->read('CriteriasDocument.limit') : $this->paginate['CriteriasDocument']['limit'];
	$ordering = $this->Session->read('CriteriasDocument.order') ? $this->Session->read('CriteriasDocument.order') : $this->_arrayToStr($this->paginate['CriteriasDocument']['order']);
	$filter = $this->Session->read('CriteriasDocument.filter') ? $this->Session->read('CriteriasDocument.filter') : 'all';
	$repo = $this->getCurrentRepository();
	$menu = 'menu_expert';
	
	$this->set(compact('criterio_n', 'criterio_list', 'data', 'current', 'limit', 'ordering', 'filter', 'repo', 'menu'));
	$this->render('listar');
  }	
  //Cambios
    function warneds() {	
	$d = $this->_beforeList(0);
	$current = 'warned';
	$criterio_n = $this->Session->read('CriteriasDocument.criterio') ? $this->Session->read('CriteriasDocument.criterio') : $d['criterio_n'];
	$criterio_list = $d['criterio_list'];
	//$title_array=$this->Document->find('list', array('conditions' =>array('Document.title' => $aux_title,'Document.repository_id' => $id)));
	//$data = $d['data'];
	$limit = $this->Session->read('CriteriasDocument.limit') ? $this->Session->read('CriteriasDocument.limit') : $this->paginate['CriteriasDocument']['limit'];
	$ordering = $this->Session->read('CriteriasDocument.order') ? $this->Session->read('CriteriasDocument.order') : $this->_arrayToStr($this->paginate['CriteriasDocument']['order']);
	$filter = $this->Session->read('CriteriasDocument.filter') ? $this->Session->read('CriteriasDocument.filter') : 'all';
	$repo = $this->getCurrentRepository();
	$id= $repo['Repository']['id'];
	$data=$this->Document->find('all', array('conditions' =>array('Document.warned' => 1,'Document.repository_id' => $id),'recursive' => -1));
	$i=0;
	$aux=array();
	foreach($data as $d){
	$aux[$d['Document']['id']]=$d['Document']['warned_documents'];
	//$aux[$i]=$d['Document']['warned_documents'];
	$i++;
	//$data_warneds=$this->Dcoment->find('all',array('conditions' =>array('')
	}
	$data_table_right=array();
	foreach($aux as $key => $warned_list){
	if($warned_list!=""){
	$tmp=array();
	$tmp_warned_ids=explode(',',$warned_list);
	foreach ($tmp_warned_ids as $id_d){
	$tmp2=$this->Document->find('all', array('conditions' =>array('Document.id' => $id_d,'Document.repository_id' => $id),'recursive' => -1)) ;
	$tmp[]=$tmp2[0];
	//$tmp[]=$this->Document->find('all', array('conditions' =>array('Document.id' => $id_d,'Document.repository_id' => $id),'recursive' => -1)) ;
	}
	$data_table_right[$key]=$tmp;
	}
	}
	$menu = 'menu_expert';
	
	$this->set(compact('criterio_n', 'criterio_list','aux','data_table_right', 'data', 'current', 'limit', 'ordering', 'filter', 'repo', 'menu'));
	$this->render('listar_warneds');
  }	
  
  function all() {
  	$d = $this->_beforeList(null, true);
	$current = 'all';
	$criterio_n = $this->Session->read('CriteriasDocument.criterio') ? $this->Session->read('CriteriasDocument.criterio') : $d['criterio_n'];
	$criterio_list = $d['criterio_list'];
	$data = $d['data'];
	$limit = $this->Session->read('CriteriasDocument.limit') ? $this->Session->read('CriteriasDocument.limit') : $this->paginate['CriteriasDocument']['limit'];
	$ordering = $this->Session->read('CriteriasDocument.order') ? $this->Session->read('CriteriasDocument.order') : $this->_arrayToStr($this->paginate['CriteriasDocument']['order']);
	$filter = $this->Session->read('CriteriasDocument.filter') ? $this->Session->read('CriteriasDocument.filter') : 'all';
	$repo = $this->getCurrentRepository();
	$menu = 'menu_expert';
	
	$this->set(compact('criterio_n', 'criterio_list', 'data', 'current', 'limit', 'ordering', 'filter', 'repo', 'menu'));
	$this->render('listar');
  }

  
  function add() {
	$this->redirect(array('controller' => 'documents', 'action' => 'upload'));
  }
  
  //id_wdoc1 and id_wdoc2 are optional arguments used to edit warned documents
  function edit($id = null, $criterio = null,$warned = null, $id_wdoc1 = null, $id_wdoc2 = null) {
  //echo '<pre>';
  //echo $id;
  //echo $criterio;
  //echo $warned;
  //echo '</pre>';
  	if(is_null($criterio)) {
		$this->redirect('index');  		
  	}
  	
  	$repo = $this->requireRepository();
  	
  	if(empty($this->data)) {		
	  // stats
	  $this->data = $this->CriteriasDocument->find(
		'first',
		array(
			'conditions' => array(
				'CriteriasDocument.document_id' => $id,
				'CriteriasDocument.criteria_id' => $criterio,
				'Criteria.repository_id' => $repo['Repository']['id'],
			)
		));
		
	  if(empty($this->data)) {
	  	$this->redirect('index');
	  }
	  if($warned >0){
	  $id_repo= $repo['Repository']['id'];
	  $doc2= $this->Document->find('first', array('conditions' =>array('Document.id' => $id_wdoc2,'Document.repository_id' => $id_repo)));
	  $this->data['Document2']=$doc2['Document'];
	  }
	  // tags
	  $raw_tags = $this->Tag->find('all', array('conditions' => array('Tag.document_id' => $id), 'recursive' => -1));
	  $tags = array();	  
	  foreach($raw_tags as $t)
		$tags[] = $t['Tag']['tag'];	  
	  $this->data['Document']['tags'] = implode($tags,', ');
	  if($warned >0){
	  $raw_tags = $this->Tag->find('all', array('conditions' => array('Tag.document_id' => $id_wdoc2), 'recursive' => -1));
	  $tags = array();	  
	  foreach($raw_tags as $t)
	  $tags[] = $t['Tag']['tag'];	  
	  $this->data['Document2']['tags'] = implode($tags,', ');
	   }
	  
	  // user
	  $raw_user = $this->User->find('first', array('conditions' => array('User.id' => $this->data['Document']['user_id']), 'recursive' => -1));
	  $this->data['User']['autor'] = $raw_user['User']['first_name'] . ' '. $raw_user['User']['last_name'] . ' ('.$raw_user['User']['email'].')';
	  if($warned >0){
	  $raw_user = $this->User->find('first', array('conditions' => array('User.id' => $this->data['Document2']['user_id']), 'recursive' => -1));
	  $this->data['User']['autor2'] = $raw_user['User']['first_name'] . ' '. $raw_user['User']['last_name'] . ' ('.$raw_user['User']['email'].')';
	  }
	  
	  // criteria
	  $criterios_list = $this->Criteria->find('list', array('conditions' => array('Criteria.repository_id' => $repo['Repository']['id'])));
	  $criterios_n = $criterio;
	  
	  // repo
	  $repo = $this->getCurrentRepository();
	  $menu = 'menu_admin';
	  
	  // constituents
	  $constituents = $this->ConstituentsKit->find('all', array('conditions' => array('ConstituentsKit.kit_id' => $repo['Repository']['kit_id'], 'ConstituentsKit.constituent_id' != '0'), 'recursive' => 2, 'fields' => array("Constituent.sysname")));
	  
	  // folios
	  $folios = $this->Attachfile->find('all' , array('conditions' => array('Attachfile.document_id' => $this->data['Document']['id']), 'recursive' => -1, 'fields' => array("Attachfile.id","Attachfile.filename","Attachfile.type")));
	  
	  $this->set('data',$this->data);
	  $this->set(compact('criterios_list', 'criterios_n', 'repo', 'menu', 'folios','constituents'));
	  if($warned > 0){
	  $this->set('id_wdoc1',$id_wdoc1);
	  $this->set('id_wdoc2',$id_wdoc2);
	  $this->render('edit_warneds');
	  }	  
	} else {
	  // save stats info
	  if($this->CriteriasDocument->save($this->data))
	  	;	  
	  // save tags and basics
	  $this->Tag->deleteAll(array('Tag.document_id' => $id));
	  $this->data['Document']['id'] = $id;
	  
	  if($warned > 0){
	  $this->Tag->deleteAll(array('Tag.document_id' => $id_wdoc2));
	  $this->data['Document2']['id'] = $id_wdoc2;
	  }

	  if ($this->Document->saveWithTags($this->data)) {
		//$this->Session->setFlash('Document "'. $this->data['Document']['title'] .'" edited successfully');
		$str_doc1= "Document " .$this->data['Document']['title']. " edited successfully";
		$str_doc2="";
		if($warned > 0){
		$str_doc2= "Document " .$this->data['Document2']['title']. " edited successfully";
		$this->Session->setFlash(nl2br($str_doc1."\n".$str_doc2));
		CakeLog::write('activity', 'Document '.$id_wdoc2.'\'s content modified');
		}else{
		$this->Session->setFlash('Document "'. $this->data['Document']['title'] .'" edited successfully');
		}
		CakeLog::write('activity', 'Document '.$id.'\'s content modified');
		  if($warned > 0){
		  $this->set('id_wdoc1',$id_wdoc1);
		  $this->set('id_wdoc2',$id_wdoc2);
		  $this->render('edit_warneds');}
		  else{
		$this->redirect($this->data['Action']['current']);}
	  }
	  
	}
  }
  
  function edit_select_criteria($doc_id = null) {
  	if(!is_null($doc_id) and !empty($this->data)) {  		
  		$this->redirect(array('action' => 'edit/'.$doc_id.'/'.$this->data['Action']['select']));
  	}
  	$this->redirect($this->referer());
  }

  function remove($id = null, $redirect = true, $flash = true) {
	if (!is_null($id)) {
	  if($this->Document->delete($id)) {
	  	$this->CriteriasDocument->deleteRecord($id);
		if($flash) $this->Session->setFlash('Document no. '.$id.' removed');
		CakeLog::write('activity', 'Document '.$id.' deleted');	
	  } else {
		if($flash) $this->Session->setFlash('There was an error at deleting the document');
	  }
	}
   	if($redirect) $this->redirect($this->referer());	
  }

  /* CriteriasDocument */
  function set_field($field = null, $id = null, $bool = null, $redirect = true) {
	if(!is_null($field) and !is_null($id) and !is_null($bool)) {
	  
	  /* blacklist */
	  if(in_array($field, array('id', 'document_id'))) {
		if($redirect) $this->redirect($this->referer());
	  }
  	
	  $this->CriteriasDocument->id = $id;
	  $this->CriteriasDocument->set(array(		
		$field => $bool
	  ));
	  
	  if(!$this->CriteriasDocument->save())
		return false;
	
	  CakeLog::write('activity', "CriteriasDocument id=$id modified: [field: $field, new value: $bool]");
	}	
	if($redirect) $this->redirect($this->referer());
  }

  function _reset_stats($id = null, $criteria = null) {
	if(!is_null($id) && !is_null($criteria)) {
	 $this->CriteriasDocument->updateAll(
	 	array(
			'CriteriasDocument.total_answers_1' => 0,
			'CriteriasDocument.total_answers_2' => 0,
		),
		array(
			'CriteriasDocument.document_id' => $id,
	  		'CriteriasDocument.criteria_id' => $criteria	
		));	  
	  CakeLog::write('activity', "Document $id modified: stats restarted");
	}
	return true;
  }
  
  function reset_only($id = null, $criteria = null) {
  	$this->_reset_stats($id, $criteria);
  	$this->Session->setFlash('Stats restarted successfully');
  	$this->redirect($this->referer());
  }
  
  function mass_edit($criteria = null) {
//   	pr($this->data['Document']); exit;
  	if(!empty($this->data) && !is_null($criteria)) {
  		/* reset stats */
  		if(strcmp($this->data['Action']['mass_action'], 'reset') == 0) {
  			foreach($this->data['Document'] as $d) {
  				$id = $d['id'];	
  				$this->_reset_stats($id, $criteria);  			 
  			}
  			$this->Session->setFlash('Documents\' statistics restarted successfully');
  			
  		/* validate docs */
  		} else if(strcmp($this->data['Action']['mass_action'], 'validate') == 0) {
  			foreach($this->data['Document'] as $doc) {  				
  				$id = $doc['id'];
  				$this->validate_document($id, $criteria ,false);
  			}  	
  			$this->Session->setFlash('Documents changed successfully');
  			
  		/* delete docs */
  		} else if(strcmp($this->data['Action']['mass_action'], 'delete') == 0) {
  			foreach($this->data['Document'] as $d) {
  				$id = $d['id'];
  				$this->remove($id, false, false);
  			}  			
  			$this->Session->setFlash('Documents removed successfully');
  			
  		/* default */
  		} else {
  			$this->Session->setFlash('Didn\'t do anything. Maybe you picked a wrong option');
  		}  		
  	}
  		
  	$this->redirect($this->referer());
  }
  
  function validate_document($id = null, $criteria = null, $redirect = true) {
  	
  	if(!is_null($id) && !is_null($criteria)) {  	  	  				
		$doc = $this->CriteriasDocument->find( 'first', array(
			'conditions' => array(
				'CriteriasDocument.document_id' => $id,
				'CriteriasDocument.criteria_id' => $criteria)			
		));
		
		// set respuesta_oficial to 1 if not set  				  				
		if($doc['CriteriasDocument']['official_answer'] === null) {			
			$this->set_field('official_answer', $doc['CriteriasDocument']['id'], 1, false);
		} 				
		$this->set_field('validated', $doc['CriteriasDocument']['id'] , ($doc['CriteriasDocument']['validated']+1)%2, false);
  	}
  	if($redirect) $this->redirect($this->referer());
  }
  
  /* translates an array of ordering conditions to a string */
  function _arrayToStr($a = array()) {
 	if(array_key_exists('total_respuestas', $a)) {
 		if(strcmp($a['total_respuestas'], 'desc') == 0) {
 			return 'more-ans';
 		} else {
 			return 'less-ans';
 		} 			
 	} elseif(array_key_exists('consenso', $a)) {
 		if(strcmp($a['consenso'], 'desc') == 0) {
 			return 'more-cs';
 		} else {
 			return 'less-cs';
 		}
 	} else {
 		return null;
 	} 		
  }
  
  function _strToArray($ord = '') {
	if(strcmp('less-ans', $ord) == 0) {
		return array(
			'total_respuestas' => 'asc'
		);  				
	} elseif (strcmp('more-cs', $ord) == 0) {
		return array(
			'consenso' => 'desc'
		);
	} elseif (strcmp('less-cs', $ord) == 0) {
		return array(
			'consenso' => 'asc'
		);
	} else { // more-ans
		return array(
			'total_respuestas' => 'desc'
		);
	}  	
  }
  
  function _strToFilterArray($fil = '') {
  	if(strcmp('app', $fil) == 0) {
  		return array(
  			'CriteriasDocument.total_app >' => '50' 
  		);
  	} elseif(strcmp('dis', $fil) == 0) {
  		return array(
  			'CriteriasDocument.total_app <=' => '50' 
  		);
  	} elseif(strcmp('con', $fil) == 0) {
  		return array(
  			'CriteriasDocument.consenso >' => '50' 
  		);
  	} elseif(strcmp('don', $fil) == 0) {
  		return array(
  			'CriteriasDocument.consenso <=' => '50' 
  		);
  	} else { // all
  		return array(
  			'1' => '1' 
  		);
  	} 		
  }
}
?>
