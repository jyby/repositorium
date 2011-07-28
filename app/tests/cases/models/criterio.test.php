<?php
/* Criterio Test cases generated on: 2011-07-27 19:18:20 : 1311808700*/
App::import('Model', 'Criterio');

class CriterioTestCase extends CakeTestCase {
	var $fixtures = array('app.documento', 'app.criterio', 'app.tamano_desafio', 'app.usuario', 'app.informacion_desafio', 'app.tag', 'app.experto');

	function startTest() {
		$this->Criterio =& ClassRegistry::init('Criterio');	
	}
	
	/**
	 * 
	 * After a new criteria is saved, 
	 * every document in the database must have as many InformacionDesafio entries
	 * as criteria are
	 * and
	 * every user in the database must have as many TamanoDesafio entries
	 * as criteria are
	 * 
	 */
	function testAfterSave() {
		$criterio = array(
			'id_criterio' => 1000,
			'id_contexto' => 1,
			'pregunta' => 'asdf',
			'respuesta_1' => 's',
			'respuesta_2' => 'n',
			'tamano_pack' => 1,
			'costo_pack' => 1,
			'costo_envio' => 1,
			'bono_documento_enviado_validado' => 1,
			'funcion_penalizacion_a' => 1,
			'funcion_penalizacion_b' => 1,
			'funcion_despenalizacion_a' => 1,
			'funcion_despenalizacion_b' => 1,
			'tamano_minimo_desafio' => 1,
		);
		$this->Criterio->save($criterio);
		$infos = $this->Criterio->InformacionDesafio->find('all', array('conditions' => array('InformacionDesafio.id_criterio' => 1000)));
		pr(count($infos));
	}

	function endTest() {
		unset($this->Criterio);		
		ClassRegistry::flush();
	}

}
?>