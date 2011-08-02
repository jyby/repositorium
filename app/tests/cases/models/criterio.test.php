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
		$this->_generateRecords(3);
		
		// test again
		$result = $this->Criterio->getRandomCriteria();
		
		$criterios = $this->Criterio->find('all', array('recursive' => -1));
		$this->assertTrue(in_array($result, $criterios));
	}
	
	
	function _generateRecords($qty = 2) {
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
		
		$ds = $this->Criterio->getDataSource();
		$ds->begin($this->Criterio);
		for($i=0;$i<$qty;$i++) {
			$this->Criterio->save($records);
		}
		$ds->commit($this->Criterio);		
	}
	
	function testGenerateChallenge() {
		$proportion = 0.5;
		$user_id = 2; // (s)he has c=5, therefore 5 questions
		$c = 5;
				
		$validated = ceil($c*$proportion);
		$nvalidated = floor($c*$proportion);
		
		$this->_generateRecords(5);
		$challenge = $this->Criterio->generateChallenge($user_id, $proportion);
		//pr($challenge);
	}
	
	function endTest() {
		unset($this->Criterio);		
		ClassRegistry::flush();
	}

}
?>