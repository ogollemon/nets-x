<?php
/**
* This model handles the topic data. Topics are the top level descriptions
* of the knowledge areas that are covered in the game. One topic has several
* scenarios. 
*
* long description goes here (TODO)...
*
* LICENSE: TODO
*
* @author     Alice Boit <boit.alice@gmail.com>
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
* This model handles the topic data. Topics are the top level descriptions
* of the knowledge areas that are covered in the game. One topic has several
* scenarios. 
*
* long description goes here (TODO)...
*
* @author     Alice Boit <boit.alice@gmail.com>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Topic extends AppModel
{
    /**
    * class name variable
    * @var string
    */
    var $name = 'Topic';

    /**
    * string with the table name used by this model (to override cake naming conventions!)
    * @var string
    */
    var $useTable = 'topics';

    /**
    * Here the relation to the exams model is defined.
    * @var array
    */
    var $hasMany = array('Exam' =>
                         array('className'     => 'Exam',
                               'conditions'    => '',
                               'order'         => '',
                               'limit'         => '',
                               'foreignKey'    => 'topic_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         ),
                         'AdventureQuestion' =>
                         array('className'     => 'AdventureQuestion',
                               'conditions'    => '',
                               'order'         => '',
                               'limit'         => '',
                               'foreignKey'    => 'topic_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         ),
                         'Scenario' =>
                         array('className'     => 'Scenario',
                               'conditions'    => '',
                               'fields'        => array('id','name','use_player','description','score','evaluationtype_id','is_single_scenario','is_multiplayer_scenario','is_with_drones','timeout','approved','player_id','complete','created','modified'),
                               'order'         => 'name ASC',
                               'limit'         => '',
                               'foreignKey'    => 'topic_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         )
                  );
    
} ?>