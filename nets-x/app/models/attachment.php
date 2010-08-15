<?php
/**
* This model describes the attachements to upload to the db or file tree
*
* LICENSE: TODO
*
* @author     Alice Boit <boit.alice@gmail.com>
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
* This model describes the attachements to upload to the db or file tree
*
* @author     Alice Boit <boit.alice@gmail.com>
* @copyright  2007 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Attachment extends AppModel {
    /**
    * Model name
    * @var string
    */
    var $name ='Attachment';
    
    /**
    * Write the scenario id to the attachment in the DB when 
    * resources are uploaded
    * @param $id contains the attachment id
    * @param $scenario_id contains the scenario id
    */
	    function saveScenarioIdForAttachment($id = null, $scenario_id = null){  
     $this->save(array('id'=>$id, 'scenario_id'=>$scenario_id),true);   
    }
}
?>
