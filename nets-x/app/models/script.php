<?php
class Script extends AppModel {

	var $name = 'Script';
	var $useTable = 'scripts';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Scenario' => array('className' => 'Scenario',
								'foreignKey' => 'scenario_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasAndBelongsToMany = array(
			'Host' => array('className' => 'Host',
						'joinTable' => 'hosts_scripts',
						'foreignKey' => 'script_id',
						'associationForeignKey' => 'host_id',
						'unique' => true,
						'conditions' => '',
						'fields' => array('id', 'name', 'ip'),
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);
	
    var $recursive = 1;
    var $displayField = 'name';
    
    function createDefault($scriptinfo){
       $new = $this->create(
            array(
                  'id'=>null,
                  'name'=>'new script',
                  'description'=>'',
                  'deployment_package'=>'',
                  'script'=>'#!/bin/bash

# Scenario name : '.$scriptinfo['scriptname'].'
# Date          : '.date("M/j/Y, G:i T").'
# Author        : '.$scriptinfo['playername'].'

# Scenario version   : 1.0
# Runs under Version : NetS-X 1.0
# Author E-Mail      : write down your e-mail address, to be available for questions


# CAKEUSER : use this variable name for login user on machine
# CAKEPASS : use this variable name for login password on machine
# CAKE1, CAKE2, ... : use these variable names for your script-specific stuff
# SCRIPTHOST : The ip of the host where the scripts are distributed to.
'
            )
         );
         return ($new);
    }
    
    

}
?>