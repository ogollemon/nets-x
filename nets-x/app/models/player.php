<?php
/**
* This model handles the player data.
*
* adding, deleting, editing, ...
*
* LICENSE: TODO
*
* @author     Philipp Daniel <phlipmode23@gmail.com>
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
* This model handles the player data.
*
* Long description for class (TODO)...
*
* @author     Philipp Daniel <phlipmode23@gmail.com>
* @author     Thomas Geimer <thomas.geimer@gmail.com>
* @copyright  2007 NETS-X
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0 (TODO)
* @version    Release: @alpha@
* @since      Class available since Release 0.1 (alpha)
*/
class Player extends AppModel
{
    /**
    * class name variable
    * @var string
    */
    var $name = 'Player';
  
    /**
    * array pf POST-variables which are validated through cakePHP.
    * @var array
    */
    var $validate = array(
        'nick' => array(
            'required'=> VALID_NOT_EMPTY,
            'exists'  => array( 'rule' => 'checkExistingNick'),
    		'alphaNumeric' => array( 'rule' => 'alphaNumeric', 'message' =>'only letters and numbers allowed in nick'), 
    		'length' => array( 'rule' => array('between', 3,40), 'message' =>'nick length between 3 and 40'),
            #'specchar' => array( 'rule' => array('custom', '/^[\da-zA-Z]+$/'), 'message' =>'only letters and numbers allowed in nick'),    		
    		'startchar'  => array( 'rule' => array('custom', '/^[^\d]/'), 'message' =>'nick has to start with character') 
        ),
        'passwd' => array (
            'required' => VALID_NOT_EMPTY
        )
    );
    
    var $hasAndBelongsToMany = array(
            'Skill' => array('className' => 'Skill',
                        'joinTable' => 'players_skills',
                        'foreignKey' => 'player_id',
                        'associationForeignKey' => 'skill_id',
                        'unique' => true,
                        'conditions' => '',
                        'fields' => '',
                        'order' => '',
                        'limit' => '',
                        'offset' => '',
                        'finderQuery' => '',
                        'deleteQuery' => '',
                        'insertQuery' => ''
            )
    );
    

    /**
    * this awards the given score to the player with given player_id.
    *
    * @access public
    * @param int $player_id Player id from the DB
    * @param int $score number of positive or negetive score
    */
    function awardScore($player_id=null, $score=0){
        if ($player_id){
            $this->recursive = -1;
            $p_data = $this->read(null,$player_id);
            if (empty($p_data)){
               return false;
            }
            $newScore = $p_data['Player']['score']+$score;
            $this->id = $player_id;
            $this->unbindModel(array(
                'hasAndBelongsToMany'=>array('Skill')
                )
            );
            $this->saveField('score', $newScore);
        } else {
           $newScore = false;
        }
        return $newScore;
    }


    /**
    * if player nick is already taken, return false in validation check
    *
    * @access public
    * @param $value Player nick from the registration form
    */
   function checkExistingNick($value){
   		$valid = false;
        $exists = $this->findByNick($value);
        $valid = (empty($exists['Player']))? true : false ;
        return $valid;
    }
}
?>