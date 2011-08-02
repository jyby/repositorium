<?php
/* InformacionDesafio Test cases generated on: 2011-07-27 20:20:54 : 1311812454*/
App::import('Model', 'InformacionDesafio');

class InformacionDesafioTestCase extends CakeTestCase {
	var $fixtures = array('app.informacion_desafio', 'app.documento', 'app.usuario', 'app.tamano_desafio', 'app.criterio', 'app.experto', 'app.tag');
	var $criteria_qty = 5;
	
	
	function startTest() {
		$this->InformacionDesafio =& ClassRegistry::init('InformacionDesafio');
	}
	
	function testMassCreateAfterCriteria() {
		$id_criterio = 42;
		$this->InformacionDesafio->massCreateAfterCriteria($id_criterio);
	
		$documents = $this->InformacionDesafio->Documento->find('all', array(
				'fields' => array('Documento.id_documento', 'Documento.autor'),
				'recursive' => -1,
				'order' => 'Documento.id_documento'
			)
		);
	
		$ids = $this->InformacionDesafio->find('all', array(
				'conditions' => array('InformacionDesafio.id_criterio' => $id_criterio), 
				'fields' => array('Documento.id_documento', 'Documento.autor'), 
				'order' => 'Documento.id_documento'
			)
		);		
		$this->assertEqual($ids, $documents);
	}
	
	function testMassCreateAfterDocument() {
		$id_documento = 42;
		$this->InformacionDesafio->massCreateAfterDocument($id_documento);
		
		$crs = $this->InformacionDesafio->Criterio->find('all', array(
				'fields' => array('Criterio.id_criterio'),
				'recursive' => -1,
				'order' => 'Criterio.id_criterio'
			)
		);
		
		$ids = $this->InformacionDesafio->find('all', array(
				'conditions' => array('InformacionDesafio.id_documento' => $id_documento),
				'fields' => array('Criterio.id_criterio'),
				'order' => 'Criterio.id_criterio'
			)
		);		
		$this->assertEqual($ids, $crs);
	}
	
	function testGetRandomDocumentsValidated() {
		$criteria_id = mt_rand(1,$this->criteria_qty);
		$confirmado = true;
		$preguntable = true;		
		$quantity = 5;		
		
		$this->_generateRecords();
		
		$ides = $this->InformacionDesafio->getRandomDocuments(compact('criteria_id', 'confirmado', 'preguntable', 'quantity'));
		
		$this->assertTrue($quantity >= count($ides));
		
		foreach($ides as $k=>$v) {
			$this->assertTrue($v['InformacionDesafio']['confirmado']);
			$this->assertTrue($v['InformacionDesafio']['preguntable']);
			$this->assertEqual($v['InformacionDesafio']['id_criterio'], $criteria_id);
			$this->assertNotNull($v['Documento']);
			$this->assertFalse(empty($v['Documento']));
		}
	}
	
	function testGetRandomDocumentsNonValidated() {
		$criteria_id = mt_rand(1,$this->criteria_qty);
		$confirmado = false;
		$preguntable = true;
		$quantity = 5;
	
		$this->_generateRecords();
	
		$ides = $this->InformacionDesafio->getRandomDocuments(compact('criteria_id', 'confirmado', 'preguntable', 'quantity'));
	
		$this->assertTrue($quantity >= count($ides));
	
		foreach($ides as $k=>$v) {
			$this->assertTrue(!$v['InformacionDesafio']['confirmado']);
			$this->assertTrue($v['InformacionDesafio']['preguntable']);
			$this->assertEqual($v['InformacionDesafio']['id_criterio'], $criteria_id);
			$this->assertNotNull($v['Documento']);
			$this->assertFalse(empty($v['Documento']));
		}
	}
		
	/*
	 * Genera $docs documentos en la tabla test, 1/$cri de cada uno de $cri criterios
	 * la mitad de ellos está validado, y la otra no
	 */
	function _generateRecords() {				
		$docs = 10;
		$cri = $this->criteria_qty;
		
		$ds = $this->InformacionDesafio->getDataSource();
		$ds->begin($this->InformacionDesafio);
		for($c = 1; $c <= $cri; $c++) {
			for($d = 1; $d <= $docs; $d++) {
				$this->InformacionDesafio->create();
				$this->InformacionDesafio->set(
					array(
					'id_documento' => $d,
				  	'id_criterio' => $c,
				  	'total_respuestas_1_no_validado' => 0,
				  	'total_respuestas_2_no_validado' => 0,
					//'respuesta_oficial_de_un_experto' => ,
				  	'total_respuestas_1_como_desafio' => 0,
				  	'total_respuestas_2_como_desafio' => 0,
			      	'confirmado' => ($d % 2 == 0 ? false : true),
					'preguntable' => true,
					)
				);
				$this->InformacionDesafio->save();
			}			
		}
		$ds->commit($this->InformacionDesafio);
	}

	function endTest() {
		unset($this->InformacionDesafio);
		ClassRegistry::flush();
	}

}
?>