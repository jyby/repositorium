<?php
class DocumentsController extends AppController {
	
	var $helpers = array('Html', 'Javascript', 'Ajax');
	
	var $name = 'Documents';
	var $uses = array('Document', 'User', 'Repository','Tag', 'ConstituentsKit', 'Attachfile');
	
	/**
	 * User Model
	 * @var User
	 */
	var $User;
	
	/**
	 * Document Model
	 * @var Document
	 */
	var $Document;
	
	/**
	 * SessionComponent
	 * @var SessionComponent
	 */
	var $Session;
	
	function beforeFilter() {
		if(!$this->Session->check('Document.continue')) {
			$this->Session->write('Action.type', $this->action);			
			$this->redirect(array('controller' => 'points', 'action' => 'process'));	
		}
	}
	
  function index() {
	$this->e404();
  }
  
  function _clean_session() {
  	$this->Session->delete('Document');
  }
  
  /**
   * 
   * @TODO points handling
   * @TODO dispatch handling
   */
  function upload() {
  	$repo = $this->requireRepository();
  	
  	$constituents = $this->ConstituentsKit->find('list', array(
  		  				'conditions' => array('ConstituentsKit.kit_id' => $repo['Repository']['kit_id'], 'ConstituentsKit.constituent_id' != '0'), 
  		  				'recursive' => 1,
  		  				'fields'=>array('Constituent.sysname')));
  	
  	if(!empty($this->data)) {
		//attach necesary behaviors
		foreach ($constituents as $constituent){
			$configArray = array('cod'=> 1);
			$configArray['data'] =& $this->data;
			$configArray['session'] =& $this->Session;
  			$this->Document->Behaviors->attach($constituent, $configArray);
		}
  		
		
		//echo '<pre>';
		//print_r ($this->data);
		//echo $this->data['Document']['tags'];
		//print_r ($this->Document);
		//echo '</pre>';
		//$this->data['Document']['title']
		//$similar_tags= $this-> 
		//$result= $this->Document->find('count', array('conditions' =>array('Document.title' => $q,'Document.repository_id' => $id)));
		//En la siguiente linea se guardan los documentos
		$this->save($this->data);
				
  		foreach ($constituents as $constituent){
  			$this->Document->Behaviors->detach($constituent);
  		}
  	}
  	
  	
	$this->set(compact('constituents'));
  }

  
  /**
   * 
   */
  function download() {
  	if($this->Session->check('Search.document_ids')) {
  		$document_ids = $this->Session->read('Search.document_ids');  		
  		
  		$repo = $this->requireRepository();
  		$doc_pack = $repo['Repository']['documentpack_size'];
  		  		
  		$docs = array();  		
  		foreach($document_ids as $id) {
  			$docs[] = $this->Document->find('first', array(
  		 		'conditions' => array('Document.id' => $id),
  		  		'recursive' => -1,)
  			);
  		}
  		
  		// if there are more documents, shuffle them
  		if(count($docs) > $doc_pack) {
  			shuffle($docs);
  			$docs_ids = array_rand($docs, $doc_pack);
  			$docs_ids_array = (is_array($docs_ids) ? $docs_ids : array($docs_ids));
  			$docs = array_intersect_key($docs, array_flip($docs_ids_array));
  		}
  		
  		// cgajardo: constituents to be attached
  		$constituents = $this->ConstituentsKit->find('all', array('conditions' => array('ConstituentsKit.kit_id' => $repo['Repository']['kit_id'], 'ConstituentsKit.constituent_id' != '0'), 'recursive' => 2, 'fields' => array("Constituent.sysname")));
  		
  		// cgajardo: attach folios that belongs to each document
  		foreach ($docs as &$doc){
  			$doc['files'] = array();
  			$doc['files'] = $this->Attachfile->find('all' , array('conditions' => array('Attachfile.document_id' => $doc['Document']['id']), 'recursive' => -1, 'fields' => array("Attachfile.id","Attachfile.filename","Attachfile.type")));
  		}
  		
  		$this->set(compact('docs', 'doc_pack', 'constituents'));
  		$this->_clean_session();  			
  	}
  }
  
  /**
   * 
   *  @deprecated
   */
  public function get($criterio = null) {
  	if(!$this->Session->check('Desafio.docs') and is_null($criterio)) {
  		$this->Session->setFlash(	
  		'Ganaste la posibilidad de descargar documentos, haz una búsqueda para poder acceder a ellos!');
  		$this->redirect(array('controller' => 'tags'));
  	} else if(!is_null($criterio)) {
  		$docs = $this->Tag->findDocumentsByTags(array($criterio));
  	} else {
  		$docs = $this->Session->read('Desafio.docs');
  	}
  
  	$this->Session->delete('Desafio');
  	$criterio = $this->Criterio->find('first', array('recursive' => -1));
  	$pack = $criterio['Criterio']['tamano_pack'];
  
  	$doc_objs = $this->Documento->find('all', array(
  	  'conditions' => array(
  		'Documento.id_documento' => $docs
  	),
  	  'recursive' => -1,
  	));
  	$premio = array();
  	if(count($doc_objs) > 0) {
  		if(count($doc_objs) < $pack)
  		$pack = count($doc_objs);
  
  		/* shuffle documents */
  		shuffle($doc_objs);
  		$tmp = array_rand($doc_objs, $pack);
  		$tmp = (is_array($tmp) ? $tmp : array($tmp));
  		/* insersect by keys from documents and some random subset of size $pack of $doc_objs */
  		/* $premio are $pack random documents from search result */
  		$premio = array_intersect_key(
  		$doc_objs,
  		array_flip($tmp)
  		);
  	}
  	$this->set(compact('premio', 'doc_objs'));
  }
  function set_warned(&$data){
  $repo = $this->requireRepository();
  	$max_sim=100;
	$aux_title=$this->data['Document']['title'];
	$aux_text=$this->data['Document']['content'];
	$title_val=0;
	$text_val=0;
	$tags_val=0;
	$all_tags=0;
	$files_val=0;
	$id= $repo['Repository']['id'];
	$tags = explode(',', $data['Document']['tags']);
	$tags = array_map("trim", $tags);
	$files=array();
	$aux_var=1;
	//if((count($this->data['files'])) >= 3 ){$aux_var=0;}
	//for ($i = 0; $i < (count($this->data['files']))-$aux_var; $i++) {
	if(isset($data['files'])) {
	for ($i = 0; $i < count($this->data['files']); $i++) {
				if($this->data['files'][$i]['error']!= 4){
				$files[$i] = $this->data['files'][$i]['name'];
				}
			}
		$files_val=$this->Attachfile->findFilesCount($id,$files);	//kaka
		}
	//$files=$this->data['files'];
	//echo 'El titulo del file en 1, es :';
	//echo $this->data['files'][1]['name'];
	//echo '<pre>';	//kaka
	//print_r ($tags);	
	//print_r ($this->data);
	//print_r($files);
	//print_r ($this->Document);
	//echo '</pre>';	//kaka
	//$documents = $this->Tag->findTagsCount($id, $tags);
	//print_r($this->Tag->findTagsCount($id, $tags));
	$tags_val=$this->Tag->findTagsCount($id, $tags);
	//echo $files_val;
	//echo $tags_val;
	//$this->Tag->findTagsCount($id, $tags);
	//echo '</pre>';
	$result_title= $this->Document->find('count', array('conditions' =>array('Document.title' => $aux_title,'Document.repository_id' => $id)));
	$result_text= $this->Document->find('count', array('conditions' =>array('Document.content' => $aux_text,'Document.repository_id' => $id )));
	if($result_title!=0){$title_val=1;}
	if($result_text!=0){$text_val=1;}
	if($tags_val > 0){$all_tags=1;}
	$title_pdr = $repo['Repository']['pdr_tittle'];
	$text_pdr = $repo['Repository']['pdr_text'];
	$tags_pdr = $repo['Repository']['pdr_tags'];
	$files_pdr = $repo['Repository']['pdr_files'];
	$total_pdr=($title_pdr*$title_val)+($text_pdr*$text_val)+($tags_pdr*$all_tags)+($files_pdr*$files_val);
	if($total_pdr>$max_sim){
		$this->data['Document']['warned'] = 1;}
		else{$this->data['Document']['warned']=0;}
		$this->data['Document']['warned_score']=$total_pdr;
  }
  function save(&$data){
  	
  	$repo = $this->requireRepository();
  	$user = $this->getConnectedUser(); 
  	$this->data['Document']['repository_id'] = $repo['Repository']['id'];
  	$this->data['Document']['user_id'] = $user['User']['id'];
  	$this->data['Document']['kit_id'] = $repo['Repository']['kit_id'];
	$this->set_warned($this->data);
	//echo '<pre>';
	//print_r ($this->data);
	//echo '</pre>';
  	$this->Document->set($this->data);
  	 
  	// errors
  	if(empty($this->data['Document']['tags'])) {
  		$this->Session->setFlash('You must include at least one tag');
  	} else if(!$this->Document->validates()) {
  		$errors = $this->Document->invalidFields();
  		$this->Session->setFlash($errors, 'flash_errors');
  	} else if(!$this->Document->saveWithTags($this->data)) {
  		$this->Session->setFlash('There was an error trying to save the document. Please try again later');
  	} else {
		//echo '<pre>';
		//print_r ($this->data);
		//echo $this->data['Document']['tags'];
		//print_r ($this->Document);
		//echo '</pre>';
		//echo $this->data['Document']['title'];
		if($this->data['Document']['warned'] == 1){
		$this->Session->setFlash('Document saved but its gonna be reviewed by an admin because it may be duplicated');
		}
		//if(false){}
		else{
  		$this->Session->setFlash('Document saved successfuly');
		}
  		$this->_clean_session();
  		$this->redirect(array('controller' => 'repositories', 'action' => 'index', $repo['Repository']['url']));
		
  	}
  }
  
  
}
?>