<?php
class Systemaccount extends AppModel {

	var $name = 'Systemaccount';
	var $useTable = 'systemaccounts';

	var $hasAndBelongsToMany = array(
       'Scenario' =>array(
          'className' => 'Scenario',
          'joinTable' => 'scenarios_systemaccounts',
          'foreignKey' => 'scenario_id',
          'associationForeignKey' => 'systemaccount_id',
          'conditions' => '',
          'order' => '',
          'limit' => '',
          'unique' => false,
          'finderQuery' => '',
          'deleteQuery' => '',
          'insertQuery' => ''
       )
    );
}
?>