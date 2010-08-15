<?php
class Host extends AppModel {

	var $name = 'Host';
	var $useTable = 'hosts';

	var $validate = array(
        'ip' => array(
              'rule' => 'ip',
              'required' => true,
              'message' => 'please provide a valid IP4 address'
        ),
        'name' => array(
              'rule' => array('minLength', 2),
              'required' => true,
              'message' => 'at least 2 characters.'
        ),
        'area' => array(
              'rule' => 'numeric',
              'required' => true,
              'message' => 'a number please.'
        ),
        'description' => array(
              'rule' => array('minLength', 2),
              'required' => true,
              'message' => 'at least 2 characters.'
        )
    );
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
			'Script' => array('className' => 'Script',
						'joinTable' => 'hosts_scripts',
						'foreignKey' => 'host_id',
						'associationForeignKey' => 'script_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);

}
?>