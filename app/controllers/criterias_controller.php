<?php
App::import('Sanitize');
class CriteriasController extends AppController {

  var $paginate = array(
	'Criteria' => array(
	  'limit' => 5,
	  'order' => array(
		'Criteria.question' => 'desc'
	  )
	)
  );

  function beforeFilter() {
	if(!$this->Session->check('User.esAdmin') and !$this->Session->check('User.esExperto')) {
	  if($this->Session->check('User.id')) {
	  		$this->Session->setFlash('You do not have permission to access this page');
	  		$this->redirect('/');
		} else {
			$this->Session->setFlash('You do not have permission to access this page. Please log in if you are an administrator');
			$this->redirect(array('controller' => 'login'));
		}
	}
	if($this->Session->check('Criteria.limit'))
		$this->paginate['Criteria']['limit'] = $this->Session->read('Criteria.limit'); 
	if(!isset($this->paginate['Criteria']['conditions'])) {
		$repo = $this->requireRepository();
				
		$this->paginate['Criteria']['conditions'] = array(
			'Criteria.repository_id' => $repo['Repository']['id']
		);
	}
  }

  function index() {
  	if(!empty($this->data)) {  		
  		if(!empty($this->data['Criteria']['limit'])) {
  			$this->paginate['Criteria']['limit'] = $this->data['Criteria']['limit'];
  			$this->Session->write('Criteria.limit', $this->data['Criteria']['limit']);
  		} 
  	} 
  	$limit = $this->Session->read('Criteria.limit') ? $this->Session->read('Criteria.limit') : $this->paginate['Criteria']['limit'];
  	$repo = $this->getCurrentRepository();
  	$this->data = $this->paginate();  
  	$this->set(compact('limit', 'repo'));	
  }

  function add() {
  	$repo = $this->getCurrentRepository();
  	$current = 'Add new';
  	$this->set(compact('repo', 'current'));
	if(!empty($this->data)) {
	  $this->Criteria->set($this->data);	  
	  if($this->Criteria->validates()) {
	  	$repo = $this->getCurrentRepository();
	  	
	  	if(is_null($repo)) {
	  		$this->Session->setFlash('Please set a current repository first');
	  		$this->redirect('index');
	  	}
	  	
		$this->data['Criteria']['repository_id'] = $repo['Repository']['id'];
		
		if($this->Criteria->save($this->data)) {
			$this->Session->setFlash('Criteria added successfully');
			CakeLog::write('activity', 'Criteria "'.$this->data['Criteria']['question'].'" was added');
		} else {
			$this->Session->setFlash('An error occurred saving the criteria', 'flash_errors');
			CakeLog::write('error', 'Criteria "'.$this->data['Criteria']['question'].'" was not added');			
		}
		$this->redirect($this->referer());
	  } else {
		$this->Session->setFlash($this->Criteria->invalidFields(),'flash_errors');
	  }
	}
  }

  function view($id = null) {  }


  function edit($id = null) {
  	$this->set('current', 'Edit');
	$this->Criteria->id = $id;
	if (empty($this->data)) {
	  $this->data = $this->Criteria->read();
	} else {
	  if ($this->Criteria->save($this->data)) {
		$this->Session->setFlash('Criteria '.$id.' was successfully modified');
		CakeLog::write('activity', 'Criteria '.$id.' was modified');
		$this->redirect(array('controller' => 'admin_documentos', 'action' => 'index'));
	  }
	}
	$this->render('add');
  }

  function remove($id = null) {
  	if(!is_null($id)) {
  		if($this->Criteria->delete($id)) {
  			$this->Session->setFlash('Criteria '.$id.' removed');
  			CakeLog::write('activity', 'Criteria '.$id.' was removed');
  		} else {
  			$this->Session->setFlash('There was an error deleting that criteria you specified');
  		}
  	}
  	$this->redirect($this->referer());  	
  }

}

?>