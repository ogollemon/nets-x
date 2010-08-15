<?php 
/**
* Cake version 1.2
* File: /app/models/parameter.php
* Model for the user handling
* Database table: parameters
* Controller: parameters_controller in /app/controllers/parameters_controller.php
* Views: /app/views/parameters/index.ctp
*
* LICENSE: OPEN SOURCE
*
* @author     Alice Boit <alice@boit.net>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 Alice Boit
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
* This user class model describes the parameter used 
* for the shell scripts
*
* Long description for class (TODO)...
*
* @category   Model
* @author     Alice Boit <alice@boit.net>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 Alice Boit
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Parameter extends AppModel
{
    /**
    * Class name variable
    * @var string
    */
    var $name = 'Parameter';

    /**
    * table name
    * @var string
    */
    var $useTable = 'parameters';
    
    var $hasMany = array('Parametervalue' =>
                         array('className'     => 'Parametervalue',
                               'conditions'    => '',//TODO locked==0
                               'order'         => 'sequence_no ASC',
                               'limit'         => '',
                               'foreignKey'    => 'parameter_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         )
                  );
}
?>