<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/958/The-Pages-Controller
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html', 'Session');

/**
 * This controller does use a model
 *
 * @var array
 * @access public
 */
	var $uses = array('Repository', 'Expert', 'RepositoriesUser');
	
/**
 * @var string 
 * @access public
 */
	var $layout = 'non_repository_context';

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}

	/**
	 * 
	 * Home page
	 * @access public
	 */
	function home() {		
		if(!$this->isLoggedIn()) {
			$this->_anon();
		} else {
			$this->_user();
		}		
	}
	
	function _user() {
		$user = $this->getConnectedUser();
		
		$yours = array(
			'Repository.user_id' => $user['User']['id']
		);
		
		$collaborator = array(
			'Expert.user_id' => $user['User']['id'],
			'NOT' => $yours
		);

		$watched = array(
			'RepositoriesUser.user_id' => $user['User']['id'],
			'RepositoriesUser.watching' => true,
// 			'NOT' => $collaborator, 
// 			'NOT' => $yours
		);
		
		$latest = array(
// 			'NOT' => $watched,
// 			'NOT' => $collaborator,
// 			'NOT' => $yours
		);

		$your_repos = $this->Repository->find('all', array(
			'conditions' => $yours,
			'recursive' => -1
		));
		
		$this->Expert->unbindModel(array('belongsTo' => array('User')));
		$collaborator_repos = $this->Expert->find('all', array(
			'conditions' => $collaborator,
		));

		$this->RepositoriesUser->unbindModel(array('belongsTo' => array('User')));
		$watched_repos = $this->RepositoriesUser->find('all', array(
			'conditions' => $watched,
		));
		
		$this->Repository->unbindModel(array('belongsTo' => array('User')), array('hasMany' => array('Criteria', 'Document')));
		$latest_repos = $this->Repository->find('all', array(
			'conditions' => $latest,
			'order' => 'Repository.created desc'
		));
		
		$this->set(compact('your_repos', 'collaborator_repos', 'watched_repos', 'latest_repos'));
		$this->render('home_user');
	}
	
	function _anon() {
		$data = $this->Repository->find('all', array('limit' => 20, 'recursive' => -1));
		$this->set(compact('data'));
		$this->render('home_anon');
	}
}
