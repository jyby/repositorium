<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if(Configure::read('App.subdomains')) {
	Router::connect('/', Configure::read('Route.default'));
} else {
	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
}

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
  * custom routes
  */
  	Router::connect('/upload', array('controller' => 'documents', 'action' => 'upload'));  	
  	Router::connect('/logout', array('controller' => 'login', 'action' => 'logout'));

  	Router::connect('/manage', 			array('controller' => 'admin_documentos'));
  	Router::connect('/manage-users', 	array('controller' => 'admin_usuarios'));
  	Router::connect('/challenges', 		array('controller' => 'challenges'));
  	Router::connect('/criterias', 		array('controller' => 'criterias'));
  	Router::connect('/documents', 		array('controller' => 'documents'));
  	Router::connect('/login', 			array('controller' => 'login'));
  	Router::connect('/register', 		array('controller' => 'register'));
  	Router::connect('/repositories', 	array('controller' => 'repositories'));
  	Router::connect('/search', 			array('controller' => 'tags'));
  	Router::connect('/profile', 		array('controller' => 'users'));
  	Router::connect('/points',			array('controller' => 'points'));

/**
 * repositories
 */
  	Router::connect('/repositories/new', array('controller' => 'repositories', 'action' => 'create'));
//   	Router::connect('/repositories/*', 	array('controller' => 'repositories', 'action' => 'index'));