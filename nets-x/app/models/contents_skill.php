<?php 
/**
* Cake version 1.2
* File: /app/models/content.php
* Model for content skills is an associative model
* Database table: contents_skills
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
* 
*
* File: /app/models/content.php
* Model for content skills is an associative model
* Database table: contents_skills
*
* @category   Model
* @package    Contents
* @author     Alice Boit <alice@boit.net>
* @copyright  2007 Alice Boit
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class ContentsSkill extends AppModel
{
    /**
    * Class name variable
    * @var string
    */
    var $name = 'ContentsSkill';

    /**
    * string with the table name used by this model (to override cake naming conventions!)
    * @var string
    */
    var $useTable = 'contents_skills';
}
?>
