<?php
/**
 * usuarios_controller.php
 * 
 * Controlador de usuarios
 * 
 */

class UsersController extends AppController {
  
  function beforeFilter() {
	if(!$this->Session->check('User.id')) {
	  $this->redirect(array('controller' => 'iniciar_sesion'));
	}
  }
  
  function index() {    
	$this->redirect(array('action' => 'edit', $this->Session->read('User.id')));	  
  }
  
  function edit($id = null) {
	if($id != $this->Session->read('User.id'))
	  $this->redirect(array('controller' => 'users', 'action' => 'edit', $this->Session->read('User.id')));

	$this->User->id = $id;
	if (empty($this->data)) {
	  $this->data = $this->User->read();
	} else {

	  // password validation
	  if(!empty($this->data['User']['tmp_password'])) {
		$p1 = $this->data['User']['tmp_password'];
		$p2 = $this->data['User']['tmp_password2'];

		if(strlen($p1) < 6) {
		  $this->Session->setFlash('Your password must have at least 6 characters');
		  $this->redirect(array('action' => 'edit', $id));
		}
		
		if(strcmp($p1,$p2) == 0) {
		  $this->data['User']['password'] = $p1;
		} else {
		  $this->Session->setFlash('Passwords don\'t match');
		  $this->redirect(array('action' => 'edit', $id));
		}
	  }

	  if($this->Session->read('User.esAdmin') == 0)
		$this->data['User']['is_administrator'] = 0;

	  $this->User->set($this->data);
	  if ($this->User->validates()) {
		// saves edited data
		if($this->User->save($this->data)) {
		  $this->Session->setFlash('Your profile was modified');
		  CakeLog::write('activity', 'User '. $id .' modified his/her profile');
		  $this->redirect('index');
		} else {
		  $this->set('debug', $this->User);
		}
	  } else {		
		$errors = $this->User->invalidFields();
		$this->Session->setFlash($errors, 'flash_errors');
		$this->redirect(array('action' => 'edit', $id));
	  }
	}
	if(is_null($id))
	  $this->redirect('add');
	 
  }   
}
?>
