<?php

class RepositoriesController extends AppController {
	var $name = 'Repositories';
	
	function index() {
		$this->redirect('create');
	}
	
	function create() {
		
	}
}