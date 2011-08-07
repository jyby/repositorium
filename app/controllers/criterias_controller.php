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
	  		$this->redirect(array('controller' => 'pages'));
		} else {
			$this->Session->setFlash('You do not have permission to access this page. Please log in if you are an administrator');
			$this->redirect(array('controller' => 'iniciar_sesion'));
		}
	}
	if($this->Session->check('Criteria.limit'))
		$this->paginate['Criteria']['limit'] = $this->Session->read('Criteria.limit'); 
  }

  function index() {
  	if(!empty($this->data)) {  		
  		if(!empty($this->data['Criteria']['limit'])) {
  			$this->paginate['Criteria']['limit'] = $this->data['Criteria']['limit'];
  			$this->Session->write('Criteria.limit', $this->data['Criteria']['limit']);
  		} 
  	} 
  	$limit = $this->Session->read('Criteria.limit') ? $this->Session->read('Criteria.limit') : $this->paginate['Criteria']['limit'];
  	$this->data = $this->paginate();  
  	$this->set(compact('limit'));	
  }

  function add() {
  	$this->set('current', 'Add new');
	if(!empty($this->data)) {
	  $this->Criteria->set($this->data);	  
	  if($this->Criteria->validates()) {
		$this->data['Criteria']['repository_id'] = 1;
		$this->Criteria->save($this->data);
		$this->Session->setFlash('Criteria added successfully');
		CakeLog::write('activity', 'Criteria "'.$this->data['Criteria']['question'].'" was added');
		$this->redirect($this->referer());
	  } else {
		$this->Session->setFlash($this->Criteria->invalidFields(),'flash_errors');
		//$this->Session->setFlash('There were errors in the form');
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