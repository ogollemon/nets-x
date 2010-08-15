<?php
/**
 * This controller handles the resource administration for a scenario
 * Sometimes a scenario requires more detailed information about the task or some
 * specific file/image or other resource in order to solve it. This class contains
 * the functions to add/edit/delete these resources and for the player to access the resources (view).
 * Resources may be either related to:
 * 1. the scenario in general
 * 2. a specific parameterset (value-combination also requires a specific resource linked to it)
 * 3. a systemaccount (if playername is not used but randomly chosen systemaccount)
 * @category   Controller
 * @author     Alice Boit <boit.alice@gmail.com>
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class ResourcesController extends AppController {

    /**
     * Class name
     * @var String
     */
	var $name = 'Resources';
	
	/**
	 * Array of used models utilized by this controller
	 * @var array contains the names of models utilized by the controller 
	 */
	var $uses = array(
        'Resource',
		'Parameterset',
		'Systemaccount',
		'ScenariosSystemaccount',
		'Scenario',
    );
    
    /**
     * Array of used helpers utilized by the view
     * @var array contains the names of helpers utilized by the view 
     */
    var $helpers = array('Theme','Javascript', 'Ajax', 'Html');

	/**
	 * This function is called when somebody wants to view a resource file for a scenario.
	 * @access public requires login
	 * @param int $id the id of the reqource file
	 */
	function view($id = null) {
	    $this->__requireLogin();
		if (!$id) {
			$this->flash(__('Invalid Resource', true), array('action'=>'index'));
		}
		$file = $this->Resource->findById($id);
    
        header('Content-type: ' . $file['Resource']['type']);
        header('Content-length: ' . $file['Resource']['size']);
        header('Content-Disposition: attachment; filename="'.$file['Resource']['name'].'"');
        echo $file['Resource']['data'];
        exit;
	}

	/**
    * Provide resources for the scenario in general
    * This function is called from the scenario view admin_resources.ctp
    * @access public requires author role
    * @param int $parameterset_id the parameterset id
    * @param int $scenario_id is the scenario id 
    */
	function editGeneralResources($parameterset_id = null, $scenario_id = null) {
		$this->__requireRole(ROLE_AUTHOR);
		
		//note: branches for submitted data do not exist as this is handled by the editSingleResource() function	
		
		if (empty($this->data) ) {//if a general resource file is to be uploaded
			
            $this->Scenario->recursive = 0;
            $scenario = $this->Scenario->findById($scenario_id);
		    if (!$this->_checkRights($scenario['Scenario']['player_id'])){
               $this->Session->setFlash('You are only allowed to edit your own scenarios.');
               $this->redirect('/authoring');
            }
            $this->set('scenario', $scenario['Scenario']);
            //all general resource files have parameterset_id set to zero
            $generalResources = array();
            $generalResources = $this->Resource->findAllByScenarioId(array('scenario_id' => $scenario_id, 'parameterset_id' => 0));
            //debug($resource);
            $this->set('generalResources', $generalResources);
		}
	}
		
    /**
    * Provide resources for the systemaccount with given ID
    * This function is called from the scenario view admin_resources.ctp
    * @access public requires author role
    * @param int $systemaccount_id the systemaccount id
    * @param int $scenario_id identifies the scenario for redirects
    */	
	function editSystemaccountResources($systemaccount_id = null, $scenario_id = null) {
		$this->__requireRole(ROLE_TUTOR);
		//debug($scenario_id);debug($systemaccount_id); exit;
		//note: branches for submitted data do not exist as this is handled by the editSingleResource() function	
		
		if (empty($this->data) ) {//if a systemaccount resource file is to be uploaded
			
            $this->Scenario->recursive = 0;
            $scenario = $this->Scenario->findById($scenario_id);
		    if (!$this->_checkRights($scenario['Scenario']['player_id'])){
               $this->Session->setFlash('You are only allowed to edit your own scenarios.');
               $this->redirect('/authoring');
            }
            $this->set('scenario', $scenario['Scenario']);
            //get systemaccounts to assign resources to
            $systemaccounts = array();
            $systemaccountResources = array(); //init
            $systemaccountResources = $this->Resource->findAll(array('scenario_id'=>$scenario_id, 'systemaccount_id'=>$systemaccount_id));
	        $this->set('systemaccount_id', $systemaccount_id);	
	        //debug($systemaccountResources);exit;        
	        $this->set('systemaccountResources', $systemaccountResources);
            
		}
	}
	
	/**
    * Provide resources for the parameterset with given ID
    * This function is called from the scenario view admin_resources.ctp
    * @access public requires author role
    * @param $parameterset_id the parameterset id
    * @param $scenario_id identifies the scenario for redirects 
    */
	function editParametersetResources($parameterset_id = null, $scenario_id = null) {
		$this->__requireRole(ROLE_AUTHOR);
	    //note: branches for submitted data do not exist as this is handled by the editSingleResource() function
		if (empty($this->data)  ) {//show upload form
            //get the parameterset chosen by the player 
            $this->Parameterset->recursive = 2;
            $parameterset = $this->Parameterset->findById($parameterset_id);
		    if (!$this->_checkRights($parameterset['Scenario']['player_id'])){
               $this->Session->setFlash('You are only allowed to edit your own scenarios.');
               $this->redirect('/authoring');
            }
            $valuecombinations = array();
            $i = 0;           
            foreach ($parameterset['Parameter'] as $parameter) {  
//            	if(empty($parameter['Parametervalue'])){
//            		$this->Session->setFlash('Error. no parameter values were defined for this parameter set. please choose another one.');    		
//    				$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/resources/'.$parameterset['Scenario']['id']);
//            		exit;
//    			}
    			$rhs = array();
    			$rhs['parameter_name'] = $parameter['name'];
    			$rhs['parameter_values'] = (!empty($parameter['Parametervalue']))? Set::combine($parameter['Parametervalue'], '{n}.sequence_no', '{n}.value') : array() ;
            	$valuecombinations[$i] = $rhs;
            	$i++;
            }
            
            //debug($valuecombinations);
       
            //exit;      

            //read out existing specific resource files
            $parametersetSpecificResources = array();
            $parametersetSpecificResources = $this->Resource->findAllByScenarioId(array('scenario_id' => $scenario_id, 'parameterset_id' => $parameterset_id));
            
            $this->set('parametersetSpecificResources', $parametersetSpecificResources);            
            $this->set('scenario',$parameterset['Scenario']);
            $this->set('parameterset', $valuecombinations);
            $this->set('parametersetName', $parameterset['Parameterset']['name']);
            $this->set('parameterset_id', $parameterset_id);
		}
	}

	/**
	* Save a resource file for a given ID ("new" to add a resource)
	* This function is called when a form from the three edit...Resources() views is submitted.
    * @access public requires author role
    * @param int $id the resource id to save or "new" to add new resource
    */
	function saveSingleResource($id = null) {
		$this->__requireRole(ROLE_AUTHOR);
		$this->layout = false;
		
		if (empty($this->data)) {//data has not been submitted yet, show input form
			$this->Session->setFlash('Invalid function call to saveSingleResource. Return false.');
			$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/resources/'.$scenario_id);
		} else { // data was submitted
			//id is either 'new' or an existing value
		  	if ( is_uploaded_file($this->data['Resource']['File']['tmp_name']) ) {
            	           
	            $fileData = fread(fopen($this->data['Resource']['File']['tmp_name'], "r"),
	                                     $this->data['Resource']['File']['size']);
	            $this->data['Resource']['name'] = $this->data['Resource']['File']['name'];
	            $this->data['Resource']['type'] = $this->data['Resource']['File']['type'];
	            $this->data['Resource']['size'] = $this->data['Resource']['File']['size'];
	            $this->data['Resource']['data'] = $fileData;
	             //read this data from the arguments
	            if($id == 'new'){
					$this->data['Resource']['id'] = 0;
	            } else {
	            	$this->data['Resource']['id'] = $id;	
	            }
	            unset($this->data['Resource']['File']);	            				
				 
			  	if ($this->Resource->create($this->data)) {
					$this->Resource->save();
					$this->Session->setFlash('Resource file has been saved.');					
				} else {//resource was uploaded to tmp but could not be saved
					$this->Session->setFlash('Resource file could not be saved.');
				}			
    		} else {//resource could not be uploaded to tmp
    			$this->Session->setFlash('Resource file could not be uploaded.');
    		}
    		$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/resources/'.$this->data['Resource']['scenario_id']);
			exit;					
		}
		
	}
	
	/**
	 * This action deletes a specific resource file
	 * @access public requires author role
	 * @param int $id the id of the resource to delete
	 * @param int $scenario_id identifies scenario for redirect
	 */
	function delete($id = null, $scenario_id) {
		$this->__requireRole(ROLE_AUTHOR);
	    $this->layout = false;
		//debug($id);exit;
		if (!$id) {
			$this->Session->setFlash('Resource file could not be deleted.');
			$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/resources/'.$this->data['Resource']['scenario_id']);
			exit;					
		}
		$this->Scenario->recursive = 0;
		$scenario = $this->Scenario->findById($scenario_id);
		if (empty($scenario)){
		   $this->Session->setFlash('Resource file could not be deleted.');
           $this->redirect('/'.Configure::read('Routing.admin').'/scenarios');
           exit;
		}
	    if (!$this->_checkRights($scenario['Scenario']['player_id'])){
           $this->Session->setFlash('You are only allowed to edit your own scenarios.');
           $this->redirect('/authoring');
           exit;
        }
		if ($this->Resource->del($id)) {
			$this->Session->setFlash('Resource file was deleted.');
			
		}
		$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/resources/'. $scenario_id);
		exit;
	}

    /**
     * This function checks if an author is allowed to administer this resource (tutors always are). 
     * @access protected
     * @param int $player_id identifies the player who made the scenario
     * @return boolean true if allowed, false if not
     */
    function _checkRights($player_id){
       return ($this->Session->read('Player.id')==$player_id || $this->Session->read('Player.role') >= ROLE_TUTOR);
    }
	
}
?>