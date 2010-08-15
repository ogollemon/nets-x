<?php 
/**
* Cake version 1.2
* File: /app/models/content.php
* Model for content
* Database table: contents
* Controller: contents_controller in /app/controllers/contents_controller.php
* Views: /app/views/contents/index.ctp
*
* LICENSE: OPEN SOURCE
*
* @author     Alice Boit <alice@boit.net>
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
* dunno
*
* Long description for class (TODO)...
*
* @category   Model
* @package    Contents
* @author     Alice Boit <alice@boit.net>
* @copyright  2007 Alice Boit
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Article extends AppModel
{
	/**
    * Class name variable
    * @var string
    */
    var $name = 'Article';
    
    /**
     * name of DB table
     *
     * @var string name of table in DB
     */
    var $useTable = 'articles';
    
}
?>
