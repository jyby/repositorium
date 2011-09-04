<?php
/* CriteriasDocument Test cases generated on: 2011-08-06 19:00:58 : 1312671658*/
App::import('Model', 'CriteriasDocument');

class CriteriasDocumentTestCase extends CakeTestCase {
	var $fixtures = array('app.criterias_document', 'app.document', 'app.criteria', 'app.repository', 'app.user', 'app.criterias_user', 'app.tag', 'app.expert', 'app.repositories_user');
	var $criteria_qty = 5;	
	
	function startTest() {
		$this->CriteriasDocument =& ClassRegistry::init('CriteriasDocument');
	}
	
	function testMassCreateAfterCriteria() {
		$id_criterio = 42;
		$repo_id = 42;
		$this->CriteriasDocument->massCreateAfterCriteria($id_criterio, $repo_id);
	
		$documents = $this->CriteriasDocument->Document->find('all', array(
					'fields' => array('Document.id', 'Document.user_id'),
					'recursive' => -1,
					'order' => 'Document.id',
					'conditions' => array('repository_id' => $repo_id),
			)
		);
	
		$ids = $this->CriteriasDocument->find('all', array(
					'conditions' => array('CriteriasDocument.criteria_id' => $id_criterio, 'Criteria.repository_id' => $repo_id), 
					'fields' => array('Document.id', 'Document.user_id'), 
					'order' => 'Document.id',
			)
		);
// 		pr($documents); pr($ids); exit;
		
		$this->assertEqual($ids, $documents);
	}
	
	function testMassCreateAfterDocument() {
		$id_documento = 42;
		$repo_id = 42;
		$this->CriteriasDocument->massCreateAfterDocument($id_documento, $repo_id);
	
		$crs = $this->CriteriasDocument->Criteria->find('all', array(
					'fields' => array('Criteria.id'),
					'recursive' => -1,
					'order' => 'Criteria.id',
					'conditions' => array('repository_id' => $repo_id),
			)
		);
	
		$ids = $this->CriteriasDocument->find('all', array(
					'conditions' => array('CriteriasDocument.document_id' => $id_documento, 'Criteria.repository_id' => $repo_id),
					'fields' => array('Criteria.id'),
					'order' => 'Criteria.id'
			)
		);
		$this->assertEqual($ids, $crs);
	}
	
	function testGetRandomDocumentsValidated() {
		$criteria_id = mt_rand(1,$this->criteria_qty);
		$confirmado = true;
		$preguntable = true;
		$quantity = 5;
		$repository_id = 42;
	
		$this->_generateRecords($repository_id);
	
		$ides = $this->CriteriasDocument->getRandomDocuments(compact('criteria_id', 'confirmado', 'preguntable', 'quantity', 'repository_id'));
	
		$this->assertTrue($quantity >= count($ides));
	
		foreach($ides as $k=>$v) {
			$this->assertTrue($v['CriteriasDocument']['validated']);
			$this->assertTrue($v['CriteriasDocument']['challengeable']);
			$this->assertEqual($v['CriteriasDocument']['criteria_id'], $criteria_id);
			$this->assertNotNull($v['Document']);
			$this->assertFalse(empty($v['Document']));
		}
	}
	
	function testGetRandomDocumentsNonValidated() {
		$criteria_id = mt_rand(1,$this->criteria_qty);
		$confirmado = false;
		$preguntable = true;
		$quantity = 5;
		$repository_id = 42;
	
		$this->_generateRecords($repository_id);
	
		$ides = $this->CriteriasDocument->getRandomDocuments(compact('criteria_id', 'confirmado', 'preguntable', 'quantity', 'repository_id'));
	
		$this->assertTrue($quantity >= count($ides));
	
		foreach($ides as $k=>$v) {
			$this->assertTrue(!$v['CriteriasDocument']['validated']);
			$this->assertTrue($v['CriteriasDocument']['challengeable']);
			$this->assertEqual($v['CriteriasDocument']['criteria_id'], $criteria_id);
			$this->assertNotNull($v['Document']);
			$this->assertFalse(empty($v['Document']));
		}
	}
	
	/*
	 * Genera $docs documentos en la tabla test, 1/$cri de cada uno de $cri criterios
	* la mitad de ellos está validado, y la otra no
	*/
	function _generateRecords($repo_id) {
		$docs = 10;
		$cri = $this->criteria_qty;
	
		$ds = $this->CriteriasDocument->getDataSource();
		$ds->begin($this->CriteriasDocument);
		for($c = 1; $c <= $cri; $c++) {
			for($d = 1; $d <= $docs; $d++) {
				$this->CriteriasDocument->create();
				$this->CriteriasDocument->set(
				array(
					'document_id' => $d,
					'repository_id' => $repo_id,
				  	'criteria_id' => $c,
				  	'total_answers_1' => 0,
				  	'total_answers_2' => 0,
				  	'official_answer' => ($d % 2 == 0 ? null : 1),
			      	'validated' => ($d % 2 == 0 ? false : true),
					'challengeable' => true,
					)
				);
				$this->CriteriasDocument->save();
			}
		}
		$ds->commit($this->CriteriasDocument);
	}
	
	function testValidateChallenge() {
		/*
		 * challenge correct
		*/
		$data = array(
			array('respuesta' => 2, 'criteria_id' => 1, 'document_id' => 1),
			array('respuesta' => 1, 'criteria_id' => 1, 'document_id' => 2)
		);
	
		$this->assertTrue($this->CriteriasDocument->validateChallenge($data));
	
		/*
		 * challenge incorrect
		*/
		$data = array(
			array('respuesta' => 1, 'criteria_id' => 1, 'document_id' => 3),
			array('respuesta' => 1, 'criteria_id' => 1, 'document_id' => 4)
		);
	
		$this->assertFalse($this->CriteriasDocument->validateChallenge($data));
	
		/*
		 * challenge with no official answer
		*/
		$data = array(
			array('respuesta' => 2, 'criteria_id' => 2, 'document_id' => 1),
			array('respuesta' => 1, 'criteria_id' => 2, 'document_id' => 2)
		);
	
		$this->assertTrue($this->CriteriasDocument->validateChallenge($data));
	}
	
	function testSaveStatisticsCorrect() {
		/*
		 * challenge correct
		* id 1,2
		*/
		$data = array(
			array('respuesta' => 2, 'criteria_id' => 1, 'document_id' => 1), //valid
			array('respuesta' => 1, 'criteria_id' => 1, 'document_id' => 2) //nonvalid
		);
	
		$this->CriteriasDocument->saveStatistics($data, true);
		$info1 = $this->CriteriasDocument->find('first', array('conditions' => array('CriteriasDocument.id' => 1)));
		$info2 = $this->CriteriasDocument->find('first', array('conditions' => array('CriteriasDocument.id' => 2)));
	
		/*
		 * yes +1
		*/
		$this->assertTrue($info1['CriteriasDocument']['total_answers_1'] === '1');
		$this->assertTrue($info1['CriteriasDocument']['total_answers_2'] === '2');
	
		/*
		 * no +1
		*/
		$this->assertTrue($info2['CriteriasDocument']['total_answers_1'] === '2');
		$this->assertTrue($info2['CriteriasDocument']['total_answers_2'] === '1');
	}
	
	function testSaveStatisticIncorrect() {
		/*
		 * challenge incorrect
		* id 3,4
		*/
		$data = array(
			array('respuesta' => 1, 'criteria_id' => 1, 'document_id' => 3), // validated
			array('respuesta' => 1, 'criteria_id' => 1, 'document_id' => 4) // non-valid
		);
	
		$this->CriteriasDocument->saveStatistics($data, false);
		$info1 = $this->CriteriasDocument->find('first', array('conditions' => array('CriteriasDocument.id' => 3)));
		$info2 = $this->CriteriasDocument->find('first', array('conditions' => array('CriteriasDocument.id' => 4)));
	
		/*
		 * no +1
		*/
		$this->assertTrue($info1['CriteriasDocument']['total_answers_1'] === '2');
		$this->assertTrue($info1['CriteriasDocument']['total_answers_2'] === '1');
	
		/*
		 * no changes
		*/
		$this->assertTrue($info2['CriteriasDocument']['total_answers_1'] === '1');
		$this->assertTrue($info2['CriteriasDocument']['total_answers_2'] === '1');
	}
	
	
	function testEntry() {
		$data = array(
				'criteria_id' => 100,
				'document_id' => 100
		);
	
		$info = $this->CriteriasDocument->entry($data);
	
		$this->assertFalse($info);
	}

	function endTest() {
		unset($this->CriteriasDocument);
		ClassRegistry::flush();
	}

}
?>