<?php
class UsedParameterset extends AppModel {

	var $name = 'UsedParameterset';
	var $useTable = 'used_parametersets';
	
	var $belongsTo = array(
            'Parameterset' => array('className' => 'Parameterset',
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