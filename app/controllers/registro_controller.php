<?php

class RegistroController extends AppController{

  var $uses = array('User');
  
  function beforeFilter() {
	if($this->Session->check('User.id'))
	  $this->redirect(array('controller' => 'pages'));
  }
  
  function index() {
	if(!empty($this->data)) {
	  $this->User->set($this->data);		

	  if(!$this->User->validates()) {
		$errors = $this->User->invalidFields();
		$this->Session->setFlash($errors, 'flash_errors');

	  } else {

		$p1 = $this->data['User']['password'];
		$p2 = $this->data['User']['password2'];
		if(strlen($p1) < 6) {
		  $this->Session->setFlash('La contraseña debe tener por lo menos 6 caracteres');
		} else if(strcmp($p1,$p2) != 0) {
		  $this->Session->setFlash('Las contraseñas no coinciden');

		} else {	  
		  if($user = $this->User->register($this->data)) {		  	
			AppController::_login($this->data);			
			$this->redirect('/');
		  }		
		}  		
	  }
	}
  }
}

?>