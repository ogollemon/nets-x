<?php
/**
 * This controller handles the shell scripts.
 * It contains the administration functions for tutors and authors
 * @category   Controllers
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @author     Alice Boit <boit.alice@gmail.com>
 * @copyright  2007 the NETS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class ScriptsController extends AppController {
    
   /**
    * Class name
    * @var string
    */
    var $name = 'Scripts';

   /**
    * View helpers
    * @var array
    */
    var $helpers = array('Theme','Html', 'Form','Javascript','Ajax');

   /**
    * used Models
    * @var array
    */
   var $uses = array('Scenario', 'Script', 'Scripttype', 'Parameter', 'Parametervalue', 'Host');

    /**
     * This function checks if an author is allowed to administer this script (tutors always are). 
     * @access protected
     * @param int $player_id identifies the player who made the scenario
     * @return boolean true if allowed, false if not
     */
    function _checkRights($player_id){
       return ($this->Session->read('Player.id')==$player_id || $this->Session->read('Player.role') >= ROLE_TUTOR);
    }
   
   /**
    * This function renders the edit view to add a new shell script 
    * @access public requires author rights
    * @param int $scenario_id identifies the scenario the new script belongs to
    * @param int $scripttype_id as defined in /app/config/scripttypes.php
    */
   function admin_add($scenario_id, $scripttype_id=null){
      $this->__requireRole(ROLE_AUTHOR);
      if (empty($this->data)){
         $scripttypes = $this->Scripttype->find('list');
         $validType = false; // scripttype MUST be provided and valid!
         foreach($scripttypes as $key=>$type){
            if ($key == $scripttype_id){
               $validType = true; break;
            }
         }
         if (!$validType){
            $this->Session->setFlash('Non-valid scripttype provided.');
            $this->redirect($admin.'/scenarios/');
            exit;
         }
         $this->Scenario->recursive = 0;
         $this->data = $this->Scenario->read(null,$scenario_id);
         if (empty($this->data)){
            $this->Session->setFlash('unknown Scenario');
            $this->redirect('/authoring');
            exit;
         }
         if (!$this->_checkRights($this->data['Scenario']['player_id'])){
            $this->Session->setFlash('You are only allowed to edit your own scenarios.');
            $this->redirect('/authoring');
            exit;
         }
         //temporaeres Array fuer den ShellScript header
//         debug($this->Scenario);
//         die();
         $scriptarray['scriptname'] = $this->data['Scenario']['name'];
         $scriptarray['playername'] = $this->Session->read('Player.nick');
        // $scriptarray['scripttype'] = $this->data['Scenario']['evaluationtype_id'];
         $newScript = $this->Script->createDefault($scriptarray); //see Model 'Script' for this custom function        
         $this->data['Script'] = $newScript['Script'];
         $this->data['Script']['scripttype_id'] = $scripttype_id;
         $this->data['Script']['sequence_no'] =
            $this->Script->findCount('Script.scenario_id='.$scenario_id.' AND Script.scripttype_id='.$scripttype_id)+1;
         $this->set('scripttype_name', $scripttypes[$scripttype_id]);
   //            debug($this->data);exit;
         $this->set('add', true);
         $folder = new Folder;
         $folder->cd(PACKAGES);
         $packages = $folder->ls(true,true); // $folder[1] are the files
         $packages = (sizeof($packages[1])>0)? Set::combine($packages[1],'{n}', '{n}') : array();
         $packages = am(array(''=>'-- no package --'),$packages);
         $this->set('packages', $packages);
         $this->set('hosts', $this->Host->find('list'));
         $this->render('admin_edit'); // render the admin_edit-mask!
         exit;
      } else {
         $this->redirect('index');
         exit;
      }
               
   }
   
   /**
    * Shows the edit mask for the scenario shell scripts
    * @access public (but Author role required)
    * @param $script_id is new only when called via the "new" button in the form
    * @param $scenario_id the scenario id the script belongs to
    */
   function admin_edit($script_id=null){//scenario id must be set by now
      
         	
      $this->__requireRole(ROLE_AUTHOR);
      $admin = '/'.Configure::read('Routing.admin');
      if (empty($this->data)){
         $script = $this->Script->read(null,$script_id);
         if (empty($script)){
            $this->Session->setFlash('Script with id '.$script_id.' does not exist.');
            $this->redirect($admin.'/scenarios/');
            exit;
         }
         if (!$this->_checkRights($script['Scenario']['player_id'])){
            $this->Session->setFlash('You are only allowed to edit your own scenarios.');
            $this->redirect('/authoring');
            exit;
         }
 		 // expand one line to multiple lines for readability:
         $script['Script']['script'] = str_replace('\n', chr(13).chr(10) , $script['Script']['script']);
  		 $scripttype_name = $this->Scripttype->findById($script['Script']['scripttype_id']);
 	 	 $this->set('scripttype_name', $scripttype_name['Scripttype']['name']);
         $this->set('hosts', $this->Host->find('list'));
         $folder = new Folder;
         $folder->cd(PACKAGES);
         $packages = $folder->ls(true,true); // $folder[1] are the files
         $packages = (sizeof($packages[1])>0)? Set::combine($packages[1],'{n}', '{n}') : array();
         $packages = am(array(''=>'-- no package --'),$packages);
         $this->set('packages', $packages);
         $this->data = $script;
//        debug($this->data);exit;
         $this->render();

      } else { // form data was submitted -------------------------------

//         debug($this->data);exit;
         // make a one-liner out of the script:
         $this->data['Script']['script'] = str_replace(chr(13).chr(10) , '\n', $this->data['Script']['script']);
         $this->data['Script']['player_id'] = $this->Session->read('Player.id');
		 $scenario_id = $this->data['Script']['scenario_id'];
		 $scripttype_id = $this->data['Script']['scripttype_id'];
		 
         if( empty($this->data['Host']['Host']) ){//do not save if there is no host assigned to this script.
         	$this->Session->setFlash('Please define a host for this script!');
         	//debug($this->data);exit;
         	$this->redirect($admin.'/scripts/add/' . $scenario_id . '/' . $scripttype_id);
         	exit;
		 }
		 
         if (!$this->Script->save($this->data, false)){
            $this->Session->setFlash('There was an error saving the script.');
         } else {
            $this->Session->setFlash('The script has been saved successfully.');
         }
         
         unset($this->data);
         $this->redirect($admin.'/scenarios/scripts/'.$scenario_id);
         exit;
      }

   }
   
   /**
    * This function removes a script from the DB.
    * @access public requires author rights
    * @param int $id identifies the script to delete 
    */
   function admin_delete($id = null) {
      $this->__requireRole(ROLE_AUTHOR);
      $script = $this->Script->findById($id);
      if (empty($script)) {
         $this->Session->setFlash('script to delete not found');
         $this->redirect('/'.Configure::read('Routing.admin').'index');
         exit;
      }
      if (!$this->_checkRights($script['Scenario']['player_id'])){
         $this->Session->setFlash('You are only allowed to edit your own scenarios.');
         $this->redirect('/authoring');
         exit;
      }
      if ($this->Script->del($id)) {
         $this->Session->setFlash('Script has been deleted.');
      } else {
         $this->Session->setFlash('Error deleting the script.');
      }
      $this->redirect('/'.Configure::read('Routing.admin').'/scenarios/scripts/'.$script['Scenario']['id']);
      exit;
   }

}

?>