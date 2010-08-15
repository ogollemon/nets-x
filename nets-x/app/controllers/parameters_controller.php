<?php
/**
 * This controller handles shell script parameters.
 * In order to increase replayability, each script can be parameterized. This way the scenario will use different (randomly chosen) values every time it is played.
 * The values are NOT handled here, only the names of the parameters itself. For the values see Parametervalues controller. 
 * @category   Controller
 * @author     Alice Boit <boit.alice@gmail.com>
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */ 
class ParametersController extends AppController {

    /**
    * Class name
    * @var string
    */
    var $name = 'Parameters';

    /**
    * View helpers
    * @var array
    */
    var $helpers = array('Theme','Html', 'Form','Javascript','Ajax');

    /**
    * used Models
    * @var array
    */
    var $uses = array('Parameter','Parametervalue','Scenario');
    
    /** 
    * edit a specific Parameter with given ID
    * The function is called by clicking the "provide parameters" link in the view.
    * @access public requires author role
    * @param int $valueId the id of the Parameter Value to edit
    */
    function editValue($valueId = null){
     
      	$this->__requireRole(ROLE_AUTHOR);
      	
      	if (empty($this->data)){//show the edit form
      	   $data = $this->Parametervalue->findById($valueId); 
      	   $this->set('data', $data['Parametervalue']);
      		$this->render();
      	} else {//form was submitted
      	   
            $this->Parametervalue->id = $this->data['Parametervalue']['id'];
            if ($this->Parametervalue->save($this->data)){
                $okMessage = 'Parameter value was saved.';
            } else {
                $okMessage = 'Parameter value could not be saved.';
            }
            $this->Session->setFlash($okMessage);
            $scenario_id = $this->data['Parametervalue']['parameter_id'];
            unset($this->data);
            $this->redirect('/'.Configure::read('Routing.admin').'/scenarios/parameters/'.$scenario_id);
            return;
      	}
    }
    
    /**
    * Edit general script parameters for the scenario with given ID
    * @access public requires author role
    * @param $scenario_id the new scenario id from the add scenario form
    */
    function admin_edit(){
        $this->__requireRole(ROLE_AUTHOR);
        if (empty($this->data)){
              $this->redirect('/'.Configure::read('Routing.admin').'/scenarios/');
              exit;
        } else {//form was submitted
           if ($this->Parameter->save($this->data)){
              $okMessage = 'Parameter was saved.';
           } else {
              $okMessage = 'Parameter could not be saved.';
           }
           $scenario_id = $this->data['Parameter']['scenario_id']; 
           unset($this->data);
           $this->Session->setFlash($okMessage);
           $this->redirect('/'.Configure::read('Routing.admin').'/scenarios/parameters/'.$scenario_id);
           exit;
        }
    }

}
?>