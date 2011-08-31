<?php
/**
 * 
 * Repositories Administration
 * @author mquezada
 *
 */

class AdminRepositoriesController extends AppController {
	var $name = 'AdminRepositories';
	var $uses = array('Repository');
	var $paginate = array(
		'Repository' => array(
		  'limit' => 5,
		  'order' => array('Repository.created' => 'desc')
		)
	);
	
	/**
	 * SessionComponent
	 * @var SessionComponent
	 */
	var $Session;
	
	/**
	 * 
	 * Repository Model
	 * @var Repository
	 */
	var $Repository;
	
	function beforeFilter() {
		if(!$this->isAdmin()) {
			$this->Session->setFlash('You don\'t have permission to access this page');
			$this->redirect('/');
		}		
	}
	
	function index() {
		$current = 'repositories';
		
		$this->set(compact('current'));
	}
}