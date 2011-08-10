<?php

class PointsController extends AppController {
	var $name = 'Points';
	var $uses = array('RepositoriesUser');
	
	function beforeFilter() {
		if(!$this->Session->check('Points.check')) {
			$this->e404();
		}
	}
	
	function checkPoints() {
		if(!$this->Session->check('Document.points') || !$this->Session->check('Document.goto'))
			$this->e404();
				
		$user = $this->getConnectedUser();
		$repository = $this->getCurrentRepository();
		$go_to = $this->Session->read('Document.goto');
		$requiredPoints = $this->Session->read('Document.points');		
		$userPoints = $this->RepositoriesUser->find('first', array(
			'conditions' => array(
				'user_id' => $user['User']['id'],
				'repository_id' => $repository['Repository']['id'],
				),
			'fields' => 'points',
			'recusrive' => -1
			)
		);
		
		
		if($userPoints >= $requiredPoints) {
			$this->Session->write('Challenge.passed', true);
			$this->redirect(array('controller' => 'documents', 'action' => $go_to));	
		} else {
			$this->Session->write('Challenge.isNeeded', true);
			$this->redirect(array('controller' => 'challenges'));
		}		
	}
	
}