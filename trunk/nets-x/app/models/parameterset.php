<?php
class Parameterset extends AppModel {

	var $name = 'Parameterset';
	var $useTable = 'parametersets';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Scenario' => array('className' => 'Scenario',
								'foreignKey' => 'scenario_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'Parameter' => array('className' => 'Parameter',
								'foreignKey' => 'parameterset_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>