<?php
/**
* This model describes the answers to the assessments (questions) in exams 
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
* This model describes the answers to the assessments (questions) in exams 
*
* @author     Alice Boit <boit.alice@gmail.com>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Answer extends AppModel {
   
    /**
    * Model name
    * @var string
    */
    var $name ='Answer';
    
    /**
    * How many answers can be and must at least be specified by a player
    * @var array
    */
    var $answers = array('possible'=>5, 'required'=>2);
    
    /**
    * Here the relation to the assessment model is defined. Assessments are questions.
    * @var array
    */
    var $belongsTo = array('Assessment' =>
                           array('className'  => 'Assessment',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'assessment_id'
                           )
                     );
}
?>
