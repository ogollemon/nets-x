<?php
/**
 * This controller contains all functions for the administration of game settings.
 * Right now this is only the interface administration.
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class SettingsController extends AppController {

    /**
     * Controller name
     * @var String
     */
	var $name = 'Settings';
	
	/**
	 * Array with Helper names used in the view
	 * @var array
	 */
	var $helpers = array('Html', 'Form');

	/**
     * renders an edit view for interface settings
     * @access public requires tutor rights
     */
    function admin_interfaces(){
       $this->__requireRole(ROLE_TUTOR);
       if (empty($this->data)){
          $this->data = $this->Setting->find('all', array('conditions'=>'id='.MANAGEMENT_INTERFACE.' OR id='.PLAYER_INTERFACE.' OR id='.OPENVPN_INTERFACE));
       } else {
          $this->Setting->set($this->data);
          if (!$this->Setting->save()){
             $this->Session->setFlash('Error: The interface could not be updated');
          } else {
             $this->Session->setFlash('The interface was updated');
          }
          $this->data=null;
          $this->redirect('interfaces');
       }
    }
    
    // This function toggles the DebugMode via GUI
    // !!!  debug>0 collidates with swf (NetConnection.Call.BadVersion)  !!!
    
	function admin_toggledebug(){
		#$this->__requireRole(ROLE_TUTOR);
		//debug('DebugMode: ' .Configure::read('debug'));
		if ($this->Session->check("debuglevel") && $this->Session->read("debuglevel") == 2){
       		$this->Session->write("debuglevel", 0);       		
       	}
       	else{
	    $this->Session->write("debuglevel", 2); 		
		#Configure::write('debug', 2);
       	}		
		$this->redirect('/admin');		
	}

}
?>