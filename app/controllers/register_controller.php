<?php

class RegisterController extends AppController{
  var $name = 'Register';
  var $uses = array('User');
  
  function beforeFilter() {
	if($this->getConnectedUser() != $this->anonymous)
		$this->redirect('/');
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
		  $this->Session->setFlash('Password must have at least 6 characters');
		  
		} else if(strcmp($p1,$p2) != 0) {
		  $this->Session->setFlash('Passwords dont match', 'flash_errors');

		} else {	  
		  if($user = $this->User->register($this->data)) {
			$this->login($this->data);			
			$this->redirect('/');
		  }		
		}  		
	  }
	}
  }
}

?>