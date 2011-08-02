<?php
/* Criterio Test cases generated on: 2011-07-27 19:18:20 : 1311808700*/
App::import('Model', 'Criterio');

class CriterioTestCase extends CakeTestCase {
	var $fixtures = array('app.documento', 'app.criterio', 'app.tamano_desafio', 'app.usuario', 'app.informacion_desafio', 'app.tag', 'app.experto');

	function startTest() {
		$this->Criterio =& ClassRegistry::init('Criterio');	
	}	

	function testgetRandomCriteria() {
		$result = $this->Criterio->getRandomCriteria();
		
		// there's no data so far
		$this->assertNull($result);
		
		// insert new data
		$this->_savetwice();
		
		// test again
		$result = $this->Criterio->getRandomCriteria();
		
		$criterios = $this->Criterio->find('all');		
		$this->assertTrue(in_array($result, $criterios));
	}
	
	
	function _savetwice() {
		$records = array(
			'Criterio' => array(
					'id_contexto' => 1,
					'pregunta' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'respuesta_1' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'respuesta_2' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
					'tamano_pack' => 1,
					'costo_pack' => 1,
					'costo_envio' => 1,
					'bono_documento_enviado_validado' => 1,
					'funcion_penalizacion_a' => 1,
					'funcion_penalizacion_b' => 1,
					'funcion_despenalizacion_a' => 1,
					'funcion_despenalizacion_b' => 1,
					'tamano_minimo_desafio' => 1
			),
		);
		
		$this->Criterio->save($records);
		$this->Criterio->save($records);
	}
	
	function endTest() {
		unset($this->Criterio);		
		ClassRegistry::flush();
	}

}
?>