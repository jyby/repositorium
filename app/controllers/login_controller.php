<?php

class LoginController extends AppController {
	var $name = 'Login';
  	var $uses = array();

  	function beforeRender() {
		if($this->isLoggedIn())
	  		$this->redirect('/');
  	}

  	function index() {	
  		if (!empty($this->data) && $this->login($this->data))
			$this->redirect($this->referer());
  	}

  	function logout() {
    	$this->Session->destroy();
		$this->Session->setFlash('Logged out');
    	$this->redirect('/');
  	}

}
?>