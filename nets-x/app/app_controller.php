<?php
/**
 * This controller is the basis for all other controllers.
 * All other controllers extend this class. 
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class AppController extends Controller {

    /**
    * int; boolean state variable if the player is logged in, this is set to true
    * @var int
    */
    var $PlayerIsLoggedIn;

    /**
    * String; sets the layout ctp file in /app/views/layouts
    * @var String
    */
    var $layout = 'default';
    
    /**
     * include Javascript and Ajax by default, otherwise there will be errors because mainmenu element uses Ajax...
     *
     * @var array
     */
    var $helpers = array('Html', 'Form', 'Javascript', 'Ajax');

    /**
     * This function sets the PlayerIsLoggedIn variable every time a controller is executed.
     * Also, the debug level is always set to 0 for players and authors.
     * If debugging is >0, only the tutors can see this!
     * @access public
     */
    function beforeFilter()
    {
        $this->PlayerIsLoggedIn = ($this->Session->check('Player'))? true : false;
        
        if (!$this->Session->check('Player') || Configure::read('debug') > 0 && $this->Session->read('Player.role') < ROLE_TUTOR){
           Configure::write('debug', 0);
        }
    	if ($this->Session->check("debuglevel") && $this->Session->read("debuglevel") == 2){
       		Configure::write('debug', 2);       		
       	}
	    else{
       		Configure::write('debug', 0);			
       	}  
       	// Your permanent Dev-change here 
       	// !!!  debug>0 collidates with swf (NetConnection.Call.BadVersion)  !!!
       	//Configure::write('debug', 2);
       	//debug('DebugMode: ' .Configure::read('debug'));        	
    }

    /**
     * This function checks the Session if a player is logged in.
     * if not, redirect to login form
     * @access private
     */
    function __requireLogin(){
        if(!$this->PlayerIsLoggedIn)
        {
            $this->Session->setFlash('You are not logged in');
            $this->redirect('/login'); return;
        }
    }

    /**
     * This function checks the Session for the specified role.
     * If role is smaller than defined by $role, the player is redirected
     * with an error message.
     * @param int $role 
     */
    function __requireRole($role=ROLE_PLAYER){
      	if (!$this->PlayerIsLoggedIn || $this->Session->read('Player.role')<$role){
      	    $this->Session->setFlash('You are not logged in or do not have sufficient rights');
            $this->redirect('/login'); exit;
      	}
    }

}
?>
