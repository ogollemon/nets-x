<?php
/**
* This model handles the scenario data.
*
* long description goes here (TODO)...
*
* LICENSE: TODO
*
* @author     Philipp Daniel <phlipmode23@gmail.com>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 the NETS-X team
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/

/*
* Place includes, constant defines and $_GLOBAL settings here.
* Make sure they have appropriate docblocks to avoid phpDocumentor
* construing they are documented by the page-level docblock.
*/

/**
* This model handles the scenario data.
*
* long description goes here (TODO)...
*
* @author     Philipp Daniel <phlipmode23@gmail.com>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Scenario extends AppModel {

	var $name = 'Scenario';
	var $useTable = 'scenarios';
	var $actsAs = array('Attachment'); 

	/**
    * array pf POST-variables which are validated through cakePHP.
    * @var array
    */
    var $validate = array(
        'name' => array(
                'rule' => array('minLength',3),
                'required' => true,
                'message' => 'minimum length is 3'
        ),
        'topic_id' => array(
            'required' => array(
                'rule' => 'numeric',
                'required' => true,
                'message' => 'Please select a topic for the scenario.'
            )
        ),
        'score' => array(
            'range' => array(
                'rule' => 'numeric',
                'required' => true,
                'message' => 'Please enter a number.'
            )
        ),
        'timeout' => array(
            'range' => array(
                'rule' => 'numeric',
                'required' => true,
                'message' => 'Please enter a number.'
            )
        )
    );
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			
			'Script' => array('className' => 'Script',
								'foreignKey' => 'scenario_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => 'sequence_no ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Parameter' => array('className' => 'Parameter',
                                'foreignKey' => 'scenario_id',
                                'dependent' => true,
                                'conditions' => '',
                                'fields' => '',
                                'order' => 'name ASC',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
            ),
            'Parameterset' => array('className' => 'Parameterset',
                                'foreignKey' => 'scenario_id',
                                'dependent' => true,
                                'conditions' => '',
                                'fields' => '',
                                'order' => 'id ASC',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
            )
	);

	var $hasAndBelongsToMany = array(
			'Skill' => array('className' => 'Skill',
						'joinTable' => 'scenarios_skills',
						'foreignKey' => 'scenario_id',
						'associationForeignKey' => 'skill_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			'Systemaccount' => array('className' => 'Systemaccount',
						'joinTable' => 'scenarios_systemaccounts',
						'foreignKey' => 'scenario_id',
						'associationForeignKey' => 'systemaccount_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => 'name ASC',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);
	
    var $recursive = 1;

    /**
     * This function sets default values where they are not set from the DB
     *
     * @return array the Scenario with default values
     */
    function createDefault(){
        $scen = $this->create();
        $scen['Scenario']['id']='';
        $scen['Scenario']['name']='';
        $scen['Scenario']['topic_id']='';
        $scen['Scenario']['description']='';
        $scen['Scenario']['introduction']='';
        $scen['Scenario']['epilogue']='';
        return($scen);
    }

}
?>