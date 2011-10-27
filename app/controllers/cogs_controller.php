<?php
class CogsController extends AppController {

	var $name = 'Cogs';
	
	function index() {
		$repo = $this->requireRepository();
	}
	
}
?>