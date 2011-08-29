<?php

class LoginController extends AppController {
	var $name = 'Login';
  	var $uses = array();

  	function beforeRender() {
		if($this->getConnectedUser() != $this->anonymous)
	  		$this->redirect('/');
  	}

  	function index() {	}

  	function authenticate() {
		if (!empty($this->data)) { // siempre pasa
	  		if(!$this->login($this->data)) {
				$this->redirect('index');
	  		}
		} else {
	  		$this->redirect('index');
		}
		$this->redirect('/');
  	}

  	function logout() {
    	$this->Session->destroy();
		$this->Session->setFlash('Logged out');
    	$this->redirect('/');
  	}

}
?>