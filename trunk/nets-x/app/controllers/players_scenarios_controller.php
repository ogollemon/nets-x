<?php
/**
 * This controller handles the scenario history of players.
 * It contains the functions to show a player history in his/her PDA profile
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class PlayersScenariosController extends AppController
{
    /**
    * class name variable
    * @var string
    */		
    var $name = 'PlayersScenarios';

    /**
    * models used
    * @var string
    */
    var $uses = array('Scenario','Player','PlayersScenario');

    /**
    * helpers array
    * @var string
    */
    var $helpers = array('Theme','Html','Javascript','Ajax');

    /**
    * gets a list of all scenarios that the player has already played.
    * It is rendered via an AJAX update in the PDA.
    * @access public requires login
    * @todo implement link and update div in PDA
    */
    function showHistory($player_id){
        $this->__requireLogin();
        //get all Scenarios which the player has already played
        $playedScenarios = $this->PlayersScenario->findAllByPlayer_id($player_id);

        $i = 0;
        foreach($playedScenarios as $playedScenario){
            $scenarioDetails = $this->Scenario->findById($playedScenario['PlayersScenario']['scenario_id'],array('name'));
            $playedScenarios[$i]['PlayersScenario']['name']=$scenarioDetails['Scenario']['name']; 
        //create an array with a new field containing the played scenarios' name
            $i++;
        }

        $this->set('playedScenarios',$playedScenarios);
        $this->render('show_history', null);//if using the ajax argument here
        //only the view show_history.thtml without the default layout is rendered
    }

}
?>