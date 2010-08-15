<?php
/**
* This user class model describes the parameter values
*
* Long description for class (TODO)...
*
* @category   Model
* @author     Alice Boit <alice@boit.net>
* @author     Thomas Geimer <Thomas.Geimer@googlemail.com>
* @copyright  2007 Alice Boit
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Parametervalue extends AppModel
{
    /**
    * Class name variable
    * @var string
    */
    var $name = 'Parametervalue';

    /**
    * table name
    * @var string
    */
    var $useTable = 'parametervalues';

    /**
    * unlocks all parameter values which have been locked for specified player id
    * @param $player_id
    */
    function unlockPlayerId($player_id=null){
        $this->updateAll(array('locked'=>0),array('locked'=>$player_id));
// $this->query('UPDATE parameter_values SET locked=0 WHERE locked=' . $player_id);
    }
}
?>