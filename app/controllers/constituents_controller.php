<?php
class ConstituentsController extends AppController {

	var $name = 'Constituents';
	
	function index() {
		$repo = $this->requireRepository();
	}
	
}
?>