<?php
/**
 * 
 * Collaborators controller
 * Used by repositories owners and other collaborators
 * Uses only admin_usuarios views
 * @author mquezada
 *
 */
class ExpertsController extends AppController {
	var $name = 'Experts';
	
	var $uses = array('Expert', 'User');
	
	var $paginate = array(
		'Expert' => array(
			'limit' => '15',
			'conditions' => array('Expert.user_id <>' => 1),
			'order' => array('Expert.created' => 'desc'),
		)
	);
	
	function beforeFilter() {
		if(!$this->isExpert()) {
			$this->Session->setFlash('You don\'t have permission to access this page');
			$this->redirect('/');
		}
	}
	
	function index() {
		$repo = $this->requireRepository();
		$this->paginate['Expert']['conditions'] = array(
			'Expert.repository_id' => $repo['Repository']['id']
		);
		$this->data = $this->paginate('Expert');
		
		$params = array(
			'current' => 'experts',
			'title' => 'Repository Collaborators',
			'menu' => 'menu_expert',
			'repo' => $repo,
			'cond' => 'owner',
			'footnotes' => array('Repository owner'),
			'add_button' => false,
			'collaborator_button' => true,
		); 
		
		$this->set($params);
		$this->render('../admin_usuarios/listar');
	}
	
	function add() {
		$params = array(
			'current' => 'experts',
			'menu' => 'menu_expert',
		);
		
		$this->set($params);
		
		if(!empty($this->data)) {
			$repo = $this->requireRepository();
			$this_user = $this->getConnectedUser();
			
			$email = $this->data['User']['email'];
			
			$user_conditions = array(
				'User.email' => $email,
			);
			$user = $this->User->find('first', array('conditions' => $user_conditions, 'recursive' => -1));		
						
			if(!empty($user)) {
				if($user['User']['id'] == $this_user['User']['id']) {
					$this->Session->setFlash('You can\'t add yourself');
				} else {				
					$expert_conditions = array(
						'Expert.user_id' => $user['User']['id'],
						'Expert.repository_id' => $repo['Repository']['id'],
					);
					
					$expert = $this->Expert->find('first', array('conditions' => $expert_conditions, 'recursive' => -1));
					if(!empty($expert)) {
						$this->Session->setFlash('Collaborator already exists');
					} else {
						if($this->Expert->save(array(
								'Expert' => array(
									'user_id' => $user['User']['id'],
									'repository_id' => $repo['Repository']['id']
								)
						))) {
							$this->Session->setFlash('Collaborator added');
							$this->redirect(array('controller' => 'experts', 'action' => 'index'));
						}		
					}					
				}				
			} else {
				$this->Session->setFlash('Collaborator was not added. Invalid email or that user is not registered', 'flash_errors');
			}
		}
	}
	
	function remove($id = null) {
		$repo = $this->requireRepository();
		$this_user = $this->getConnectedUser();
		
		$expert = $this->Expert->find('first', array(
			'conditions' => array(
				'Expert.repository_id' => $repo['Repository']['id'],
				'Expert.user_id' => $id,
				'Expert.user_id <>' => $this_user['User']['id'] 
			),
			'recursive' => -1,	
		));	

		if(!empty($expert)) {
			$this->Expert->delete($expert['Expert']['id']);
			$this->Session->setFlash('Collaborator removed');
			$this->redirect(array('controller' => 'experts', 'action' => 'index'));
		} else {
			$this->Session->setFlash('Collaborator invalid or does not exist');
			$this->redirect(array('controller' => 'experts', 'action' => 'index'));
		}
	}
	
}