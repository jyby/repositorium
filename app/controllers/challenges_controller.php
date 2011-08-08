<?php
/**
 * Teh most important class
 *
 * 
 * the cake is a lie
 *
 * @author mquezada
 *  
 */
class ChallengesController extends AppController {
  var $uses = array('User', 'Document', 'CriteriasUser', 'CriteriasDocument', 'Criteria');

  /**
   * play the game
   */
  function index() {	
	$user = $this->_get_user();
	$criterio = $this->Criteria->getRandomCriteria();
	
	if(is_null($criterio))
		$this->_skip();
	
	$documentos = $this->Criteria->generateChallenge($user['User']['id'], $criterio);
	
	if(count($documentos) == 0) 
		$this->_skip();
	
	$this->Session->write('Desafio.criterio', $documentos[0]['CriteriasDocument']['criteria_id']);
	$to = $this->Session->read('Desafio.goto');
	
	if(strcmp($to, 'subir') == 0) {
		$puntos = $criterio['Criteria']['documentupload_cost'];
	} elseif(strcmp($to, 'bajar') == 0) {
		$puntos = $criterio['Criteria']['documentpack_cost'];
	} else {
		$puntos = null;
	}
	
	$this->set(compact('documentos', 'criterio', 'puntos'));	
  }

  /**
   * check how good it was
   */
  function validate_challenge() {
  	if(empty($this->data))
  		$this->e404();
  	
  	$user = $this->_get_user();
  	$criterio = $this->Session->read('Desafio.criterio');
  	
  	$desafio_correcto = $this->CriteriasDocument->validateChallenge($this->data['Desafio']);
	$this->CriteriasDocument->saveStatistics($this->data, $desafio_correcto);
  	$this->CriteriasUser->saveNextC($user['User']['id'], $criterio, $desafio_correcto);
  	
  	$this->_dispatch();  	
  }
  
  /**
   * skip challenge
   */
  function _skip() {
  	$this->Session->write('Desafio.passed', true);
  	$this->_dispatch();
  }
  
  /**
   * 
   * dispatch
   */
  function _dispatch() {
  	$go_to = $this->Session->read('Desafio.goto');
  	
  	if(strcmp($go_to,'earn') == 0 ) {
  		$this->Session->setFlash('Task finished / Points earned (if any)');
  		$this->redirect('/');
  	}
  	
  	$this->redirect(array('controller' => $go_to));
  }
 
  function __dispatch($desafio_correcto, $flash = true) {
  	$criterio = $this->Criteria->findByIdCriteria($this->Session->read('Desafio.criterio'));
  	 
  	if($desafio_correcto) {
  		$this->Session->write('Desafio.passed', true);
  		$to = $this->Session->read('Desafio.goto');
  		$puntos = $criterio['Criteria']['costo_envio'];
  		 
  		if(strcmp($to, 'subir') == 0) {
  			if($flash) $this->Session->setFlash(
  		  'You have passed the challenge and earned '.$puntos.' points!. Now you can add a new Document. Thank you!');
  
  			/* sumar $puntos. */
  			$this->_addPoints($puntos);
  
  			$this->redirect(array('controller' => 'subir_documento'));
  			// ingresar puntos?
  		} elseif(strcmp($to, 'bajar') == 0) {
  			$puntos = $criterio['Criteria']['costo_pack'];
  			if($flash) $this->Session->setFlash(
  		  'You have passed the challenge and earned '.$puntos.' points!. Now you can get your new Documents. Thank you!');
  
  			/* sumar $puntos */
  			$this->_addPoints($puntos);
  			$this->redirect(array('controller' => 'bajar_documento'));
  		} else {
  			$puntos = $criterio['Criteria']['costo_pack'];
  			if($flash) $this->Session->setFlash(
  		  'You have passed the challenge and earned '.$puntos.' points!');
  
  			/* sumar $puntos */
  			$this->_addPoints($puntos);
  			$this->Session->delete('Desafio');
  			$this->redirect('/');
  		}
  	} else {
  		$this->Session->write('Desafio.passed', false);
  		$this->redirect('failure');
  	}
  }
  
  
  function saltar() {
  	if(!$this->Session->read('Desafio.criterio'))
  		$this->redirect($this->referer());
  		
  	$criterio = $this->Criteria->findByIdCriteria($this->Session->read('Desafio.criterio'));
  	$to = $this->Session->read('Desafio.goto');
  	
  	if(strcmp($to, 'subir') == 0) {
  		$puntos = $criterio['Criteria']['costo_envio'];
  	} else {
  		$puntos = $criterio['Criteria']['costo_pack'];
  	}
  	
  	if($this->Session->check('User.id') && $this->Session->read('User.puntos') >= $puntos) {	    
	    $this->Session->write('Desafio.passed', true);	    
	    $this->_addPoints(-2*intval($puntos));
	    $this->_dispatch(true, false);  	        
	        
  	} else { 
	  	$this->Session->write('Desafio.passed', false);
	    $this->redirect('failure');
  	}
  }
  
  
  function failure() {
	//	$this->Session->delete('Desafio');
  }
}

?>