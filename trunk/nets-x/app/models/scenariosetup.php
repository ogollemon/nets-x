<?php
class Scenariosetup extends AppModel {

	var $name = 'Scenariosetup';
	var $useTable = 'scenariosetups';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Scenario' => array('className' => 'Scenario',
								'foreignKey' => 'scenario_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => array('id', 'name', 'use_player', 'is_single_scenario', 'is_multiplayer_scenario', 'is_with_drones'),
								'order' => ''
			),
			'Player' => array('className' => 'Player',
                                'foreignKey' => 'player_id',
                                'dependent' => false,
                                'conditions' => '',
                                'fields' => array('id', 'nick', 'name', 'surname',  'score'),
                                'order' => ''
            )
	);

	var $hasMany = array(
			'UsedParameterset' => array('className' => 'UsedParameterset',
								'foreignKey' => 'scenariosetup_id',
								'dependent' => true, // they are deleted if scenariosetup is deleted!
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'UsedHost' => array('className' => 'UsedHost',
                                'foreignKey' => 'scenariosetup_id',
                                'dependent' => true, // they are deleted if scenariosetup is deleted!
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