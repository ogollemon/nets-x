<?php
/**
 * This controller deals with everything related with the 2D flash adventure game.
 * It contains:
 * 1. all functions used by amfPHP for the communication between flash game and database
 * 2. for the actions displaying 
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @author     Philipp Daniel <phlipmode23@gmail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class AdventureController extends AppController
{
   /**
   * class name variable
   * @var string
   */
   var $name = 'Adventure';
   
   /**
   * Array of Strings; which models are used by this controller?
   * @var mixed
   */
   var $uses = array(
        'AdventureItem',
        'AdventuresessionItem',
        'AdventureTriggerarea',
        'AdventuresessionTriggerarea',
        'AdventureNpc',
        'AdventuresessionNpc',
        'Player',
        'Skill',
        'Topic',
        'PlayersScenario',
        'PlayersSkill'
        );

   /**
   * helpers array
   * @var mixed
   */
   var $helpers = array('Form','Html','Javascript','Ajax');
   
   /**
   * index is the default function when /adventure is called.
   * It renders the view with the flash game.
   * It is also the home page of NetS-X after you are logged in.
   * Player ID is given to the VIEW, in order to hand it over to the flash game!
   * @access public requires login
   */
   function index()
   {
     $this->__requireLogin();
     $player_id = $this->Session->read('Player.id');
     $this->set('pid', $player_id);
     $this->set('bodyExtra', true);
     $this->render();
   }
   
   /**
   * This helper function is used for time measurement between flash game and webserver
   * @access public remote
   * @return true
   */
   function ping(){
     $this->autoRender = false;
     return (true);
   }
   
   /**
   * This function returns the COMPLETE current "sessionstate" of the flash game
   * @access public remote
   * @param int $player_id the player id
   * @return array The relevant data
   */
   function getSession($player_id=null){
     $this->autoRender = false;
     if (!$player_id){
        return (array());
     } else {
        $this->Player->bindModel(
        array('hasMany' => array(
              'AdventuresessionNpc' => array(
                  'className' => 'AdventuresessionNpc'
              ),
              'AdventuresessionItem' => array(
                  'className' => 'AdventuresessionItem'
              ),
              'AdventuresessionTriggerarea' => array(
                  'className' => 'AdventuresessionTriggerarea'
              )
           )
        ));
        return($this->Player->findById($player_id, array('x', 'y', 'map_id', 'pda_state', 'direction')));
     }
   }
   
   /**
   * This sets the Adventuresession data of the player and returns success.
   * @access public remote
   * @param int $player_id the player id
   * @param int $npc_id id of the NPC
   * @param int $x x coordinate in the 2D game
   * @param int $y y coordinate in the 2D game
   * @param int $map_id id of the map
   * @param int $pda_state number of state the pda is in
   * @param int $direction defines the direction the player avatar is facing
   * @return boolean successful
   */
   function setSessionPlayer ($player_id, $x=-1, $y=-1, $map_id=-1, $pda_state=-1, $direction=0){
     $this->autoRender = false;
     $data = array(
       'x'        => $x,
       'y'        => $y,
       'map_id'   => $map_id,
       'pda_state'=> $pda_state,
    'direction'=> $direction, 
     );
     $this->Player->id = $player_id;
     if ($this->Player->save($data)){
        return (true);
     } else {
        return (false);
     }
   }
   
   /**
   * This changes the score of player with id $player_id
   * @access public remote
   * @param int $player_id
   * @param int $value can be negative
   * @return boolean $success
   */
   function changeScore($player_id, $value=0){
     $this->autoRender = false;
     $success = $this->Player->awardScore($player_id, $value);
     $ret = (!empty($success))? true : false;
     return $ret;
   }
   
   /**
   * This sets the Adventuresession data of one NPC for given player, returns success.
   * @access public remote
   * @param int $player_id the player id
   * @param int $npc_id id of the NPC
   * @param int $x x coordinate in the 2D game
   * @param int $y y coordinate in the 2D game
   * @param int $state_id number of state the NPC is in
   * @return boolean successful
   */
   function setSessionNpc ($player_id, $npc_id=-1, $x=-1, $y=-1, $state_id=-1){
     $this->autoRender = false;
     $data = array(
       'player_id'=>$player_id,
       'npc_id'=>$npc_id,
       'x'     =>$x,
       'y'     =>$y,
       'state_id'=>$state_id
     );
     $npc = $this->AdventuresessionNpc->find(array('player_id'=>$player_id, 'npc_id'=>$npc_id));
     if (empty($npc)){
        $new = $this->AdventuresessionNpc->create($data);
        $new['AdventuresessionNpc']['id'] = null;
     } else {
        $new = array('AdventuresessionNpc'=>$data);
        $new['AdventuresessionNpc']['id'] = $npc['AdventuresessionNpc']['id'];
     }
     if ($this->AdventuresessionNpc->save($new)){
        return (true);
     } else {
        return (false);
     }
   }
   
   /**
   * This sets the Adventuresession data of one Item for given player, returns save success.
   * @access public remote
   * @param int $player_id the player id
   * @param int $item_id id of the item
   * @param int $state_id number of state the NPC is in
   * @return boolean successful
   */
   function setSessionItem ($player_id, $item_id=-1, $state_id=-1){
     $this->autoRender = false;
     $data = array(
       'player_id'=>$player_id,
       'item_id'=>$item_id,
       'state_id'=>$state_id
     );
     $npc = $this->AdventuresessionItem->find(array('player_id'=>$player_id, 'item_id'=>$item_id));
     if (empty($npc)){
        $new = $this->AdventuresessionItem->create($data);
        $new['AdventuresessionItem']['id'] = null;
     } else {
        $new = array('AdventuresessionItem'=>$data);
        $new['AdventuresessionItem']['id'] = $npc['AdventuresessionItem']['id'];
     }
     if ($this->AdventuresessionItem->save($new)){
        return (true);
     } else {
        return (false);
     }
   }
   
   /**
   * This sets the Adventuresession data of one Triggerarea for given player, returns save success.
   * @access public remote
   * @param int $player_id the player ID
   * @param int $triggerarea_id the ID of triggerarea
   * @param int $state_id the state number the triggerarea is in
   * @return boolean successful
   */
   function setSessionTriggerarea ($player_id, $triggerarea_id=-1, $state_id=-1){
     $this->autoRender = false;
     $data = array(
       'player_id'=>$player_id,
       'triggerarea_id'=>$triggerarea_id,
       'state_id'=>$state_id
     );
     $npc = $this->AdventuresessionTriggerarea->find(array('player_id'=>$player_id, 'triggerarea_id'=>$triggerarea_id));
     if (empty($npc)){
        $new = $this->AdventuresessionTriggerarea->create($data);
        $new['AdventuresessionTriggerarea']['id'] = null;
     } else {
        $new = array('AdventuresessionTriggerarea'=>$data);
        $new['AdventuresessionTriggerarea']['id'] = $npc['AdventuresessionTriggerarea']['id'];
     }
     if ($this->AdventuresessionTriggerarea->save($new)){
        return (true);
     } else {
        return (false);
     }
   }
   
   /**
   * gets all the completed scenarios for given $player_id
   * @access public remote
   * @param int $player_id the player id
   * @return array all completed scenarios for player
   */
   function getCompletedScenarios($player_id){
     $this->autoRender = false;
     $entry = $this->PlayersScenario->findAllByPlayerId($player_id, array('scenario_id', 'adventure_notified' ));
     $ret = (empty($entry))? array() : $entry;
     return($ret);
   }
   
   /**
   * The "adventure_notified" given history entry is set to 1 for given $player_id and $scenario_id
   * @access public remote
   * @param int $player_id the player id
   * @param int $scenario_id the scenario id
   * @return boolean success
   */
   function setScenarioCompleteNotification($player_id, $scenario_id){
     $this->autoRender = false;
     $entry = $this->PlayersScenario->find(array('player_id'=>$player_id, 'scenario_id'=>$scenario_id));
     if (empty($entry)){
        return false;
     } else {
        $this->PlayersScenario->id = $entry['PlayersScenario']['id'];
        if ($this->PlayersScenario->saveField('adventure_notified',1)){
           return (true);
        } else {
           return (false);
        }
     }
   }
   
   /**
   * This function is called from the flash game to get all data about a player with a given id.
   * @access public remote
   * @param int $id the player_id
   * @return mixed an array with player data on success, false on error
   */
   function getPlayerData($id) {
     $this->autoRender = false; // render without default layout
     return $this->Player->findById($id);
   }
   
   /**
   * This function is called from the flash game when an event occurrs, which unlocks
   * a specific skill for the player. The output string of the view is given back to FLASH.
   * @access public remote
   * @param int $player_id the player id
   * @param int $skill_id the skill id
   * @return boolean true on success, false on error
   */
   function unlockSkill($player_id, $skill_id){
     $this->autoRender = false; // render without default layout
     //check if skill is already unlocked for this player
     $alreadyUnlocked = $this->PlayersSkill->find(array('player_id'=>$player_id, 'skill_id'=>$skill_id));
     if (!empty($alreadyUnlocked['PlayersSkill'])){
        return(true); // skill is already unlocked
     } else {
        if($this->PlayersSkill->create(array('player_id'=>$player_id,'skill_id'=>$skill_id)) && $this->PlayersSkill->save()){
           return(true);
        } else {
           return(false);
        }
     }
   }
   
   /**
   * This function is called from the flash game for a list of maps
   * @access public remote
   * @return mixed array with maps or error message
   */
   function getMaps(){
     $this->autoRender = false; // render without default layout
     $map = $this->AdventureMap->findAll();
   
     if (!empty($map)){
        return($map); //give data back to flash game
     } else {
        return('ERROR: Maps were not found in DB.'); //Maps not found in DB error
     }
   }
   
   /**
   * This function is called from the flash game when a new map with a specific id needs to be loaded
   * @access public remote
   * @param int $id the map id
   * @return mixed the map array or an error message
   */
   function getMap($id){
     $this->autoRender = false; // render without default layout
     $map = $this->AdventureMap->findById($id);
   
     if (!empty($map)){
        return($map['AdventureMap']); //give data back to flash game
     } else {
        return('ERROR: Map with id '.$id.' was not found in DB.'); //Map not found in DB error
     }
   }
   
   /**
   * This function is called from the flash game when tile data is needed:
   * @access public remote
   * @param int $id the tile id
   * @return mixed array with tile data or error message
   */
   function getTile($id=null){
     $this->autoRender = false; // render without default layout
     $data = $this->AdventureTile->findById($id);
     if (!empty($data['AdventureTile'])){
        return($data['AdventureTile']); //give data back to flash game
     } else {
        return('ERROR: Tile with id '.$id.' was not found in DB.'); //Map not found in DB error
     }
   }
   
   /**
   * This function is called from the flash game when Door data is needed:
   * @access public remote
   * @param int $id the door id
   * @return array with door data or error message
   */
   function getDoor($id=null){
     $this->autoRender = false; // render without default layout
     $door = $this->AdventureDoor->findById($id);
     if (!empty($door['AdventureDoor'])){
        return($door['AdventureDoor']); //give data back to flash game
     } else {
        return('ERROR: Door with id '.$id.' was not found in DB.'); //Map not found in DB error
     }
   }
   
   /**
   * This function is called from the flash game when Item data is needed:
   * @access public remote
   * @param int $id the Item id
   * @return mixed the array with item data or error message
   */
   function getItem($id=null){
     $this->autoRender = false; // render without default layout
     $item = $this->AdventureItem->findById($id);
     if (!empty($item['AdventureItem'])){
        return($item['AdventureItem']); //give data back to flash game
     } else {
        return('ERROR: Item with id '.$id.' was not found in DB.');
     }
   }
   
   /**
   * This function gets all questions related to one item from the DB:
   * @access public remote
   * @param int $itemId the item ID
   * @return mixed the question data array or error message
   */
   function getQuestionsForItem($itemId=null){
     $this->autoRender = false; // render without default layout
     $questions = $this->AdventureQuestion->findAllByItemId($itemId);
     if (!empty($questions)){
        return($questions); //give data back to flash game
     } else {
        return('ERROR: No questions for item id '.$itemId.' found in DB.');
     }
   }
   
   /**
   * This function is called from the StatemachineEditor to save an npc to the database
   * @access public remote
   * @param int $id identifies the NPC
   * @param string $xml the XML data of the NPC
   * @param string $editor XML of metadata for the editor (for displaying the states properly)
   * @return true on success, on error returns array with NPC data
   */
   function editNpc($id, $xml, $editor){
     $this->autoRender = false; // render without default layout
     $npc = $this->AdventureNpc->findById($id);
     $npc['AdventureNpc']['npcid'] = $id;
     $npc['AdventureNpc']['xml_data'] = $xml;
     $npc['AdventureNpc']['editor_data'] = $editor;
     $this->AdventureNpc->validate = array();
     if ($this->AdventureNpc->save($npc)){
        return(true);
     } else {
        return $npc;
     }
   }
   
   /**
   * This function gets all NPCs from the DB and returns them to flash.
   * @access public remote
   * @return mixed the array with NPC data or error message
   */
   function getNpcs(){
     $this->autoRender = false; // render without default layout
     $npcs = $this->AdventureNpc->findAll();
     $npcNames = array();
     foreach($npcs as $npc) {
        array_push($npcNames,array('name' =>$npc['AdventureNpc']['name'], 'id'=>$npc['AdventureNpc']['id']));
     }
     if (!empty($npcNames)){
        return($npcNames); //give data back to flash game
     } else {
        return('ERROR: NO NPC IN DATABASE.');
     }
   }
   
   /**
   * This function gets all npcs, items and triggerareas back to the flash game
   * @access public remote
   * @return mixed array with npcs, triggerareas, and items on success or error message on error  
   */
   function getObjectData(){
     $this->autoRender = false; // render without default layout
     $npcs = $this->AdventureNpc->findAll();
     $items = $this->AdventureItem->findAll();
     $tas = $this->AdventureTriggerarea->findAll();
     $all[0] = $npcs;
     $all[1] = $items;
     $all[2] = $tas;
     if (!empty($all)){
        return($all); //give data back to flash game
     } else {
        return('ERROR: NO NPC IN DATABASE.');
     }
   }
   
   /**
   * This function returns a specific NPC to the flash game  
   * @access public remote
   * @param $id the NPC's id
   * @return mixed the array with NPC data or error message
   */
   function getNpcById($id){
     $this->autoRender = false; // render without default layout
     $npc = $this->AdventureNpc->findById($id);
     if (!empty($npc)){
        return($npc['AdventureNpc']); //give data back to flash game
     } else {
        return('ERROR: NO NPC IN DATABASE.');
     }
   }
   
   /**
   * This function returns an array with all skills (id and name)
   * @access public remote
   * @return mixed array with skills or error message
   */
   function getSkills(){
     $this->autoRender = false; // render without default layout
     $skills = $this->Skill->find('all');
     $skillNames = array();
     foreach($skills as $skill) {
        array_push($skillNames,array('name' =>$skill['Skill']['name'], 'id'=>$skill['Skill']['id']));   
     }
     if (!empty($skillNames)){
         return($skillNames); //give data back to flash game
     } else {
         return('ERROR: NO SKILLS IN DATABASE.');
     }
   }
   
   /**
   * This function returns an array with all Topics
   * @access public remote
   * @return mixed array with topic data or error message
   */
   function getTopics(){
     $this->autoRender = false; // render without default layout
     $all = $this->Topic->find('all');
     $topics = array();
     foreach($all as $topic) {
        array_push($topics,array('name' =>$topic['Topic']['name'], 'id'=>$topic['Topic']['id']));  
     }
     if (!empty($topics)){
         return($topics); //give data back to flash game
     } else {
         return('ERROR: NO TOPICS IN DATABASE.');
     }
   }
   
   /**
   * This function renders the SMEditor
   * @access public requires login
   */
   function admin_smEditor(){
      $this->__requireRole(ROLE_AUTHOR);
      $player_id = $this->Session->read('Player.id');
      $this->set('headline','State Machine Editor');
      $this->set('pid', $player_id);
   }
   
   /**
   * This function is used by the SMEditor to create a new NPC with a given name
   * @access public remote
   * @param string $name new name to assign to the NPC
   * @return mixed the id of the newly created NPC or an error message
   */        
   function createNpc($name){
    	$this->autoRender = false;
    	$npc['AdventureNpc'] = array('name'=>$name);
      $this->AdventureNpc->validate = array();
    	if ($this->AdventureNpc->save($npc)){
        $result = array();
        array_push($result, array('id' => $this->AdventureNpc->getLastInsertId(), 'name' => $name)); 
        return $result[0];
      } else {
        return "ERROR: NPC NOT ADDED";
      } 
   }
   
   /**
   * This function is used by the SMEditor to get all images from library
   * @access public remote
   * @return mixed array with images 
   */
   function getObjectImages(){
           $folder = new Folder;
           $folder->cd(APP.'webroot'.DS.'library'.DS.'graphics'.DS.'objects');
           $images = $folder->ls(true,true); // $folder[1] are the files
           $images = (sizeof($images[1])>0)? Set::extract($images[1], '{n}') : array();
           return $images;
        }
  }
?>
