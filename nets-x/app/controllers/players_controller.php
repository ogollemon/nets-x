<?php
/**
 * This controller handles the players actions and profile processes
 * adding, deleting, editing, ...
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @author     Philipp Daniel <phlipmode23@gmail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class PlayersController extends AppController
{
    /**
    * class name variable
    * @var string
    */
    var $name = 'Players';

    /**
    * Array of Strings; which models are used by this controller?
    * @var array
    */	
    var $uses = array(
        'Player',
        'PlayersScenario',
        'PlayersSkill',
        'Skill',        
    	### 
    	'Scenario',			### tmp für test logout->cleanUp
    	'Scenariosetup',	### für logout->cleanUp
    	###
    	'Systemaccount'
    	
    );

    /**
    * Array of Strings; which helpers are used by the view?
    * @var array
    */
    var $helpers = array('Html','Form','Javascript','Ajax');
    
    /**
     * array of Strings: which components (besides 'Session') does the controller use?
     * @var array list of components
     */
    var $components = array('RequestHandler');
    
    /**
     * this action redirects whenever the request was not ajaxed.
     * @access private
     */
    function __limitAjax(){
        if (!$this->RequestHandler->isAjax()){
           $this->redirect('/authoring');
           return;
        }
    }

    /**
    * index is the default function when /players is called.
    * It renders the profile of logged in player on the PDA.
    * @access public requires login
    */
    function index()
    {
        $this->__requireLogin();
        $this->__limitAjax();
        $player = $this->Player->findByNick($this->Session->read('Player.nick'));
        $this->set('player', $player['Player']);
        $this->render();
    }

    /**
    * This action renders an overview of all players ordered by name
    * It is used for player administration and to assign roles
    * @access public requires tutor role
    */
    function admin_index()
    {
        $this->__requireRole(ROLE_TUTOR);
        $this->set('Players', $this->Player->findAll(null,null,'nick ASC'));
    }

    /**
    * This action edits the player with the given nick
    * @access public requires tutor role
    * @param $nick Player nick from the DB
    */
    function admin_edit($nick=null)
    {
        $this->__requireRole(ROLE_TUTOR);
        $this->set('headline', 'edit player &quot;'.$nick.'&quot;');

        if (empty($this->data)){
            $player = $this->Player->findByNick($nick);
            //debug($player); exit;
            if (empty($player)){
                $this->Session->setFlash('Player &quot;'.$nick.'&quot; not found in DB.');
                $this->redirect('index'); exit;
            }
            if ($player['Player']['role'] < ROLE_AUTHOR){
                $role = ROLE_PLAYER;
            } else if ($player['Player']['role'] < ROLE_TUTOR){
                $role = ROLE_AUTHOR;
            } else {
                $role = ROLE_TUTOR;
            }
            $this->set('role', $role);
            $this->set('data', $player);
        } else {// form data submitted:
            $data = $this->data;
            $player = $this->Player->findById($data['Player']['id']);
            $oldPasswd = $player['Player']['passwd'];
            // if both passwords are not identical:
            //check if all required fields are correct:
            if (strcmp($data['Player']['passwd2'], $data['Player']['passwd']) != 0){
                $this->Player->invalidate('passwd', 'match');
                $data['Player']['nick'] = $nick;
                $this->set('data', $data);
                $this->set('role', $data['Player']['role']);
                $this->render(); return;
            }
            if (strlen(trim($this->data['Player']['passwd']))==0 && strlen(trim($this->data['Player']['passwd2']))==0){
                // take old password:
                $data['Player']['passwd'] = $oldPasswd;
            } else {
                // encrypt new password:
                $data['Player']['passwd'] = md5($data['Player']['passwd']);
            }
            // unset the repetition of password for saving
            unset($this->data['Player']['passwd2']);
                //debug($data);exit;
            if ($this->Player->save($data)){
                $this->Session->setFlash('Player &quot;'.$nick.'&quot; has been successfully changed.');
                $this->redirect('index'); exit;
            } else {
                $this->Session->setFlash('Could not save player &quot;'.$data['Player']['nick'].'&quot;!');
                $this->redirect('index'); exit;
            }
            //debug($data);exit;
        }
    }

    /**
    * deletes the player with the given nick
    * @access public requires tutor role
    * @param $nick Player nick from the DB which will be deleted
    */
    function admin_delete($nick=null)
    {
        $this->__requireRole(ROLE_TUTOR);

        $player = $this->Player->findByNick($nick);
        //debug($player); exit;
        if (empty($player)){
            $this->Session->setFlash('Player &quot;'.$nick.'&quot; not found in DB.');
            $this->redirect('index'); exit;
        } else {
            // delete Player:
            if ($this->__deletePlayer($player['Player']['id'])){
                $this->Session->setFlash('Deletion of player &quot;'.$nick.'&quot; was successful.');
                $this->redirect('index'); exit;
            } else {
                $this->flash('Error deleting player &quot;'.$nick.'&quot;.', 'index'); exit;
            }
        }

    }

    /**
     * This function is used to administer the skills of a player
     * @access public requires tutor rights
     * @param int $nick the player name
     */
    function admin_skills($nick=null){
       $this->__requireRole(ROLE_TUTOR);
       if (empty($this->data)){
          $this->data = $this->Player->findByNick($nick);
          if (empty($this->data)){
             $this->Session->setFlash('Unknown Player');
             $this->redirect(array('action'=>'index'));
             exit;
          }
          $skills = $this->Skill->find('all');
          $this->set(compact('skills'));
       } else {
          $player_id = $this->data['Skill']['player_id'];
          unset($this->data['Skill']['player_id']);
          $owned = $this->PlayersSkill->find('count', array('conditions'=>'player_id='.$player_id));
          if ($owned > 0){ // only delete if player HAS skills! 
             if (!$this->PlayersSkill->deleteAll('player_id='.$player_id)){
                $this->Session->setFlash('There was an error saving the skills.');
                $this->redirect('index');
                exit;
             }
          }
          // for each skill > 0 create new PlayersSkill
          $success = true;
          foreach($this->data['Skill'] as $id=>$owned){
             if ($owned > 0){
                $new = array(
                   'skill_id'=>$owned,
                   'player_id'=>$player_id
                );
                $this->PlayersSkill->create($new);
                if (!$this->PlayersSkill->save()){
                   $success = false;
                }
             }
          }
          if (!$success){
             $this->Session->setFlash('The skills could not be saved.');
          } else {
             $this->Session->setFlash('The skills have been saved.');
          }
          $this->redirect('index');
          exit;
       }
    }
    
    /**
     * this function actually does the deletion of player from the DB.
     * It also erases all skills and the player�s scenario history 
     * @access private
     * @param int $id identifies the player
     * @return boolean true on success, false on error
     */
    function __deletePlayer($id){
        if ($this->Player->delete($id, true)){
            // delete from scenarios_skills table:
            $this->PlayersSkill->deleteAll(array('player_id'=>$id));
            // delete from players_scenarios table (player history of completed scenarios):
            $this->PlayersScenario->deleteAll(array('player_id'=>$id));
            return (true);
        } else {
            return (false);
        }
    }

    /**
    * This action displays the profile of a player.
    * It is called via Ajax in the PDA.
    * @access public requires login
    * @param $nick Player nick from the DB
    */
    function view($nick=null, $action='view')
    {
        $this->__requireLogin();
//        $this->__limitAjax($action);
        $nick = (!$nick)? $this->Session->read('Player.nick') : $nick ;
      	$profile = $this->Player->findByNick($nick);
        //if player could not be found: true -> show error in view!:
        $this->set('notFound', empty($profile));
        $this->set('profile', $profile);
        $this->set('action', $action);
        $this->render();
    }

    /**
    * This action registers a new player for the game.
    * @access public
    */
    function register()
    {
        if ($this->PlayerIsLoggedIn) {
            $this->redirect('/');
            exit;
        }
        if (empty($this->data))
        {
            $this->render(); // show the form if no data is to be saved
        } else {
            // check for existing systemaccount of that name:
            if ($this->Systemaccount->findCount(array('Systemaccount.name'=>$this->data['Player']['nick']))!=0){
               $this->Player->invalidate('nick', 'exists');
               $this->Session->setFlash('Please correct the errors below.');
               $this->render();
               exit;
            }
            if ($this->Player->create($this->data) && $this->Player->validates()){
                // if both passwords are not identical:
                //check if all required fields are correct:
                if (strcmp($this->data['Player']['passwd2'], $this->data['Player']['passwd']) != 0){
                    $this->Player->invalidate('passwd', 'match');
                    $this->Session->setFlash('Please correct the errors below.');
                    $this->render();
                    exit;
                }
                // unset the repetition of password for saving
                //debug($this->data); exit;
                unset($this->data['Player']['passwd2']);
                // encrypt password:
                $this->data['Player']['passwd'] = md5($this->data['Player']['passwd']);
                // finally save new player:
                if ($this->Player->save($this->data))
                {
                    $this->Session->setFlash('Thank you. Your registration was successful.');
                    $this->redirect('/login');
                    exit;
                }
            }
        }
    }
    
    /**
    * This function unregisters an account and deletes the player from DB.
    * @access public requires login
    */
    function unregister()
    {
        $this->__requireLogin();

        $player_id = $this->Session->read('Player.id');
        if (!empty($this->data)){
            // only if checkbox is set:
            if ($this->data['Player']['unregisterMe'] && $this->__deletePlayer($player_id)) {
                $this->Session->delete('Player');
                $this->Session->setFlash('Your profile has been deleted!');
                $this->redirect('/');
                exit;
            } else {
                $this->Session->setFlash('Your profile has not been deleted!');
                
            }
        }
        $this->redirect('edit');
        exit;
    }

    /**
    * login to the game with nickname and password
    * @access public
    */
    function login()
    {
        if (!empty($this->data))
        {
            $someone = $this->Player->findByNick($this->data['Player']['nick']);
            $validAccount = (!empty($someone['Player']['passwd']) && $someone['Player']['active'] == 1);
            $correctPasswd = ($someone['Player']['passwd'] == md5($this->data['Player']['passwd']));
            if($validAccount && $correctPasswd)
            {
                $this->Session->write('Player', $someone['Player']);
                $this->Session->write('Player.passwd_clear', $this->data['Player']['passwd']);
                //debug($this->Session->read());
                $this->Session->SetFlash('Welcome '.$this->data['Player']['nick'].'!');
                $this->redirect('/');
                exit;
            } else {
                if ($someone['Player']['active'] == 0){
                    $this->Session->setFlash('Your account is disabled.');
                } else {
                    $this->Session->setFlash('Wrong username / password!');
                }
                $this->redirect('login');
                exit;
            }
        } else {
           $this->render();
        }
    }	
	
    /**
    * logout the current player by deleting the session
    * @access public requires login
    */
    function logout(){
        $this->__requireLogin();        
        
        if ($this->Session->valid()){
        	
		### cleanUpScenario if setupped
		$tmp_PlayerID = $this->Session->read('Player.id');
		$tmp_scenario_id = $this->Scenariosetup->field('scenario_id', array('Scenariosetup.player_id='.$tmp_PlayerID));
			
		if($tmp_scenario_id != null){			
			if ($this->requestAction('/game/evaluateScenario/'.$tmp_scenario_id.'/'.$tmp_PlayerID.'/1')){
				$tmp_eval = true;
			}		
		}
            ### continue "normal" logout
            $this->Session->destroy();
            $this->Session->setFlash('Goodbye!');
            $this->render('login');
        } else {
//             $this->Session->setFlash('OK, not logged in','',null,'ok');
            $this->Session->setFlash('You are not logged in');
//             $this->Session->setFlash('not logged in','',null,'warning');
//             $this->Session->setFlash('error! You are not logged in','',null,'error');
            $this->redirect('/login'); exit;
        }         
    }
    
    /**
    * This action is used to edit the personal information of the logged in player.
    * So far, this is password and the avatar picture URL
    * @access public requires login
    */
    function edit()
    {
        $this->__requireLogin();
        $this->layout = 'pda';
        $player = $this->Player->findById($this->Session->read('Player.id'));
        $this->set('player', $player['Player']);

        if (empty($this->data))
        {
            $this->render(); // show the form if no data is to be saved
        } else {
//             debug($this->Session->read());exit;
//             debug($this->Player->validate);exit;
            unset($this->Player->validate['passwd']); // we don't have to specify a password!
            $this->data['Player']['id'] = $this->Session->read('Player.id');
            if ($this->Player->create($this->data) && $this->Player->validates()){
                // if both passwords are not identical:
                //check if all required fields are correct:
                if (strcmp($this->data['Player']['passwd2'], $this->data['Player']['passwd']) != 0){
                    $this->Player->invalidate('passwd', 'match');
                    $this->render(); return;
                }
                if (strlen(trim($this->data['Player']['passwd']))==0 && strlen(trim($this->data['Player']['passwd2']))==0){
                    // take old password:
                    $this->data['Player']['passwd'] = $this->Session->read('Player.passwd');
                } else {
                    // encrypt new password:
                    $this->data['Player']['passwd'] = md5($this->data['Player']['passwd']);
                }
                // unset the repetition of password for saving
                unset($this->data['Player']['passwd2']);
                // finally save new player:
                if ($this->Player->save($this->data))
                {
                    $this->Session->setFlash('Your profile has been updated.');
                    unset($this->data);
                    $this->redirect('edit/'.$this->Session->read('Player.nick')); exit;
                }
            }
        }


        $this->set('avatar', $this->Session->read('Player.avatar'));
        if (empty($this->data))
        {
            $this->Player->id = $this->Session->read('Player.id'); // get Player id from Session variable to use for DB read below:
            $this->data = $this->Player->read();
        } else {
            if ($this->Player->save($this->data['Player']))
            {
                //debug($this->Session->read('Player'));
                $this->Session->write('Player.avatar', $this->data['Player']['avatar']);
                $this->Session->write('Player.passwd', $this->data['Player']['passwd']);
                //debug($this->Session->read('Player'));exit;
                //$this->Session->setFlash('Your profile has been updated.');
                $this->redirect('/player/'.$this->Session->read('Player.nick'));
                exit;
            }
        }



    }

    /**
    * This function creates a list with all players alphabetically ordered by nick.
    * It updates the left container in the PDA via Ajax.
    * @todo implement pagination in order to order by score or nick
    * @access public
    */
    function listall($orderField='nick')
    {
        if(isset($this->params['requested'])) {
            return ($this->Player->findAll(null,null,$orderField.' ASC'));
        }
    }

    

}
?>
