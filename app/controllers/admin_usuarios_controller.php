<?php
/**
 * admin_usuarios_controller.php
 * 
 * Controlador de administracion de usuarios
 * 
 * @package   controllers
 * @author    mquezada <mquezada@dcc.uchile.cl>
 * @copyright Copyright (c) 2011 
 */

class AdminUsuariosController extends AppController {
  var $uses = array('User','Expert', 'Repository');
  var $paginate = array(
	  'User' => array(
		'limit' => '15',
		'conditions' => array('User.id <>' => 1),
		'order' => array('User.created' => 'desc'),
		'recursive' => -1,
  	),
  	'Repository' => array(
  		'limit' => '5',
  		'order' => array('Repository.created' => 'desc'),
  	),
  	'Expert' => array(
  		'limit' => '5',
  		'order' => array('Repository.created' => 'desc'),
  	),
  );

  var $helpers = array('Text', 'Repo');
  
  function beforeFilter() {
	if(!$this->isAdmin()) {
	  $this->Session->setFlash('You don\'t have permission to access this page');
	  $this->redirect('/');
	}
  }

  function index() {
	$this->redirect('listar');
  }

  function listar() {
	$this->data = $this->paginate('User');
	
	$params = array(
		'current' => 'usuarios',
		'menu' => 'menu_admin',
		'footnotes' => array('Site Administrator'),
		'cond' => 'admin',
	);
	
	$this->set($params);
  }

  function add() {
  	$current = 'usuarios';
  	$menu = 'menu_admin';
  	$this->set(compact('current', 'menu'));	
	if (!empty($this->data)) {
	  if ($this->User->save($this->data)) {
		$this->Session->setFlash('User added successfully');		
		$this->redirect('listar');
	  } else {
		$this->Session->setFlash($this->User->invalidFields(), 'flash_errors');		
	  }
	}
  }

  function remove($id = null) {
	if (!is_null($id)) {
	  if($this->User->delete($id)) {
		$this->Session->setFlash('User '.$id.' deleted');
		CakeLog::write('activity','User '.$id.' deleted' );
	  } else {
		$this->Session->setFlash('There was an error trying to remove that user');
	  }
	}
   	$this->redirect($this->referer());	
  }

  function edit($id = null) {
  	$current = 'usuarios';
  	$menu = 'menu_admin';
  	$this->set(compact('current', 'menu'));	
	$this->User->id = $id;
	if (empty($this->data)) {
	  $this->data = $this->User->read();
	} else {
	  // password validation
	  if(!empty($this->data['User']['tmp_password'])) {
		$p1 = $this->data['User']['tmp_password'];
		$p2 = $this->data['User']['tmp_password2'];
		if(strcmp($p1,$p2) == 0) {
		  $this->data['User']['password'] = $p1;
		} else {
		  $this->Session->setFlash('Passwords don\'t match');
		  $this->redirect(array('action' => 'edit', $id));
		}
	  }
	    
	  $this->User->set($this->data);
	  if ($this->User->validates()) {
		// saves edited data
		if($this->User->save($this->data)) {
		  $this->Session->setFlash('The user was modified');
		  CakeLog::write('activity', 'User [id='.$id.'] edited');
		  $this->redirect('index');
		}
	  } else {
		$this->Session->setFlash($this->User->invalidFields(),'flash_errors');
		$this->redirect(array('action' => 'edit', $id));
	  }
	}
	if(is_null($id))
	  $this->redirect('add');
	 
  }

  function repositories($id = null) {
  	if(is_null($id))
  		$this->e404();
  	
  	$this->paginate['Expert']['conditions'] = array(
  		'Expert.user_id' => $id,
  	);
  	$this->data = $this->paginate('Expert');
  	$user = $this->User->find('first', array('conditions' => compact('id'), 'recursive' => -1));
  	$params = array(
  		'current' => 'usuarios',
  		'menu' => 'menu_admin',
  		'title' => "Repositories of '{$user['User']['first_name']} {$user['User']['last_name']}'",
  		'cond' => 'owner',
  		'user' => $user,
  		'footnotes' => array('This repository was created by the user'),
  	);
  	$this->set($params);  	
  	$this->render('../admin_repositories/index');
  }
}
?>
