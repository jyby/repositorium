<?php
/**
 * 
 * This code NEEEEDS to be refactored (someday)
 * @author mquezada
 *
 */

class RepositoriesController extends AppController {
	/**
	 * SessionComponent
	 * @var SessionComponent
	 */
	var $Session;
	
	/**
	 * Repository Model
	 * @var Repository
	 */
	var $Repository;
	
	/**
	 * 
	 * RepositoriesUser Model
	 * @var RepositoriesUser
	 */
	var $RepositoriesUser;
	
	var $name = 'Repositories';
	
	var $uses = array('Repository', 'RepositoriesUser', 'User', 'Document', 'Tag', 'Criteria','Constituent', 'Restriction', 'Kit', 'ConstituentsKit', 'KitsRestriction');
	
	/*@rmeruane*/
	private function make_seed()
	{
	  list($usec, $sec) = explode(' ', microtime());
	  return (float) $sec + ((float) $usec * 100000);
	}
	private function color_aleatorio(){
		mt_srand($this->make_seed());
		$retorno = '';
		for($i=0; $i<3; $i++)
			$retorno .= sprintf("%02X", mt_rand(100, 180));
		return $retorno;
	}
	
	function index($repo_url = null) {	
		if(is_null($repo_url)) {
			$this->redirect('/');
		}
		
		$result = $this->_set_repo($data = compact('repo_url'));
		if($result[0]) {			
			$repository = $result[1];
			$watching = null;
			
			// watching repo
			if($this->isLoggedIn()) {
				$user = $this->getConnectedUser();
				$r = $this->RepositoriesUser->find('first', array(
					'conditions' => array(
						'RepositoriesUser.repository_id' => $repository['Repository']['id'],
						'RepositoriesUser.user_id' => $user['User']['id'],
						'Repository.user_id <>' => $user['User']['id']),
// 					'recursive' => -1 
				));				
				$watching = $r['RepositoriesUser']['watching'];				
			}
			
			// stats
			$creator = $this->User->find('first', array(
				'conditions' => array(
					'User.id' => $repository['Repository']['user_id']
				),
				'fields' => array('User.first_name', 'User.last_name'),
				'recursive' => -1,
			));
			
			$documents = $this->Document->find('count', array(
				'conditions' => array(
					'Document.repository_id' => $repository['Repository']['id']
				),
				'recursive' => -1,
			));
			/*@rmeruane*/
			$tags_name_count = $this->Tag->find('all', array(
				'conditions' => array(
					'Document.repository_id' => $repository['Repository']['id']
				),
				'fields' => array(
					'Tag.tag',
					'COUNT(tag) AS cantidad'
				),
				'group' => 'tag'
			));
			
			$cloud_data = "<tags>";
			$tag_factor_crecimiento = 1.5;
			$tag_min_size = 10; //tamano minimo
			$tag_max_size = 40; //tamano maximo
			foreach($tags_name_count as $tag_info){
				$tag_size = round($tag_factor_crecimiento*$tag_info[0]['cantidad']+$tag_min_size);
				if($tag_size>$tag_max_size) $tag_size = $tag_max_size;
				$cloud_data .= "<a href='".Router::url(array('controller' => 'tags', 'action' => 'index'), true)."/?tag_value=".$tag_info['Tag']['tag']."' style='".$tag_size."' color='0x".$this->color_aleatorio()."' hicolor='0x".$this->color_aleatorio()."'>".$tag_info['Tag']['tag']."</a>";
			}
			$cloud_data .= "</tags>";

			$tags = $this->Tag->find('count', array(
				'conditions' => array(
					'Document.repository_id' => $repository['Repository']['id']
				),
				'fields' => 'DISTINCT tag'
			));
			
			$criterias = $this->Criteria->find('count', array(
				'conditions' => array(
					'Criteria.repository_id' => $repository['Repository']['id']
				),
				'recursive' => -1
			));
			
			$this->set(compact('repository', 'watching', 'creator', 'documents', 'tags', 'criterias', 'cloud_data'));
		} else {
			$this->e404();
		}		
	}
	
	/**
	 * 
	 * set repository data in session, by id or url, if exists
	 * @param array $data
	 * @return array array( boolean: status, array: data | null)
	 */
	function _set_repo($data = array()) {
		if(empty($data)) {
			return array(false, null);
		}
		
		if(isset($data['repo_url'])) {
			$repo = $this->Repository->find('first', array(
				'conditions' => array(
					'Repository.url' => $data['repo_url']
				),
				'recursive' => -1,
			));
		} elseif(isset($data['repo_id'])) {
			$repo = $this->Repository->find('first', array(
				'conditions' => array(
					'Repository.id' => $data['repo_id']
				),
				'recursive' => -1,
			));
		}
		
		if(!empty($repo)) {
			$this->setRepositorySession($repo);			
			return array(true, $repo);
		} else {
			return array(false, null);
		}
					
	}
	
	function set_repository_by_url($repo_url = null) {
		if(is_null($repo_url)) {		
			$this->e404();
		}
		
		$result = $this->_set_repo($data = compact('repo_url'));		
		if($result[0]) {
			$this->redirect(array('action' => 'index', $result[1]['Repository']['url']));
		} else {
			$this->e404();
		}		
	}
	
	function set_repository_by_id($repo_id = null) {
		if(is_null($repo_id)) {
			$this->e404();
		}
		$result = $this->_set_repo(compact('repo_id'));		
		if($result[0]) {
			$this->redirect(array('action' => 'index', $result[1]['Repository']['url']));
		} else {
			$this->e404();
		}		
	}
	
	function create() {
		
		if($this->getConnectedUser() == $this->anonymous)
			$this->redirect(array('controller' => 'login'));
		
		if(!empty($this->data)) {
			$user = $this->getConnectedUser();
			$this->data['Repository']['user_id'] = $user['User']['id'];
			
			// adding Constituents to a new Kit
			$selectConstituents = $this->data['Repository']['Constituents'];
			$this->Kit->save();
			foreach($selectConstituents as $constituent){
				$this->ConstituentsKit->create();
				$this->ConstituentsKit->set('kit_id', $this->Kit->id);
				$this->ConstituentsKit->set('constituent_id', $constituent);
				$this->ConstituentsKit->save();
			}
			// update Repository kit_id
			$this->data['Repository']['kit_id'] = $this->Kit->id;
			
			$this->Repository->set($this->data);
			
			if($this->Repository->validates()) {
				$repository = $this->Repository->createNewRepository($this->data, $user);
				CakeLog::write('activity', "Repository [name=\"{$repository['Repository']['name']}\"] created");
				if(is_null($repository)) {
					$this->Session->setFlash('An error occurred creating the repository. Please, blame the developer');
					$this->redirect('/');
				}
				
				$this->_make_user_expert();

				if(Configure::read('App.subdomains')) {
					$dom = Configure::read('App.domain');
					$this->redirect("http://{$repository['Repository']['url']}.{$dom}");
				} else {
					$this->redirect(array('action' => 'index', $repository['Repository']['url']));
				}

			} else {
				$this->Session->setFlash($this->Repository->invalidFields(), 'flash_errors');
			}	
		}
		$constituents =  $this->Constituent->find('superlist', array('fields'=>array('id','name','description'), 'separator'=>': '));
		$this->set(compact('constituents'));
	}

	
	function watch($id = null) {
		if(is_null($id)) {
			$this->Session->setFlash('Repository not found');
			$this->redirect('/');
		}
		if(!$this->isLoggedIn()) {
			$this->redirect(array('controller' => 'login', 'action' => 'index'));
		}
		
		$user = $this->getConnectedUser(); 
		$repo = $this->RepositoriesUser->find('first', array('conditions' => array('user_id' => $user['User']['id'], 'repository_id' => $id), 'recursive' => -1));
		
		if(empty($repo)) {
			$this->Session->setFlash('Repository not found');
			$this->redirect('/');
		}
		
		$watching = $repo['RepositoriesUser']['watching'];
		
		$this->RepositoriesUser->read(null, $repo['RepositoriesUser']['id']);
		$this->RepositoriesUser->set('watching', !$watching);
		$this->RepositoriesUser->save();
		
		if($watching) $msg = "Repository removed from watchlist";
		else $msg = "Repository added to watchlist";
		
		$this->Session->setFlash($msg);
		$this->redirect(array('action' => 'set_repository_by_id', $id));
	}

	function _make_user_expert() {
		$this->Session->write('User.esExperto', true);
	}
}