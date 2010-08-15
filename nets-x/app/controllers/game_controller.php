<?php
/**
 * GAME ENGINE: This controller contains the meat concerning playing a scenario.
 * It contains:
 * 1. all functions used by amfPHP for the communication between flash game and database
 * 2. for the actions displaying 
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class GameController extends AppController {

    /**
    * class name variable
    * @var string
    */
	var $name = 'Game';
	
	/**
    * Array of Strings; which models are used by this controller?
    * @var mixed
    */
	var $uses = array(
       'Resource',
       'Scenario',
	    'Script',
       'Scenariosetup',
       'Player',
       'Parameter',
       'Parameterset',
       'Parametervalue',
	    'PlayersScenario',
       'PlayersSkill',
       'Evaluationtype',
       'Skill',
	    'Host',
       'Exam',
	    'Setting',
       'Systemaccount',
	    'UsedParameterset',
	    'UsedHost'
	);

	/**
	 * This action renders the tutor overview of all scenarios currently set up in the topology
	 * The view contains a superclean button, which can cleanup a scenario in case something goes wrong.
	 * In this case the evaluateScenario() action is called with $skipEval=1
	 * @access public requires tutor rights
	 */
	function admin_index(){
	   $this->__requireRole(ROLE_TUTOR);
//	   $this->Scenariosetup->bindModel(array('hasOne' => array('Player')));
	   $this->set('scenariosetups', $this->Scenariosetup->findAll());
	   $this->set('usedParametersets', $this->UsedParameterset->findAll());
	   $this->render();
	}
		
	/**
	 * This function is called when a player clicks on "Play" in the introduction of a scenario
	 * The steps are:
	 * 1. check if the player is allowed to setup this scenario
	 * 2. get the values for scenario PARAMETERS from the DB and prepare the resource files specifically for these parameter values
	 * 3. do the environment setup (if not already set up by another player currently doing the same scenario)
	 * 4. Player setup and port forwarding to the machines which have a player setup
	 * 5. transfer and run the setup scripts on the hosts used as drones!
	 * 6. pass the resource files assigned to the systemaccount and general resources for this scenario to the view
	 * @access public requires login
	 * @param int $scenario_id the scenario id to play
	 * @param int $player_id identifies the player for whom to setup the scenario for 
	 * @todo Add a DB transaction on the designated points in order to avoid problems of 2 scenario setups interfering with each other. This is quite improbable, but COULD happen. 
	 */
    function playScenario($scenario_id=null, $player_id=null){
       
//       Configure::write('debug',2);
       
       $this->__requireLogin();
       
       $this->set('msgClass', 'error'); // on Success 'error' is overwritten by 'message'
       $this->set('rc', 0); // will be overwritten if error occurrs
       $debugInfo = array(
         'message' => 'The scenario has been set up!<br />Remember to cancel it if you do not complete it!', // eventually overwritten if error occurs. 
         'legend'=>'function playScenario($scenario_id='.$scenario_id.', $player_id='.$player_id.')',
         'command'=>'Everything went fine.',
         'rc'=>''
       );
       $this->set('debugInfo', $debugInfo);
       if (!$scenario_id || !$player_id){
          $debugInfo['message'] = 'Scenario and player not specified.';
          $this->set('debugInfo', $debugInfo);
          $this->render();
          exit;
       }
       
       // TODO: START TRANSACTION HERE!
       $this->set('debugInfo', $debugInfo);
       $scenario = $this->Scenario->read(null, $scenario_id);
       $this->set('scenario', $scenario);
       
// 1. can the scenario be set up at all?
       $preliminaryChecks = $this->_checkSetupPossibility($scenario_id, $player_id);
       if (!empty($preliminaryChecks['error'])){
          $debugInfo['message'] = $preliminaryChecks['error'];
          $this->set('debugInfo', $debugInfo);
          $this->render();
          exit;
       }
       $systemaccount_id = (isset($preliminaryChecks['Systemaccount']['id']))? $preliminaryChecks['Systemaccount']['id'] : null;
       // The scenario can be set up for the player, so make an entry in "scenariosetups"
       $new = $this->Scenariosetup->create();
       $new['Scenariosetup']['scenario_id'] = $scenario_id;
       $new['Scenariosetup']['player_id'] = $player_id;
       if (!$this->Scenariosetup->save($new)){
          $debugInfo['message'] = 'Could not create Scenariosetup.';
          $this->set('debugInfo', $debugInfo);
          $this->render();
          exit;
       }
       $new['Scenariosetup']['id'] = $this->Scenariosetup->getLastInsertId();
       
// 2. select random Values for all scripts parameters and lock them in DB!
       // 2nd param is the id of the new scenariosetup:
       $values = $this->_selectParametervalues($scenario_id, $new['Scenariosetup']['id'], $scenario['Scenario']['use_player']);
       $values['values']['$'.CAKEUSER] = $preliminaryChecks['Systemaccount']['user'];
       $values['values']['$'.CAKEPASS] = $preliminaryChecks['Systemaccount']['passwd'];
       if (isset($values['error']) && strlen($values['error']) > 0){
          $success = $this->_rollback($new['Scenariosetup']['id']); // delete the whole setup and everything belonging to it!
          if (is_array($success)){
             $debugInfo = $success;
             $debugInfo['message'] = $values['error'].'<br />'.$debugInfo['message'];
          }
          $this->set('debugInfo', $debugInfo);
          $this->render();
          exit;
       }
       
// 2.a) prepare parameter resource files for the view:
       $resources = array(); //
       $resources['Parameter'] = (isset($values['paramResources']))? $values['paramResources'] : array();
       unset($values['paramResources']);
       
// 3. if necessary do the environment setup(s) on hosts:
       if ($preliminaryChecks['envSetupNeeded']){
          
// 3.a) get EnvSetup shellscripts filled with the real values we selected in step 2:
          $scripts = $this->_prepareScripts($scenario_id, ENVIRONMENT_SETUP_SCRIPT, $values['values']);
//          if (!empty($scripts)){ debug($scripts);}
          
          $setupError = $this->_executeScripts($player_id, $scripts, ENVIRONMENT_SETUP_SCRIPT);
          if ($setupError){
             $rollback = $this->_rollback($new['Scenariosetup']['id'], $systemaccount_id);
             if ($rollback == true){
                $debugInfo['message'] = 'Sorry, the scenario environment could not be set up.';
             } else if (is_array($rollback)){
                $debugInfo['message'] = 'Fatal error: EnvSetup rollback unsuccessful. Check DB consistency!<br />'.$debugInfo['message'];
             }
             $this->set('debugInfo', $debugInfo);
             $this->render();
             exit;
          }
//          if ($setupError){ debug($setupError);exit;}

       } // end of if (envSetupNeeded)...
       

// 4. Player setup and port forwarding to the machines which have a player setup:
      // first check if a systemaccount is used and if so - lock it:
      if ($preliminaryChecks['Systemaccount']['id']){ // lock systemaccount by setting player_id:
          $this->Systemaccount->id = $preliminaryChecks['Systemaccount']['id'];
          if (!$this->Systemaccount->saveField('player_id', $player_id)){
             $debugInfo['message'] = 'Could not lock Systemaccount';
             $this->set('debugInfo', $debugInfo);
             $this->render();
             exit;
          }
       }
// 4.a) do the player setup by executing the player setup scripts:
       $scripts = $this->_prepareScripts($scenario_id, PLAYER_SETUP_SCRIPT, $values['values']);
       $setupError = $this->_executeScripts($player_id, $scripts, PLAYER_SETUP_SCRIPT);
       if ($setupError){
          $rollback = $this->_rollback($new['Scenariosetup']['id'], $systemaccount_id);
          if ($rollback){
             $debugInfo['message'] = 'Sorry, there was an error during the player setup.';
          } else {
             $debugInfo['message'] = 'Fatal error: PlayerSetup rollback unsuccessful. Check DB consistency!';
          }
          $this->set('debugInfo', $debugInfo);
          $this->render();
          exit;
       }
       
// 4.b) make entries in used_hosts and do port forwarding if necessary:
          foreach($scripts as $current){
             foreach($current['hosts'] as $id=>$ip){
                // if no entry for this host exists in UsedHosts, do port forwarding:
                if ($this->UsedHost->findCount(array('host_id'=>$id))==0){
                   $host = $this->Host->find(array('id'=>$id));
                   if (empty($host)){
                      $debugInfo['message'] = 'Error during port forwarding preparation: could not determine interface!';
                      $debugInfo['legend'] = 'port forwarding preparation';
                      $debugInfo['rc'] = 'no host for id '.$id.' found';
                      $this->set('debugInfo', $debugInfo);
                      $this->render();
                      exit;
                   }
                   $interfaces = $this->getInterfaces();
                   $interface = ($host['Host']['area']==1 || $host['Host']['area']==2)? $interfaces['player'] : $interfaces['management'];
                   $portForwardError = $this->_portForwarding($id, $ip, true, $interface);
                   if ($portForwardError){
                      $this->set('debugInfo', $portForwardError);
                      $this->render();
                      exit;
                   }
                }
                // in any case, make a new entry in used_hosts for this scenariosetup:
                $newEntry = array(
                   'id' => null,
                   'host_id' => $id,
                   'scenariosetup_id' => $new['Scenariosetup']['id']
                );
                $this->UsedHost->create();
                $this->UsedHost->save($newEntry);
             }
          }
       
       
// 5. do the DRONE setup scripts!
       $scripts = $this->_prepareScripts($scenario_id, DRONE_SETUP_SCRIPT, $values['values']);
       $droneSetupError = $this->_executeScripts($player_id, $scripts, DRONE_SETUP_SCRIPT, $values['values']['$CAKEUSER']);
       if ($droneSetupError){
          $this->set('debugInfo', $droneSetupError);
          $this->render();
          exit;
       }

       
       
// 6. get all resource files for the scenario
       if ($systemaccount_id){
          $resources['Systemaccount'] = $this->Resource->find('list', array(
             'conditions'=>'Resource.scenario_id='.$scenario_id.' AND Resource.systemaccount_id='.$systemaccount_id,
             )
          );
       } else {
          $resources['Systemaccount'] = array();
       }
       $resources['General'] = $this->Resource->find('list', array(
          'conditions'=>'Resource.scenario_id='.$scenario_id.
          ' AND Resource.systemaccount_id=0 AND Resource.sequence_no=-1'
          )
       );
          
       // TODO: END TRANSACTION HERE!
       $this->set('resources', $resources);
       $this->set('msgClass', 'message');
       $this->set('debugInfo', $debugInfo); 
       $this->set('usedHosts', $this->_getUsedHostPorts($new['Scenariosetup']['id']));
       $this->render();
    }

    /**
     * This function is called when a player clicks "I have completed the scenario" in the PDA.
     * It runs the evaluation shell scripts by default before cleaning up the scenario.
     * If $skipEval==1, only the cleanup is called (cancel scenario or clean it from admin view).
     * No points are awarded in this case. 
     * @access public requires login
     * @param int $scenario_id identifies the scenario to evaluate
     * @param int $player_id identifies the player
     * @param boolean $skipEval used to skip the real evaluation part and proceed directly to cleanup.   
     */

    
    function evaluateScenario($scenario_id, $player_id, $skipEval=false, $admin=null){

       $this->__requireLogin();
       
       $referer = $this->referer();
       $debugInfo = array(
          'message' => false,
          'legend' => 'function evaluateScenario('.$scenario_id.', '.$player_id.', '.$skipEval.', '.$admin.')',
          'command' => 'no commands available',
          'rc' => 'RC = '.EVAL_ERROR
       );
       $RC = EVAL_ERROR; // will be overwritten later
       $this->set('debugInfo', $debugInfo);
       $this->Scenario->recursive = 0;
       $scenario = $this->Scenario->read(null, $scenario_id);
       $this->set('scenario', $scenario);
       
       if (!$player_id == $this->Session->read('Player.id') || $this->Session->read('Player.role' < ROLE_TUTOR)){
          $debugInfo['message'] = 'You are only allowed to evaluate your own scenarios.';
          $this->set('debugInfo', $debugInfo);
          $this->render();
          exit;
       }
       
       $skipEval = ($skipEval==1)? true : false;
       $this->set('skipEval', $skipEval);
       $scenariosetup = $this->Scenariosetup->find('Scenariosetup.scenario_id='.$scenario_id.' AND Scenariosetup.player_id='.$player_id);
       if (empty($scenariosetup)){
          $this->redirect('/scenarios/');
          exit;
       }
//       debug($scenariosetup['Scenariosetup']['id']);exit;
       
       
    // find all parametersets for the scenario:
       $this->Parameterset->unbindModel(array(
            'belongsTo'=>array('Scenario')
            )
       );
       $this->UsedParameterset->recursive = 3;
       $usedSets = $this->UsedParameterset->findAll('UsedParameterset.scenariosetup_id='.$scenariosetup['Scenariosetup']['id']);
//       debug($usedSets);
       $values = array();
       foreach ($usedSets as $set) {
          foreach($set['Parameterset']['Parameter'] as $param){
             if (!empty($param['Parametervalue'])){
                $paramValues = Set::combine($param['Parametervalue'], '{n}.sequence_no', '{n}.value');
                $values[$param['name']] = $paramValues[$set['UsedParameterset']['sequence_no']];
             }
          }
       }

       // USE_PLAYER: if player nick is used for a scenario the parameterset was skipped
       // conclusion: shellscript won't be parsed for CAKEUSER AND CAKEPASS!
       // solution: set it manually here:
       if ($scenario['Scenario']['use_player']==1){
          $values['$'.CAKEUSER] = $this->Session->read('Player.nick');
          $values['$'.CAKEPASS] = $this->Session->read('Player.passwd_clear');
       } else {
	      // If a Systemaccount (precompiled user) is used for this scenario
	      // "use_player" is 0. Therefor the CAKEUSER and CAKEPASS variables 
	      // have to be filled with the username and the password from the
	      // systemaccount which is used for this scenario.
	      
	      // Get the system account, that is in use, by the player_id
	      $preUser = $this->Systemaccount->find('Systemaccount.player_id='.$player_id); 
	      $values['$'.CAKEUSER] = $preUser['Systemaccount']['name'];
	      $values['$'.CAKEPASS] = $preUser['Systemaccount']['passwd_clear'];
       } 
       // These values are also passed to the cleanup script.
       
       // do the evaluation:
       if (!$skipEval){
          
// A) Regular Expression based evaluation:
          if ($scenario['Scenario']['evaluationtype_id']==COMPARISON_BASED){
          	
          	// TODO: $CAKE1 $CAKE2 ... in der richtigen Lösung aus der DB durch
          	// $values['$'.'CAKE1'] etc. ersetzen !
          	// Überprüfen, ob $CAKE1 eingegeben werden kann als Admin ohne dass
          	// diese direkt ersetzt werden
          	  $comp = $scenario['Scenario']['comparison'];
          	  
          	  // Search the comparison field for cake/php variables
          	  $regExp = '/\$[A-Z]+[0-9]*/';
          	  preg_match_all($regExp, $comp, $cakeParams);
          	  
	          foreach($cakeParams[0] as $para) {
	          	  // Replace the cake/php variables with the 
	          	  // parameters from the DB
				  $comp = str_replace($para, $values[$para], $comp);
			  }
			  
              $matches = preg_match_all($comp, $this->data['Scenario']['comparison'], $matches);
              $this->set('matches',$matches);
              $this->set('regexp', $scenario['Scenario']['comparison']);
              switch ($matches){
                 case 0:
                    $RC=EVAL_FAILURE; // no match
                    break;
                 case 1:
                    $RC=EVAL_SUCCESS; // exactly one match
                    break;
                 default:
                    $RC=EVAL_ERROR; // more than one match!
              }
          }
          
          
// B) script based evaluation:
          if ($scenario['Scenario']['evaluationtype_id']==SHELL_BASED){
             $scripts = $this->_prepareScripts($scenariosetup['Scenariosetup']['scenario_id'], PLAYER_EVALUATION_SCRIPT, $values);
             $RC = $this->_executeScripts($player_id, $scripts, PLAYER_EVALUATION_SCRIPT);
          }
          $debugInfo['rc'] = 'RC = '.$RC;
          $this->set('RC', $RC);
          $this->set('debugInfo', $debugInfo);
          
          switch ($RC) {
             case EVAL_ERROR:
               $debugInfo['message'] = "There was an error during the evaluation.<br />Please try again.";
               $this->set('debugInfo', $debugInfo);
               $this->render();
               exit;
                
             case EVAL_FAILURE:
               $debugInfo['message'] = "You did not make it.<br />Try harder!";
               $this->set('debugInfo', $debugInfo);
               $this->set('usedHosts', $this->_getUsedHostPorts($scenariosetup['Scenariosetup']['id']));
               // call here _getAvailableResources function (future implementation)
               
               $this->render();
               exit;
                
             case EVAL_SUCCESS:
                $alreadyPlayed = $this->PlayersScenario->find('scenario_id='.$scenario_id.' AND player_id='.$player_id);
                if (empty($alreadyPlayed)){
                   $newScore = $this->Player->awardScore($player_id, $scenario['Scenario']['score']);
                   $history = array('player_id'=>$player_id, 'scenario_id'=>$scenario_id);
                   $this->PlayersScenario->create($history);
                   $this->PlayersScenario->save();
                } else {
                   $newScore = -1;
                }
                $this->set('awarded', $newScore);
                
                break;
             
              case NO_VALID_USERNAME:
             	$debugInfo['message'] = "No valid username.<br />Please Login or Register";
             	$this->set('debugInfo', $debugInfo);
             	exit;
               
             case SCRIPT_SUCCESS:
             default:
               $debugInfo['message'] = "Unknown RC.<br />Try again!";
               $this->set('debugInfo', $debugInfo);
               $this->set('RC', $RC);
               $this->render();
               exit;
             }
       }
       
       
       // --------- Only continue here in case of success or superclean or cancel: ------------
       
       $debugInfo['rc'] = 'evaluation passed successfully, RC='.$RC.'<br />Error during cleanup';
       
       // cleanup the whole scenario!
       // this includes the removal of port forwardings, etc.
       $totalSetups = $this->Scenariosetup->findAll('Scenariosetup.scenario_id='.$scenario_id);
       $debugInfo = $this->_cleanupScenario($scenariosetup, $values, ($totalSetups==1));
       if ($debugInfo){
          $this->set('debugInfo', $debugInfo);
          $this->set('RC', $RC);
          $this->render();
          exit;
       }
       
       // Now remove the the whole scenariosetup from DB:
       if (!$this->Scenariosetup->del($scenariosetup['Scenariosetup']['id'], true)){
          $debugInfo['message'] = 'ERROR: The scenario setup could not be deleted from the Database.';
          $this->set('debugInfo', $debugInfo);
          $this->render();
          exit;
       }
       
       // redirect to the appropriate page afterwards:
       if ($skipEval){ // evaluation is skipped (CANCEL or superclean)
          $admin = '/'.Configure::read('Routing.admin').'/game/';
          ### if via logoutRequest
          if(isset($this->params['requested'])) {	
             return true;
             exit;
          }
          if ($referer == $admin){
             $url = $admin;
             $this->Session->setFlash('Scenariosetup has been cleaned up.');
          } else {
             $url = '/scenarios/';
          }
          $this->redirect($url);
          exit;
       }
    }
    
    /**
     * This helper function is used to get the interface settings from the DB and pass them to the _portForwarding() function.
     * It is called from playScenario() and _cleanupScenario();
     * @access public requires tutor rights
     * @return array containing internal and external interfaces
     */
    function getInterfaces(){
       //$this->__requireRole(ROLE_TUTOR);
       $res = $this->Setting->find('all', array('conditions'=>'id='.MANAGEMENT_INTERFACE.' OR id='.PLAYER_INTERFACE.' OR id='.OPENVPN_INTERFACE));
       $int = (!empty($res))? Set::combine($res, '{n}.Setting.id', '{n}.Setting.value'): false;
       $interfaces = ($int)? array('management'=>$int[MANAGEMENT_INTERFACE], 'player'=>$int[PLAYER_INTERFACE], 'openvpn'=>$int[OPENVPN_INTERFACE])  : array('management'=>'eth4', 'player'=>'eth1', 'openvpn'=>'eth0');
       return $interfaces;
    }
    
    /**
     * This function contains the core tests if a scenario can be setup or not.
     * It is used by the playScenario() function. It checks:
     * 1. parameter sanity
     * 2. player active?
     * 3. does player have the required skills?
     * 4. if a single scenario is running, it takes up the whole topology, no other scenario can be setup
     * 5. only one scenario can be setup for each player at a time
     * 6. if requested scenario is "single player" and somebody already plays, no setup is possible 
     * @access protected
     * @param int $scenario_id identifies the scenario to check
     * @param int $player_id identifies the player who wants to setup the scenario
     * @return array containing error message if setup not possible!
     */
    function _checkSetupPossibility($scenario_id, $player_id){   
       
       // this array is filled by the checks below!
       // it is returned to the calling function playScenario which evaluates what to do next! 
       $returnData = array(
           'Systemaccount' => array(
                'user'=>null,
                'passwd'=>null,
                'id'=>false
            ),
           'envSetupNeeded' => false,
           'error' => null,
           'scripts'=>array() //this will be filled with scenario data
       );
       
       // each player can only setup and play one scenario at a time!
       $other = $this->Scenariosetup->find('Scenariosetup.player_id='.$player_id, false);
       if(!empty($other)){
          $this->redirect('/game/evaluateScenario/'.$other['Scenario']['id'].'/'.$player_id);
          exit;
       }
       
       $scenario = $this->Scenario->read(null, $scenario_id);
       $player = $this->Player->read(null, $player_id);
       
       // check scenario/player data ---------------------------------------
       if (empty($scenario) || empty($player)){
          $returnData['error'] = 'scenario/player not found.';
          return $returnData;
       }
       
       // check if player is active ---------------------------------------
       if ($player['Player']['active']!=1){
          $returnData['error'] = 'Not allowed, Player is disabled!';
          return $returnData;
       }
       
       // check if player meets the required skills ---------------------------
       if (!$this->_playerHasRequiredSkills($scenario['Skill'], $player['Skill'])){
          $returnData['error'] = 'You do not have enough skills!';
          return $returnData;
       }
       
       // do the most important scenario checks here: (IF-Monster) ===============================================
       $singleScenario = $this->_isSingleScenarioRunning();
       if (!empty($singleScenario)){ // a single scenario is running:
          if ($singleScenario['id'] == $scenario_id){   // running same as requested? -----------
             if ($singleScenario['is_multiplayer_scenario']==1){
                   // OKAY up to here, continue below this IF-Monster
             } else { // the running single scenario is not multiplayer: ------------------------------------------
                $returnData['error'] = 'Not allowed!<br />Someone else is doing this scenario already.';
             }
          } else { // running single scenario is not the same as requested: ---------------------------------
             $returnData['error'] = 'Not allowed!<br />A different single scenario is running.';
          }
          
       } else { // =================== NO single scenario is running: ======================================
          
          if ($scenario['Scenario']['is_multiplayer_scenario']){ // requested scenario is multi-player:
             $running = $this->Scenariosetup->find('scenario_id='.$scenario_id);
             if (!empty($running)){ // same multiplayer scenario is already running: --------------------
                // envSetupNeeded = false; //this is default already!
             } else { // the same multiplayer scenario is NOT running: -------------------------------------
                $returnData['envSetupNeeded'] = true; // IMPORTANT!
                $availableResources = $this->_getAvailableResources($scenario_id);
                if (!$availableResources){
                   $returnData['error'] = 'Not allowed!<br />The resources are not available.';
                }
             }
             // OKAY!
             
          } else { // requested scenario is a single player scenario: ----------------------------------------
             
             $running = $this->Scenariosetup->find('scenario_id='.$scenario_id);
             if (empty($running)){ // single player is possible, because scenario is not running: ------------
                $returnData['envSetupNeeded'] = true; // IMPORTANT!
                $availableResources = $this->_getAvailableResources($scenario_id);
                if (!$availableResources){
                   $returnData['error'] = 'All resources are in use, scenario setup impossible.';
                }
                // OKAY!
             } else { // single player is not possible somebody else has set it up already  -----
                $returnData['error'] = 'Scenario setup not possible.<br />Somebody else plays this scenario already.';
             }  
          }
       } // end of IF-Monster: ======================================================
       
       
       // When you get HERE, all checks have been successful until now.
       // now check for precompiled/player Systemaccount:
       if ($scenario['Scenario']['use_player']==0){ // the requested scenario uses system accounts: -------
          $possibleAccounts = $this->_getAvailableSystemaccounts($scenario_id);
          if (!empty($possibleAccounts)){ // player max is not reached (not all systemaccounts are in use):-------
             $rand = rand(0,(sizeof($possibleAccounts)-1)); // get a random id between 0 and size-1
             $returnData['Systemaccount'] = $possibleAccounts[$rand];
             // OKAY
          } else { // all Systemaccounts are in use! ---------------------------------------
             $returnData['error'] = 'Not allowed!<br />Someone else is playing this scenario already.';
          }
       } else {// the player user/password is used for scenario: --------------------------
          $returnData['Systemaccount']['user'] = $player['Player']['nick'];
          $returnData['Systemaccount']['passwd'] = $this->Session->read('Player.passwd_clear');
       }
       
       $returnData['Script'] = $scenario['Script'];
       return $returnData;
    }

    /**
     * This function selects the values for the $CAKE variables in shell scripts.
     * It also creates new entries in the DB table 'used_parametersets' where the sequence_numbers are stored and if they are locked.
     * Called within function playScenario().
     * @access protected
     * @param int $scenario_id the id of the scenario to setup
     * @param int $scenariosetup_id the setup id for the currently running "instance" of this scenario
     * @param int $use_player this is used to skip the "system login" data parameterset 
     * @return array array('values'=>$values, 'error'=>'')
     */
    function _selectParametervalues($scenario_id, $scenariosetup_id, $use_player){
       
       // find all parametersets for the scenario:
       $this->Parameterset->unbindModel(array(
            'belongsTo'=>array('Scenario')
            )
       );
       $this->Parameterset->recursive = 2;
       $parametersets = $this->Parameterset->findAll('scenario_id='.$scenario_id);
       if (empty($parametersets)){
          return array('values'=>array(), 'error'=>''); // there seem to be no parametersets besides CAKEUSER and CAKEPASS...
       }
       $values = array(); // <-- this will store the REAL values which are returned!
       $resources = array(); // <-- this will store the resources for the paramsets and values
       foreach ($parametersets as $set) {

          $sequence_no = -1; // the sequence no which will be taken
          // pick a random sequence_no which will be used for ALL values in this set.
          // since all parameters within one set should have the same amount of values,
          // we can just take the size of the first parametervalue sub-array: 
          
          // Check if only $CAKEUSER and $CAKEPASS are in this set: 
          $systemLoginSet = (sizeof($set['Parameter'])==2 && $set['Parameter'][0]['name']=='$'.CAKEUSER && $set['Parameter'][1]['name']=='$'.CAKEPASS);
          if ($systemLoginSet){
             continue; // if ONLY the system credentials are in the parameterset, it is empty!
             // But this is okay, it will be filled with either the player name and pass or a systemaccount!
             // To avoid an error during random parametervalue selection, skip this parameterset!
             // note: during EVAL and CLEANUP this requires special treatment.
             // (search for "USE_PLAYER" in this class)
          }
          
          if ($set['Parameterset']['lock']==0){
             $rand = rand(0,sizeof($set['Parameter'][0]['Parametervalue'])-1);
          } else {
             // find out all sequence_numbers already in use and locked:
             $lockedValues = $this->UsedParameterset->findAll('parameterset_id='.$set['Parameterset']['id'].' AND locked=1');
             if (sizeof($lockedValues) == sizeof($set['Parameter'][0]['Parametervalue'])){
                return array('values'=>array(), 'error'=>'All available values are in use.');
             }
             $lockedValues = (!empty($lockedValues))? Set::combine($lockedValues, '{n}.UsedParameterset.sequence_no', '{n}.UsedParameterset.sequence_no') : array();
             // loop thru values in the set and find the available ones:
             $rand = rand(0, ( sizeof($set['Parameter'][0]['Parametervalue']) - sizeof($lockedValues) - 1) );
          }
          
          // now that we have a random sequence_no, take the according value:
          foreach ($set['Parameter'] as $param) {
             $counter = $rand; // reset the counter until available is found.
             foreach ($param['Parametervalue'] as $val) {
                 $available = !isset($lockedValues[$val['sequence_no']]);
                 if ($available){
                    if ($counter == 0){
                       $values[$param['name']] = $val['value'];
                       break;
                    }
                    $counter--;
                 }
             }
             $sequence_no = ($sequence_no < 0)? $val['sequence_no'] : $sequence_no;
          }
          
          // make new Used Parameterset and insert lock on the random sequence_no if applicable:
          $new = $this->UsedParameterset->create();
          $new['UsedParameterset']['scenariosetup_id'] = $scenariosetup_id;
          $new['UsedParameterset']['parameterset_id'] = $set['Parameterset']['id'];
          $new['UsedParameterset']['sequence_no'] = $sequence_no;
          $new['UsedParameterset']['locked'] = $set['Parameterset']['lock']; // lock seq# if applicable
          if (!$this->UsedParameterset->save($new)){
             return array('values'=>array(), 'error'=>'Error saving UsedParametersets! Check DB consistency!', 'paramResources'=>array());
          }
          
          // check for resources for this value and also give it back:
          $resources = $this->Resource->find('list', array(
             'conditions'=>'Resource.scenario_id='.$scenario_id
                           .' AND Resource.parameterset_id='.$set['Parameterset']['id']
                           .' AND Resource.sequence_no='.$sequence_no,
             )
          );
       }
       
        
       return array('values'=>$values, 'error'=>'', 'paramResources'=>$resources);
    }
   
    /**
     * Here the shellscripts are prepared for deployment.
     * The $CAKE parameters in shell scripts are replaced with real values from the provided $values array.
     * This function is called within the playScenario() as well as the evaluateScenario() functions.
     * @access protected
     * @param int $scenario_id the scenario id
     * @param int $scripttype_id defines the type of shell script (see app/config/scripttypes.php for definitions)
     * @param array $values array with the parameter values to replace the $CAKE variables with
     * @return $array the scripts including the hosts they are run on
     */
    function _prepareScripts($scenario_id, $scripttype_id, $values){
       //order the shell scripts according to type and sequence_no:
       $this->Script->unbindModel(array(
            'belongsTo'=>array('Scenario')
            )
       );
       $scenarioScripts = $this->Script->findAll('scenario_id='.$scenario_id.' AND scripttype_id='.$scripttype_id, null, 'Script.sequence_no ASC');
       $scripts = array();
       foreach ($scenarioScripts as $script){
          $shellscript = $script['Script']['script'];
          // make the replacement of $CAKE variables with real values:
          foreach ($values as $param=>$value) {
            $shellscript = str_replace($param, $value, $shellscript);
          }
          //escape single quotes or error during script pipe!
          $shellscript = str_replace("'", "'\''", $shellscript);
          //$shellscript = str_replace(chr(9),' ',$shellscript); // replace Tabs not necessary
          // to avoid 'event not found' error: 
          $shellscript = str_replace('#!/bin/bash',' #!/bin/bash',$shellscript);
          $hosts = Set::combine($script['Host'], '{n}.id', '{n}.ip');
          array_push($scripts, array('script'=>$shellscript, 'hosts'=>$hosts, 'deployment_package'=>$script['Script']['deployment_package']));
       }
       // The scripts are ordered by sequence_no from SQL query
       // for each script we also have the hosts they run on in an array(id=>IP)
       // this is important so we know where to run the scripts!
       return $scripts;
    }
    
    /**
     * This function runs the given shellscript(s) from array $shellscripts
     * according to the policy defined by its type ($scripttype_id)
     * The CAKEUSER must only be given for DRONE_SETUP scripts (for naming conventions)
     * This function is called from the playScenario(), evaluateScenario() functions. 
     * @access protected
     * @param int $player_id identifies the player
     * @param array $shellscripts contains the shell scripts of one type for a scenario
     * @param int $scripttype_id the script type of the scripts (see app/config/scripttypes.php)
     * @param string $CAKEUSER provided only for DRONE_SETUP scripts; they run on this system account
     * @return string null if okay, RC for PLAYER_EVALUATION_SCRIPT, String with message for error
     */
    function _executeScripts($player_id, $shellscripts, $scripttype_id, $CAKEUSER=null){
       
       foreach($shellscripts as $current){
          $current['filename'] = 'scripttype'.$scripttype_id.'_' . uniqid($player_id) . '.sh'; // temporary random filename for script!
          foreach ($current['hosts'] as $host_id=>$host_ip) {
// 1. Software pipe: put required software packets on required host via scp:
             $swRC = 0;
             if (strlen($current['deployment_package'])>0){
                $swPipeCommand = 'scp -F '.SSH_CONFIG.' '.PACKAGES.$current['deployment_package'].' root@'.$host_ip.':/tmp';
                passthru($swPipeCommand, $swRC);
                if ($swRC!=0){
                   $debugInfo = array(
                      'message' => 'Error for software pipe of '.$current['deployment_package'].' on '.$host_ip, // if script pipe fails, abort! Scenario can not be run
                      'legend' => 'function _executeScripts()',
                      'command' => $swPipeCommand,
                      'rc' => 'RC = '.$swRC. ' for script pipe command' 
                   );
                   return $debugInfo;
                }
             }
             
// 2. script pipe: put the current script on that host:
             $RC = 0;
             // now write this script via ssh to the host:
             $pipeCommand = 'echo -e \''.$current['script'].'\' | ssh -qqF '.SSH_CONFIG.' root@'.$host_ip.' "cat > /tmp/'.$current['filename'].';"';
             passthru($pipeCommand, $RC);
             if ($RC!=0){
                $debugInfo = array(
                  'error' => 'Error for script pipe of '.$current['filename'].' on '.$host_ip, // if one script fails, abort! Scenario can not be run 
                  'legend'=>'scriptpipe',
                  'command'=>$pipeCommand,
                  'rc'=>'RC='.$RC.' for script '.$current['filename'].' on '.$host_ip
                );
                return $debugInfo;
             }
             
// 3. script execution:
             $execCommand = 'ssh -qqF '.SSH_CONFIG.' root@'.$host_ip.' "chmod +x /tmp/'.$current['filename'].'; /tmp/'.$current['filename'].';"';
             passthru($execCommand, $RC);
             // do not evaluate RC here, because for PLAYER_EVALUATION_SCRIPT it needs to be >0  -> see 4.a) below 
             $rmCommand = 'ssh -qqF '.SSH_CONFIG.' root@'.$host_ip.' "rm /tmp/'.$current['filename'].'"';
             // ssh -qqF /var/www/nets-x/app/shellscripts/ssh_config root@127.0.0.1 "rm /tmp/scripttype5_148c54e63a5ffa.sh"
             if (Configure::read('debug')<2){ // remove shell scripts if debug=={0,1}
                passthru($rmCommand, $rmRC);
                if ($rmRC!=0){
                   $debugInfo = array(
                     'message'=> 'deletion of script failed.',
                     'legend' => 'function _executeScripts',
                     'command' => $rmCommand,
                     'rc' => 'RC='.$RC.' for deletion of '.$current['filename'].' on '.$host_ip
                   );
                   return $debugInfo;
                }
             }
             
// 4. Special cases:
//  a) Player eval script returns the Return Code RC:
             if ($scripttype_id==PLAYER_EVALUATION_SCRIPT){
                return $RC; // in this case return the return code for further processing in $this->evaluateScenario!
             } else if ($RC!=0){
                $debugInfo = array(
                  'message' => 'Error during execution of '.$current['filename'].' on '.$host_ip, // if one script fails, abort! Scenario can not be run
                  'legend'=>'function _executeScripts',
                  'command'=>$execCommand,
                  'rc'=>'RC='.$RC.' during execution of '.$current['filename'].' on '.$host_ip
                );
                return $debugInfo;
             }
             
//  b) execution of drone action (the script generated by drone setup script):
             if ($scripttype_id==DRONE_SETUP_SCRIPT){
                // drone script which was generated by the first
                // runs in background (&) even if drone user logs out (nohup).
                $droneRC = 0;

                //$execCommand = 'ssh -qqF '.SSH_CONFIG.' DRONE_'.$CAKEUSER.'@'.$host_ip.' "nohup ./'.DRONE_SCRIPT.' &;"';
                // bash befehl: ssh -qqF SSH_CONFIG DRONE_$CAKEUSER@$host_ip 'exit 0'
                $execCommand = 'ssh -qqF '.SSH_CONFIG.' DRONE_'.$CAKEUSER.'@'.$host_ip.' \'exit 0\''; 
                //$execCommand = 'ssh -qqF '.SSH_CONFIG.' root@'.$host_ip.' \'su -c "nohup /home/DRONE_'.$CAKEUSER.'/'.DRONE_SCRIPT.' &" DRONE_'.$CAKEUSER.'\'';
				passthru($execCommand, $droneRC);
				echo $droneRC;
				//exec($execCommand);
				if($droneRC != 0) {
	                $debugInfo = array(
	                  'message' => 'Error during execution of drone script'.$current['filename'].' on '.$host_ip, // if one script fails, abort! Scenario can not be run
	                  'legend'=>'function _executeScripts',
	                  'command'=>$execCommand,
	                  'rc'=>'RC='.$RC.' during execution of drone script '.$current['filename'].' on '.$host_ip
	                );
                	return $debugInfo;
				}
             }
          }
       }
       return null; // if $debugInfo == null no error
    }
    

    
    /**
     * This function either adds port forwarding for an IP or deletes it.
     * ($add==true)-->add forwarding; called from the playScenario()
     * ($add=false)-->remove port forwarding; called from the evaluateScenario()
     * @access protected
     * @param int $host_id host id
     * @param int $ip ip address of host for port forwarding
     * @param boolean $add true: add port rule, false: remove rule
     * @param string $outgoingInterface name of the game server's outgoing interface for the port forwarding rule
     * @param int $destPort default is 22
     * @return int Return code of shell ssh command to decide further action
     */
    function _portForwarding($host_id, $ip, $add, $outgoingInterface, $destPort=22){
       $RC = 0;
       $IPTABLES = '/sbin/iptables';
       $interfaces = $this->getInterfaces();
       $openvpnInterface = $interfaces['openvpn'];
       
       $addParam = ($add)? '-A' : '-D';
       $sourcePort = START_PORT + $host_id;
       $wwwPort = WWW_START_PORT + $host_id;
       $ramsesPort = WWW_RAMSES_PORT;
       $command = $IPTABLES.' -L -t nat | grep -e dpt:'.$sourcePort.'.*to:'.$ip.' | wc -l';
       $numRules = exec( 'ssh -qqF '.SSH_CONFIG.' root@127.0.0.1 '.$command );
       // the add/remove command for iptables:
       $command = $IPTABLES.' -t nat '.$addParam.' PREROUTING -p tcp -i '.$openvpnInterface.'  --destination-port '.$sourcePort.' -j DNAT --to '.$ip.':'.$destPort.';';
       $command .= $IPTABLES.' -t nat '.$addParam.' PREROUTING -p tcp -i '.$openvpnInterface.'  --destination-port '.$wwwPort.' -j DNAT --to '.$ip.':80;';
       $command .= $IPTABLES.' -t nat '.$addParam.' PREROUTING -p tcp -i '.$openvpnInterface.'  --destination-port '.$ramsesPort.' -j DNAT --to '.$ip.':8000;';
       
       
       $addConditionTrue = ($add && $numRules == 0); // only run the "add" command if no rule exists:
       $remConditionTrue = (!$add && $numRules > 0); // only run the "remove" command if 1 rule exists
       if ($addConditionTrue || $remConditionTrue){
          passthru( 'ssh -qqF '.SSH_CONFIG.' root@127.0.0.1 "'.$command.'"' , $RC);
       }
       if ($RC != 0){
          $debugInfo = array(
            'message' => 'There was an error during port forwarding.',
            'legend'=>'function _portForwarding ('.$host_id.', '.$ip.', '.$addParam.', '.$outgoingInterface.', '.$destPort.')',
            'command'=>$command,
            'rc' => 'RC='.$RC.' for host '.$host_id.', number of iptables rules: '.$numRules
          );
          return $debugInfo;
       }
       return null;
    }
    
    /**
     * This function deletes the scenariosetup and resets any reserved systemaccount.
     * It is called whenever something goes wrong in playScenario() and the effects need to be reversed.
     * @access protected
     * @param int $scenariosetup_id
     * @param int $systemaccount_id
     * @return Boolean true if okay, renders on error
     */
    function _rollback($scenariosetup_id, $systemaccount_id = null){
       // first unlock the used systemaccount of the player if necessary:
       if ($systemaccount_id){
          $this->Systemaccount->id = $systemaccount_id;
          $rc = $this->Systemaccount->saveField('player_id', 0);   
       }
       if (!$this->Scenariosetup->del($scenariosetup_id, true)){
          $debugInfo = array(
            'message' => 'Sorry, the scenario could not be cleaned up.',
            'legend'=>'rollback',
            'command'=>'$this->Systemaccount->id = '.$systemaccount_id.'<br />$rc = $this->Systemaccount->saveField(\'player_id\', 0);',
            'rc'=>'$rc = '.$rc
          );
          return $debugInfo;
       }
       return true;
    }
    
    /**
     * This function checks if a player has the needed skills for a scenario.
     * It is called within the _checkSetupPossibility() function.
     * @access protected
     * @param array $requirements the required skills
     * @param array $playerSkills the skills of the player
     * @return boolean true if player meets the skill requirements, false if not
     */
    function _playerHasRequiredSkills($requirements, $playerSkills){ 
       if (empty($requirements)){
          return true; // there are no requirements!
       } else if (empty($playerSkills)) { 
          return false; // there are requirements, but player has no skills at all!
       }
       $playerSkills = Set::combine($playerSkills, '{n}.id', '{n}.id');
       $requirements = Set::combine($requirements, '{n}.id', '{n}.id');
       $unfulfilled = sizeof($requirements); // this has to decrease to 0!
       foreach ($requirements as $id){
          if (isset($playerSkills[$id])){
             $unfulfilled --;
          }
       }
       return($unfulfilled==0); // if nothing is unfulfilled, true => allow!
    }
    
    /**
     * This function is used to determine if a single scenario is currently set up.
     * It gets all entries from scenariosetups table and checks for each running scenario if it is a single scenario.
     * called within _checkSetupPossibility() 
     * @access protected
     * @return mixed the scenario data of the running single scenario; no running SingleScen=>false
     */
    function _isSingleScenarioRunning(){
        $this->Scenario->recursive = 0;
        $running = $this->Scenariosetup->findAll();
        foreach($running as $r){
           if ($r['Scenario']['is_single_scenario'] == 1){
              return $r['Scenario'];
           }
        }
        return false;
    }
    
    /**
     * This function selects all systemaccounts for a scenario and checks if they are currently used.
     * If all are in use scenario cannot be setup. Called from _checkSetupPossibility().
     * @access protected
     * @param int $scenario_id
     * @return array array of possible systemaccount_ids
     */
    function _getAvailableSystemaccounts($scenario_id){
       // remove all model associations except Systemuser 
        $this->Scenario->unbindModel(
           array(
               'hasMany'=>array('Resource', 'Script', 'Parameter', 'Parameterset'),
               'hasAndBelongsToMany' => array('Skill')
           )
        );
       $this->Scenario->id = $scenario_id;
       $this->Scenario->recursive = 1;
       $maxPlayers = $this->Scenario->read(null, $scenario_id);
//       $maxPlayers = Set::combine($maxPlayers['Systemaccount'], '{n}.id', '{n}.player_id');
       $available = array();
       foreach($maxPlayers['Systemaccount'] as $precompiled){
          if ($precompiled['player_id'] == 0){ // this one is currently not used by a player
             $info = array(
                'user'   => $precompiled['name'],
                'passwd' => $precompiled['passwd_clear'],
                'id'     => $precompiled['id']
             );
             array_push($available, $info); // add its id to list of possible systemaccounts
          }
       }
       return ($available);

    }
    
    /**
     * DUMMY function because resource availability is for future improvements
     * @access protected
     * @param int $scenario_id identifies the scenario
     * @return boolean always true at the moment (see todo)
     * @todo implement some functionality if needed
     */
    function _getAvailableResources($scenario_id){
		$available = true;
    	return $available; //just return
    }

    /**
     * This function gets all used hosts for a scenario setup and returns them.
     * The return array also contains a description used in the view!
     * Called directly before rendering _playScenario() and in evaluateScenario() on EVAL_FAILURE.
     * @access protected
     * @param int $scenariosetup_id identifies the setup instance for a player
     * @return array contains the host ports used for scenario (5000 plus host id)
     */
    function _getUsedHostPorts($scenariosetup_id){
       $usedHosts = $this->UsedHost->find('all', array('conditions'=>'scenariosetup_id='.$scenariosetup_id));
       $hosts = array();
       if (!empty($usedHosts)){
          foreach($usedHosts as $host) {
             $h = $this->Host->read(null, $host['UsedHost']['host_id']);
             $port = $h['Host']['id'] + START_PORT;
             $hosts[$port] = $h['Host']['description'];
          }
       }  
       return $hosts;
    }
    
    
    /**
     * This function takes care of the cleanup of both player and environment (for last scenario setup).
     * It is called from within evaluateScenario().
     * @access protected
     * @param array $scenariosetup identifies the running scenario for a player
     * @param array $values contains the parameter values in use
     * @param int $cleanupEnv determines if a environment cleanup needs to be done (only for last scenario).
     * @return String Error message on error, false if okay
     */
    function _cleanupScenario($scenariosetup, $values, $cleanupEnv = false){
       
       $this->__requireLogin();
       $debugInfo = array(
          'message' => false,
          'legend' => 'function _cleanupScenario( array($scenariosetup), array($values), $cleanupEnv='.$cleanupEnv.')',
          'command' => 'no commands available',
          'rc' => 'no RC yet.'
       );
       
//1. find out the systemaccount and unlock it:       
       if ($scenariosetup['Scenario']['use_player']==0){
          $this->Systemaccount->recursive = 0;
          $sysaccount = $this->Systemaccount->find('Systemaccount.player_id='.$scenariosetup['Scenariosetup']['player_id']);
          $user = $sysaccount['Systemaccount']['name'];
          // unlock systemaccount in DB:
          $this->Systemaccount->id = $sysaccount['Systemaccount']['id'];
          $this->Systemaccount->saveField('player_id', 0);
          //TODO what if this unlock fails?
       } else {
          $data = $this->Player->read(null, $scenariosetup['Scenariosetup']['player_id']);
          $user = $data['Player']['nick'];
       }
       
//2. do the player cleanup:
       $scripts = $this->_prepareScripts($scenariosetup['Scenariosetup']['scenario_id'], PLAYER_CLEANUP_SCRIPT, $values);
       $debugInfo = $this->_executeScripts($scenariosetup['Scenariosetup']['player_id'], $scripts, PLAYER_CLEANUP_SCRIPT);
       if ($debugInfo){
          return $debugInfo;
       }
       // no error!

// 3. remove port forwarding for each PLAYER_CLEANUP script , if no one else uses the host:
       foreach($scripts as $current){
          foreach($current['hosts'] as $id=>$ip){
             // if more than one entry for this host exists in UsedHosts,
             // don't remove port forwarding.
             // Only remove it if just ONE host is there (the one to be cleaned):
             $numUsedHosts = $this->UsedHost->find('count', array('host_id'=>$id, 'scenariosetup_id'=>$scenariosetup['Scenariosetup']['id']));
             if ($numUsedHosts==1){
                $host = $this->Host->find(array('id'=>$id));
                if (empty($host)){
                   $debugInfo['message'] = 'Error during port forwarding deletion preparation: could not determine interface!';
                   $debugInfo['rc'] = 'no host for id '.$id.' found';
                   $this->set('debugInfo', $debugInfo);
                   $this->render();
                   exit;
                }
                $interfaces = $this->getInterfaces();
                $interface = ($host['Host']['area']==1 || $host['Host']['area']==2)? $interfaces['player'] : $interfaces['management'];
                $debugInfo = $this->_portForwarding($id, $ip, false, $interface); // 4rd param false to remove!
                $cleanupEnv = true;
                if ($debugInfo){
                   return ($debugInfo);
                }
             }
             // delete the entry in used_hosts for this scenariosetup:
             $oldEntry = $this->UsedHost->find(array('host_id'=>$id, 'scenariosetup_id'=>$scenariosetup['Scenariosetup']['id']));
             if (!empty($oldEntry)){
                $this->UsedHost->del($oldEntry['UsedHost']['id']);
             }
          }
       }
       
       
       
// 4. do the environment cleanup if necessary:
       if ($cleanupEnv){
          $scripts = $this->_prepareScripts($scenariosetup['Scenariosetup']['scenario_id'], ENVIRONMENT_CLEANUP_SCRIPT, $values);
          $debugInfo = $this->_executeScripts($scenariosetup['Scenariosetup']['player_id'], $scripts, ENVIRONMENT_CLEANUP_SCRIPT);
          if ($debugInfo){
             return $debugInfo;
          }
       }
       return false; // no error!
       
    }
    
}
?>