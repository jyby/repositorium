<?php
App::import('Sanitize');

class IniciarSesionController extends AppController {
  var $uses = array('User');

  function beforeRender() {
	if($this->Session->check('User.id'))
	  $this->redirect('/');
  }

  function index() { }

  function login() {
	if (!empty($this->data)) { // siempre pasa
	  if(!AppController::_login($this->data)) {
		$this->redirect('index');
	  }
	} else {
	  $this->redirect('index');
	}
	$this->redirect($this->referer());
  }

  function logout() {
    $this->Session->destroy();
	$this->Session->setFlash('Logged out');
    $this->redirect('/');
  }

}
?>