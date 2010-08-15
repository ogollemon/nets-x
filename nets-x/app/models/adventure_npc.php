<?php
/**
* This model handles the items and npcs of the 2D-Adventure
*
* long description goes here (TODO)...
*
* LICENSE: TODO
*
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
* This model handles the items and npcs of the 2D-Adventure
*
* long description goes here (TODO)...
*
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class AdventureNpc extends AppModel
{
    /**
    * class name variable
    * @var string
    */
    var $name = 'AdventureNpc';

    /**
    * string with the table name used by this model (to override cake naming conventions!)
    * @var string
    */
    var $useTable = 'adventure_npcs';


    function checkUnique($data, $fieldName) {
        $valid = false;
        if(isset($fieldName) && $this->hasField($fieldName))
        {
            $valid = $this->isUnique(array($fieldName => $data));
        }
        return $valid;
    }


} ?>
