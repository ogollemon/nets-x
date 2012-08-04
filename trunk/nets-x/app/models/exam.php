<?php
/**
* This model describes the exams.
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
* This model describes the exams.
*
* @author     Alice Boit <boit.alice@gmail.com>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Exam extends AppModel {
    /**
    * Model Name
    * @var string
    */
    var $name ='Exam';

    /**
    * Here the relation to the assessment model is defined.
    * @var array
    */
    var $hasMany = array('Assessment' =>
                         array('className'     => 'Assessment',
                               'conditions'    => 'approvedBy>0',
                               'order'         => '',
                               'limit'         => '',
                               'foreignKey'    => 'exam_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         )
                  );
}
?>