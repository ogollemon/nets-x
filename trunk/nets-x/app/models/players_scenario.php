<?php
/**
* This model handles the scenario history of the player 
* (scenarios he/she has already played)
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
* This model handles the scenario history of the player 
* (scenarios he/she has already played)
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
class PlayersScenario extends AppModel
{
    /**
    * class name variable
    * @var string
    */
    var $name = 'PlayersScenario';

    /**
    * string with the table name used by this model (to override cake naming conventions!)
    * @var string
    */
    var $useTable = 'players_scenarios';

} ?>
