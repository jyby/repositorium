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

/**
* uncomment the following line for enabling subdomains repositories
* then comment the next line (l. 40)
* 
*/

// 	Router::connect('/', Configure::read('Route.default'));

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */

/** comment the following line for enabling subdomains repositories */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	
	
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
/**
  * custom routes
  */
  	Router::connect('/upload', array('controller' => 'documents', 'action' => 'upload'));
  	Router::connect('/view', array('controller' => 'bajar_documento'));
  	
  	Router::connect('/profile', array('controller' => 'users'));
  	Router::connect('/logout', array('controller' => 'login', 'action' => 'logout'));
  	
  	Router::connect('/repositories/new', array('controller' => 'repositories', 'action' => 'create'));
  	
  	
/**
 * controllers
 * @TODO add blacklist
 */  	
  	Router::connect('/manage', 			array('controller' => 'admin_documentos'));
  	Router::connect('/manage-users', 	array('controller' => 'admin_usuarios'));
  	Router::connect('/challenges', 		array('controller' => 'challenges'));
  	Router::connect('/criterias', 		array('controller' => 'criterias'));
  	Router::connect('/documents', 		array('controller' => 'documents'));
  	Router::connect('/login', 			array('controller' => 'login'));
  	Router::connect('/register', 		array('controller' => 'register'));
  	Router::connect('/repositories', 	array('controller' => 'repositories'));
  	Router::connect('/tags', 			array('controller' => 'tags'));
  	Router::connect('/users', 			array('controller' => 'users'));
  	Router::connect('/points',			array('controller' => 'points'));
  	