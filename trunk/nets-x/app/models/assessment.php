<?php
/**
* This model describes the assessments (questions) of the exams.
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
* This model describes the assessments (questions) of the exams.
*
* @author     Alice Boit <boit.alice@gmail.com>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Assessment extends AppModel {
    /**
    * Model name
    * @var string
    */
    var $name ='Assessment';

    /**
    * array pf POST-variables which are validated through cakePHP.
    * @var array
    */
    var $validate = array(
        'text' => array(
            'required'=> VALID_NOT_EMPTY
        ),
        'exam_id' => array(
            'required'=> VALID_NOT_EMPTY
        )
    );

    /**
    * Here the relation to the answers model is defined.
    * @var array
    */
    var $hasMany = array('Answer' =>
                         array('className'     => 'Answer',
                               'conditions'    => '',
                               'order'         => '',
                               'limit'         => '',
                               'foreignKey'    => 'assessment_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         )
                  );
}
?>
