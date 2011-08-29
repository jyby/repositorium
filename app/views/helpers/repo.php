<?php
class RepoHelper extends AppHelper {
	var $helpers = array('Html');

	function link($title, $repo_url = null, $options = array(), $confirmMessage = false) {
		
		if(Configure::read('App.subdomains')) {
			$domain = Configure::read('App.domain');
			
			return $this->Html->link($title, "http://{$repo_url}.{$domain}/", $options, $confirmMessage);
		} else {
			return $this->Html->link($title, array('controller' => 'repositories', 'action' => 'index', $repo_url), $options, $confirmMessage);
		}
				
	}
}