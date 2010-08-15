<?php
/**
* This model handles the pool of random questions for npcs of the 2D-Adventure
*
* long description goes here (TODO)...
*
* LICENSE: TODO
*
* @author     Alice Boit <boit.alice@gmail.com>
* @copyright  2008 the NETS-X team
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
* This model handles the pool of random questions for npcs of the 2D-Adventure
*
* long description goes here (TODO)...
*
* @author     Alice Boit <boit.alice@gmail.com>
* @copyright  2008 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class AdventureQuestion extends AppModel
{
    /**
    * class name variable
    * @var string
    */
    var $name = 'AdventureQuestion';

    /**
    * string with the table name used by this model (to override cake naming conventions!)
    * @var string
    */
    var $useTable = 'adventure_questions';

    /**
    * array pf POST-variables which are validated through cakePHP.
    * @var array
    */
    var $validate = array(
        'text' => array(
            'required'=>VALID_NOT_EMPTY
        ),
        'exam_id' => array(
            'required'=>VALID_NOT_EMPTY
        )
    );
    
  	  /**
    * Here the relation to the answers model is defined.
    * @var array
    */
    var $hasMany = array('AdventureAnswer' =>
                         array('className'     => 'AdventureAnswer',
                               'conditions'    => '',
                               'order'         => '',
                               'limit'         => '',
                               'foreignKey'    => 'adventure_question_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         )
                  );

} ?>
