<?php
/**
 * 
 * Checks and updates user points
 * @author mquezada
 *
 */
class PointsController extends AppController {
	var $name = 'Points';
	var $uses = array();
	
	/**
	 * 
	 * redirects user to challenges
	 */
	function earn() {
		$this->Session->write('Challenge.action', 'earn');
		$this->redirect(array('controller' => 'challenges', 'action' => 'index'));
	}
	
	/**
	 * 
	 * checks if user has enough points
	 * if he does, dispatch
	 * otherwise => challenge
	 * 
	 */
	function check() {
		
	}
		
	/**
	 * 
	 * receives challenge result and add 
	 * points if successful 
	 * 
	 */
	function reward() {
		
	}
		
	/**
	 * 
	 * dispatch to desired action
	 * upload
	 * download
	 * index (earn points)
	 */
	function dispatch() {
		
	}
}