<?php
/**
* This controller handles all operations concerning a scenario.
* adding, deleting, editing, administration...
* @category   Controller
* @author     Philipp Daniel <phlipmode23@gmail.com>
* @author     Thomas Geimer <thomas.geimer@googlemail.com>
* @author     Alice Boit <boit.alice@gmail.com>
* @copyright  2008 the NetS-X team
* @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
* @version    Release: 1.0
* @since      Class available since Release 0.1 (alpha)
*/
class ScenariosController extends AppController
{

    /**
    * Class name
    * @var string
    */
    var $name = 'Scenarios';
    
    /**
    * used Models
    * @var array
    */
    var $uses = array(
        'Attachment',
        'Resource',
        'Scenario',
        'Scenariosetup',
        'Player',
        'Parameter',
        'Parameterset',
        'Parametervalue',
        'PlayersSkill',
        'Evaluationtype',
        'Topic',
    	'Script',
        'Skill',
        'Exam',
        'PlayersScenario',
        'Systemaccount',
    );
    
    /**
    * View helpers
    * @var array
    */
    var $helpers = array('Theme','Javascript', 'Ajax', 'Html');

    /**
     * This function checks if an author is allowed to administer this scenario (tutors always are). 
     * @access protected
     * @param int $player_id identifies the player who made the scenario
     * @return boolean true if allowed, false if not
     */
    function _checkRights($player_id){
       return ($this->Session->read('Player.id')==$player_id || $this->Session->read('Player.role') >= ROLE_TUTOR);
    }
    
    /**
    * default action, lists all scenarios the logged in player can set up with his skills.
    * @access public requires login
    */
    function index()
    {
        $this->__requireLogin();

        $data = $this->Scenario->findAll('approved>0', null, 'name ASC');
        $data = (!empty($data))? $data : array() ;
        $playerSkills = $this->Player->read(null, $this->Session->read('Player.id'));
        $playerSkills = (!empty($playerSkills['Skill']))? Set::combine($playerSkills['Skill'], '{n}.id', '{n}.name') : array();
        $allowed = array(); //push all scenarios here, for which the player has the required skills!
        foreach ($data as $scenario) {
            $requirements = (!empty($scenario['Skill']))? Set::combine($scenario['Skill'], '{n}.id', '{n}.name'): array();
            $ok = true;
        	foreach ($requirements as $id=>$name) {
        	   if(!isset($playerSkills[$id])){
        	      $ok = false;
        	      break;
        	   }
        	}
        	if ($ok){
        	   array_push($allowed, $scenario['Scenario']);
        	}
        }
        $this->set('scenarios', $allowed);
        $this->render();
    }
	
    /**
    * show a list of admin options to add/edit/delete scenarios 
    * @access public requires author role
    */
    function admin_index(){
        $this->__requireRole(ROLE_AUTHOR);
      
        if (empty($this->data)){
            $topics = $this->Topic->findAll('',array('id','name'),null,null,null,1);
            $this->set('data', $topics);
        } else {
            debug($this->data);exit;
        }
    }

    /**
    * add a new scenario to the database or edit an existing one
    * If $scenario_id=='new' a new one will be generated.
    * @access public requires author rights
    * @param $scenario_id identifies the scenario
    * @param $validationMsg message from this controller or the 
    */
    function admin_edit($scenario_id = 'new', $validationMsg = ''){
        
    	
//         	debug($this->data);
//         	die();
    	$this->__requireRole(ROLE_AUTHOR);
        $admin = '/'.Configure::read('Routing.admin');

		if ($scenario_id == 'new'){
			$this->redirect('basics/new');exit;
		}

        $scenario = $this->Scenario->findById($scenario_id);
        if (empty($scenario)){
        	$this->Session->setFlash('Scenario with ID ' . $scenario_id . ' not found in DB');
        	$this->redirect('index');exit;
        }
        if (!$this->_checkRights($scenario['Scenario']['player_id'])){
           $this->Session->setFlash('You are only allowed to edit your own scenarios.');
           $this->redirect('/authoring');
        }
        $complete = $scenario['Scenario']['complete'];
        //debug($complete & ( SCENARIO_BASICS + SCENARIO_REQUIREMENTS) );exit;
        
        $completed = array(
        	'basics'=>array(
				'complete'=>$complete & SCENARIO_BASICS,
				'url'=>$admin.'/scenarios/basics/'.$scenario_id,
                'allowed'=>true
			),
        	'requirements'=>array(
				'complete'=>$complete & SCENARIO_REQUIREMENTS,
				'url'=>$admin.'/scenarios/requirements/'.$scenario_id,
                'allowed'=>true
			),
        	'scripts'=>array(
				'complete'=>$complete & SCENARIO_SCRIPTS,
				'url'=>$admin.'/scenarios/scripts/'.$scenario_id,
                'allowed'=>true
			),
        	'parameters'=>array(
				'complete'=>$complete & SCENARIO_PARAMETERS,
				'url'=>$admin.'/scenarios/parameters/'.$scenario_id,
                'allowed'=>($complete & SCENARIO_SCRIPTS)
			),
			'parametersets'=>array(
                'complete'=>$complete & SCENARIO_PARAMETERSETS,
                'url'=>$admin.'/scenarios/parametersets/'.$scenario_id,
			    'allowed'=>($complete & SCENARIO_PARAMETERS)
            ),
            'parametervalues'=>array(
                'complete'=>$complete & SCENARIO_PARAMETERVALUES,
                'url'=>$admin.'/scenarios/parametervalues/'.$scenario_id,
                'allowed'=>($complete & SCENARIO_PARAMETERSETS)
            ),
			'resources'=>array(
                'complete'=>$complete & SCENARIO_RESOURCES,
                'url'=>$admin.'/scenarios/resources/'.$scenario_id,
                'allowed'=>($complete & SCENARIO_PARAMETERVALUES)
            )
        );
        $this->set('scenario', $scenario['Scenario']);
        $this->set('completed', $completed);
        $this->set('validationMsg', $validationMsg);
        $this->set('complete', SCENARIO_BASICS + SCENARIO_REQUIREMENTS + SCENARIO_SCRIPTS + SCENARIO_PARAMETERS + SCENARIO_PARAMETERSETS + SCENARIO_PARAMETERVALUES + SCENARIO_RESOURCES);
    }

    /**
    * this function handles the editing of basic settings of a scenario.
    * It is also called when a new scenario is added (with parameter "new").
    * @access public requires author rights
    * @param int $scenario_id identifies the scenario or 'new' to add one
    */
	function admin_basics($scenario_id = 'new'){
		$this->__requireRole(ROLE_AUTHOR);
        $headline = ($scenario_id == 'new')?'Add a new scenario':'Edit scenario';
        $this->set('scenario_id',$scenario_id);
        if (empty($this->data)){ //no Form data
            if($scenario_id == 'new'){ //add a new scenario
                // create default Scenario:
                $scenario = $this->Scenario->createDefault();
            } else {
                // remove all model associations except Systemuser 
                 $this->Scenario->unbindModel(
                    array(
                        'hasMany'=>array('Attachment', 'Parameter', 'Parameterset', 'Script'),
                        'hasAndBelongsToMany' => array('Skill')
                    )
                 );
                $scenario = $this->Scenario->findById($scenario_id);
                if (empty($scenario)){
                    $this->Session->setFlash('Scenario was not found');
                    $this->redirect('scenarios');exit;
                }
                if (!$this->_checkRights($scenario['Scenario']['player_id'])){
                   $this->Session->setFlash('You are only allowed to edit your own scenarios.');
                   $this->redirect('/authoring');
                }
                //debug($scen['Scenario']);exit;
            }
            $this->set('headline', $headline);
            $this->set('systemaccounts', $this->Systemaccount->find('list'));
            $this->set('topics', $this->Topic->find('list'));
            $this->set('evaluationtypes', $this->Evaluationtype->find('list'));
            $this->data = $scenario;
            $this->render();
            
        } else { // form data has been submitted
           
//           debug($this->data);exit;
            // if player has been chosen as systemaccount, set it to 0 so that it can be saved to the model:
            if ($this->data['Scenario']['use_player']==1 ){
               $this->data['Systemaccount']['Systemaccount'] = array();
            }
            else{//choose at least one systemaccount representation
            	if( empty($this->data['Systemaccount']['Systemaccount']) ){
             		$this->Session->setFlash('Please choose at least one system account to choose from.');
					$this->redirect('basics/'.$scenario_id);exit;
             	}
            }
//            debug($this->data);exit;
           
            $validationRetMsg = $this->_validateCompletionStatus($scenario_id, SCENARIO_BASICS);
			
        	$newStatus = ($this->data['Scenario']['complete'] & SCENARIO_BASICS)? 0: SCENARIO_BASICS; // add new status
        	$this->data['Scenario']['complete'] += $newStatus; // general info complete
        	$this->data['Scenario']['player_id'] = $this->Session->read('Player.id');
			if ($validationRetMsg['completion_status'] == COMPLETION_STATUS_OK && $this->Scenario->set($this->data) && $this->Scenario->validates()){
//			    $this->Scenario->recursive = 0;
				if (!$this->Scenario->save($this->data)){ // scenario validates but cannot be saved
					$this->Session->setFlash('Error: The scenario could not be saved.');
					$this->redirect('edit/'.$scenario_id);exit;
				} else {
					if ($scenario_id=='new'){
						$okMessage = 'The new scenario has been added.';
						$new_id = $this->Scenario->getInsertID();
					} else {
						$okMessage = 'The scenario has been saved.';
						$new_id = $scenario_id;
					}
					$this->Session->setFlash($okMessage);
					unset($this->data);
           			$this->redirect('edit/'.$new_id); exit;
				}
			} else { // Error - form needs to be rendered again:
				$this->Session->setFlash('Some values were not correct. Please check the form again.');
				$this->set('headline', $headline);
				$this->set('selected_topic_index', $this->data['Scenario']['topic_id']);
	        	$this->set('selected_evaluationtype_index', $this->data['Scenario']['evaluationtype_id']);
				$this->set('topics', $this->Topic->find('list'));
                $this->set('evaluationtypes', $this->Evaluationtype->find('list'));
	            $this->set('scenario', $this->data['Scenario']);
	            
	            if($validationRetMsg['completion_status'] == COMPLETION_STATUS_ERROR)
	           		$this->Session->setFlash('Warning: some scripts are not properly written.<br /> ' . $validationRetMsg['msg_string']);	 
	            
	            $this->render();
	    		exit;
			}
        }
	}
		
	/**
    * With this function authors can administer the required skills for their scenario.
    * @access public requires author rights
    * @param int $scenario_id the scenario id
    */
    function admin_requirements($scenario_id = null){
    	$this->__requireRole(ROLE_AUTHOR);
    	// remove all model associations except Systemuser 
        $this->Scenario->unbindModel(
           array(
               'hasMany'=>array('Attachment', 'Parameter', 'Parameterset', 'Script'),
               'hasAndBelongsToMany' => array('Systemaccount')
           )
        );
    	$scenario = $this->Scenario->findById($scenario_id);
        if (empty($scenario)){
             $this->Session->setFlash('Scenario was not found');
             $this->redirect('index');exit;
        }
        if (!$this->_checkRights($scenario['Scenario']['player_id'])){
           $this->Session->setFlash('You are only allowed to edit your own scenarios.');
           $this->redirect('/authoring');
        }
    	if (empty($this->data)){
    		// get all skills and make a formatted array for view with required=0
    		$all_skills = $this->Skill->findAll(null,null,'name ASC');
    		$skills = array();
    		foreach($all_skills as $i=>$skill){
				$skill['Skill']['required'] = 0;
    			$skills['skill_'.$skill['Skill']['id']] = $skill['Skill'];
    		}
    		// find all current requirements and add them to the formatted skills array:
    		foreach($scenario['Skill'] as $requirement){
				$skills['skill_'. $requirement['id'] ]['required'] = 1;
    		}
    		// create array with first letters!
    		$formatted = array();
    		$letters = array();
			foreach($skills as $skill){
				$letter = substr(up($skill['name']), 0, 1);
				$letters[$letter] = $letter;
				if (!empty($formatted[$letter])){
					array_push($formatted[$letter], $skill);
				} else {
					$formatted[$letter] = array($skill);
				}
			}
            $this->data = $scenario;
            $this->set('skills', $formatted);
            $this->set('letters', $letters);
    		$this->render();
    		
    	} else { // form data was submitted:
    	   
    	   
    	   $requirements = array();
    	   foreach ($this->data['requirement'] as $key=>$skill) {
    	   	   if ($skill==1){
    	   	       array_push($requirements, $key);
    	   	   }
    	   }
    	   unset($this->data['requirement']);
    	   $this->data['Skill']['Skill'] = $requirements;
    	   $newStatus = ($scenario['Scenario']['complete'] & SCENARIO_REQUIREMENTS)? $scenario['Scenario']['complete'] : $scenario['Scenario']['complete']+SCENARIO_REQUIREMENTS; // add new status
    	   $this->data['Scenario']['complete'] = $newStatus;
    	   $this->Scenario->id = $scenario_id;
    		if ($this->Scenario->save($this->data, false)) { //validation false or it won't save!
				$okMessage = 'Requirements have been saved.';
    		} else {
    			$okMessage = 'ERROR: Requirements could not be saved.';
    		}
    		$this->Session->setFlash($okMessage);
    		unset($this->data);
       		$this->redirect('edit/'.$scenario_id); exit;
    	}
    }
	
    /**
    * Renders an overview of all shell scripts for the scenario with given ID.
    * @access public requires author role
    * @param int the new scenario id from the add/edit scenario form
    */
    function admin_scripts($scenario_id){
    	$this->__requireRole(ROLE_AUTHOR);
    	// remove all model associations except Systemuser 
        $this->Scenario->unbindModel(
           array(
               'hasMany'=>array('Attachment', 'Parameter', 'Parameterset'),
               'hasAndBelongsToMany' => array('Systemaccount','Skill')
           )
        );
        
        $scenario = $this->Scenario->read(null,$scenario_id);
     	if ( !$scenario )  {
           	$this->Session->setFlash('Scenario was not found.');
           	$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/');
           	exit;
        }
        if (!$this->_checkRights($scenario['Scenario']['player_id'])){
           $this->Session->setFlash('You are only allowed to edit your own scenarios.');
           $this->redirect('/authoring');
        }
        if (empty($this->data)){
        	$this->data = $scenario;
        } else {//data was submitted
        	//debug($this->data);exit;
	        if ($this->data['Scenario']['complete']==SCENARIO_SCRIPTS){ 
		    		           
	             	$validationRetMsg = $this->_validateCompletionStatus($scenario_id, SCENARIO_SCRIPTS);
			  		if( $validationRetMsg['completion_status'] == COMPLETION_STATUS_OK ){	  	           	 
		              	$newStatus = ($scenario['Scenario']['complete'] & SCENARIO_SCRIPTS)? $scenario['Scenario']['complete'] : $scenario['Scenario']['complete']+SCENARIO_SCRIPTS; // add new status
		              	$this->Scenario->id = $scenario['Scenario']['id'];
		              	$this->Scenario->saveField('complete', $newStatus);
		              	$this->Session->setFlash('Scripts are complete');
		              	$this->redirect('edit/'.$scenario['Scenario']['id']);
		              	exit;
			  		}
	              	else{
			  	    	$this->Session->setFlash('Warning: some scripts are not properly written.<br /> ' . $validationRetMsg['msg_string']);	 
			  	    	$this->redirect('edit/'.$scenario['Scenario']['id'] . '/' . $validationRetMsg['msg_string']);
	               	 	exit;
			  		}	           	
	        	}
        	    $this->render();
        }
    }
    
    /**
    * Provide shell script parameters for the scenario with given ID.
    * A highly parameterized shell script greatly improves playability.
    * @access public requires author role
    * @param $scenario_id the scenario id
    */
    function admin_parameters($scenario_id = null){
    	
        $this->__requireRole(ROLE_AUTHOR);
        if (!$scenario_id){
           $this->redirect('index');
           exit;
        }
        // remove all model associations except Systemuser 
        $this->Scenario->unbindModel(
           array(
               'hasMany'=>array('Attachment', 'Parameterset'),
               'hasAndBelongsToMany' => array('Systemaccount','Skill')
           )
        );
        $this->Scenario->recursive = 2;
        $scenario = $this->Scenario->findById($scenario_id);
        if (empty($this->data)){
           if (!empty($scenario)){
               if (!$this->_checkRights($scenario['Scenario']['player_id'])){
                  $this->Session->setFlash('You are only allowed to edit your own scenarios.');
                  $this->redirect('/authoring');
               }
               $this->set('scenario',$scenario);
               $this->set('data', $scenario['Parameter']);
               $this->render();
           } else {
               $this->Session->setFlash('Scenario was not found.');
               $this->redirect('edit/'.$scenario_id);
               exit;
           }
           
        } else { // Form data was submitted: user says that parameters are completely defined
           
           if ($this->data['Scenario']['complete']==SCENARIO_PARAMETERS){
           	  $validationRetMsg = $this->_validateCompletionStatus($scenario_id, SCENARIO_PARAMETERS);
			  
           	  if( $validationRetMsg['completion_status'] == COMPLETION_STATUS_OK ){	           	    
	              $newStatus = ($scenario['Scenario']['complete'] & SCENARIO_PARAMETERS)? $scenario['Scenario']['complete'] : $scenario['Scenario']['complete']+SCENARIO_PARAMETERS; // add new status
	              $this->Scenario->id = $scenario['Scenario']['id'];
	              $this->Scenario->saveField('complete', $newStatus);
	              $this->Session->setFlash('Script parameters are complete');
	              $this->redirect('edit/'.$scenario['Scenario']['id']);
	              exit;
           	  } else {
           	  	  $this->Session->setFlash('Warning: script parameters are not complete.<br /> ' . $validationRetMsg['msg_string']);           	  	 
	              $this->redirect('edit/'.$scenario['Scenario']['id']);
	              exit;
           	  }
           }
        }
    }
    
    /**
     * Combine logically linked parameters to parametersets.
     * Only if all parameters are assigned a set (may be also only one parameter in one set), you can proceed. 
     * @access public requires author role 
     * @param int $scenario_id identifies the scenario to edit parametersets for 
     */
    function admin_parametersets($scenario_id){
       $this->__requireRole(ROLE_AUTHOR);
       if (!$scenario_id){
           $this->redirect('index');
           exit;
        }
        // remove all model associations except Parameter: 
        $this->Scenario->unbindModel(
           array(
               'hasMany'=>array('Attachment', 'Script'),
               'hasAndBelongsToMany' => array('Systemaccount','Skill')
           )
        );
        $this->Scenario->recursive = 2;
        $scenario = $this->Scenario->findById($scenario_id);
        if (empty($this->data)){
           if (!empty($scenario)){
               if (!$this->_checkRights($scenario['Scenario']['player_id'])){
                  $this->Session->setFlash('You are only allowed to edit your own scenarios.');
                  $this->redirect('/authoring');
               }
               $scenario['Parameter'] = (!empty($scenario['Parameter']))? Set::combine($scenario['Parameter'], '{n}.id', '{n}') : array();
               $this->data = $scenario;
               $this->Parameter->recursive = 0;
               $unassigned = $this->Parameter->findAll('scenario_id='.$scenario_id.' AND parameterset_id=0');
               if (is_array($unassigned) && sizeof($unassigned)>0){
                    $unassigned = Set::combine($unassigned, '{n}.Parameter.id', '{n}.Parameter.name');
               } else {
                    $unassigned = array();
               }
               $this->set('unassigned', $unassigned);
               $this->render();
           } else {
               $this->Session->setFlash('Scenario was not found.');
               $this->redirect('index');
               exit;
           }
           
        } else { // Form data was submitted: user says that parameters are completely defined
                   
           if ($this->data['Scenario']['complete']==SCENARIO_PARAMETERSETS){
           	  $validationRetMsg = $this->_validateCompletionStatus($scenario_id, SCENARIO_PARAMETERSETS);
			  if( $validationRetMsg['completion_status'] == COMPLETION_STATUS_OK ){	   
	              $newStatus = ($scenario['Scenario']['complete'] & SCENARIO_PARAMETERSETS)? $scenario['Scenario']['complete'] : $scenario['Scenario']['complete']+SCENARIO_PARAMETERSETS; // add new status
	              $this->Scenario->id = $scenario['Scenario']['id'];
	              $this->Scenario->saveField('complete', $newStatus);
	              $this->Session->setFlash('Parametersets are complete');
	              $this->redirect('edit/'.$scenario['Scenario']['id']);
	              exit;
			  }
			  else{
			  	  $this->Session->setFlash('Warning: script parameters are not complete.<br /> ' . $validationRetMsg['msg_string']);			  	
	              $this->redirect('edit/'.$scenario['Scenario']['id'] . '/' . $validationRetMsg['msg_string']);
	              exit;
			  }
           }
        }
    }
    
 	/**
    * Provide parameter values for the scenario with given ID
    * @access public requires author role
    * @param int $scenario_id the scenario id to provide the parametervalues for
    */
    function admin_parametervalues($scenario_id = null){
    	
     if (!$scenario_id){
           $this->redirect('index');
           exit;
        }
        $this->__requireRole(ROLE_AUTHOR);
        // remove all model associations except Systemuser 
        $this->Scenario->unbindModel(
           array(
               'hasMany'=>array('Attachment'),
               'hasAndBelongsToMany' => array('Systemaccount','Skill')
           )
        );
        
        $this->Scenario->recursive = 2;
        $scenario = $this->Scenario->findById($scenario_id);
        if (!$this->_checkRights($scenario['Scenario']['player_id'])){
           $this->Session->setFlash('You are only allowed to edit your own scenarios.');
           $this->redirect('/authoring');
        }
        $this->Parameterset->recursive = 2;
        $parametersets = $this->Parameterset->find('all', array('fields'=>array('id','name'), 'conditions'=>array('scenario_id'=>$scenario_id)));
//        debug($parametersets);exit;
        
        if (empty($this->data)){
           if (!empty($scenario)){
               
           	   $this->set('scenario', $scenario);         
               $this->set('parametersetsArray', $parametersets);
               $this->render();
           } else {
               $this->Session->setFlash('Scenario was not found.');
               $this->redirect('edit/'.$scenario_id);
               exit;
           }
           
        } else { // Form data was submitted and parametervalues are completely defined
           if ($this->data['Scenario']['complete']==SCENARIO_PARAMETERVALUES){
           	  $validationRetMsg = $this->_validateCompletionStatus($scenario_id, SCENARIO_PARAMETERVALUES);
			  if( $validationRetMsg['completion_status'] == COMPLETION_STATUS_OK ){	  	           	 
	              $newStatus = ($scenario['Scenario']['complete'] & SCENARIO_PARAMETERVALUES)? $scenario['Scenario']['complete'] : $scenario['Scenario']['complete']+SCENARIO_PARAMETERVALUES; // add new status
	              $this->Scenario->id = $scenario['Scenario']['id'];
	              $this->Scenario->saveField('complete', $newStatus);
	              $this->Session->setFlash('Parametervalues are complete');
	              $this->redirect('edit/'.$scenario['Scenario']['id']);
	              exit;
			  }
              else{
			  	  $this->Session->setFlash('Warning: script parameter values are not complete.<br /> ' . $validationRetMsg['msg_string']);				  			  	
			  	  $this->redirect('edit/'.$scenario['Scenario']['id']);
	              exit;
			  }
           }
        }      	
    }
    
    /**
    * Provide resource files for the scenario with given ID.
    * @access public requires author rights
    * @param int $scenario_id the scenario id to provide the resources for
    */
    function admin_resources($scenario_id = null){
        $this->__requireRole(ROLE_AUTHOR);
        $scenario = $this->Scenario->findById($scenario_id,array('name', 'topic_id', 'complete', 'player_id'));
        if (!$this->_checkRights($scenario['Scenario']['player_id'])){
           $this->Session->setFlash('You are only allowed to edit your own scenarios.');
           $this->redirect('/authoring');
        }
        if (empty($this->data)){
        	//debug($this->data);
           if (!empty($scenario)){
               //$this->set('isFileLoader',true);//include the file loader javascripts	        
	           $this->set('scenario',$scenario);
	           
	           //get the parameter set associated with this scenario
	           //TODO: there must be an easier way to find this with a conditional list cmd
	           if ($this->Parameterset->findByScenarioId($scenario_id)){
	          	 $parametersets = $this->Parameterset->find('list');
	          	 //debug($parametersets);
	          	 foreach($parametersets as $key=>$parameterset){
	          	 	$parametersetTmp = $this->Parameterset->findById($key);
	          	 	if ($parametersetTmp['Parameterset']['scenario_id'] != $scenario_id){
	          	 		unset($parametersets[$key]);	
	          	 	}
	          	 }
	          	 //debug($parametersets);exit;
	           	 $this->set('parametersets', $parametersets);
	           }
	           else{//else pass an empty array
	           	 $this->set('parametersets', array());
	           }
	           
	           $parametervalues = $this->Parametervalue->createDefault();
	           $this->set('parametervalues', $parametervalues);
	           
	           //get systemaccounts to assign resources to
	           //$systemaccounts = $this->Systemaccount->find('list');
	           $systemaccounts = (!empty($scenario['Systemaccount']))? Set::combine($scenario['Systemaccount'], '{n}.id', '{n}.name') : array();
	           //debug($systemaccounts);exit;
	           $this->set('systemaccounts', $systemaccounts);
	           $this->render();
            } else {
               $this->Session->setFlash('Scenario was not found.');
               $this->redirect('edit/'.$scenario_id);
               exit;
           }
           
        } else {//form was submitted and all resources uploaded
           
	    	if ($this->data['Scenario']['complete']==SCENARIO_RESOURCES){ 
	    		           
             	$validationRetMsg = $this->_validateCompletionStatus($scenario_id, SCENARIO_RESOURCES);
		  		if( $validationRetMsg['completion_status'] == COMPLETION_STATUS_OK ){	  	           	 
	              	$newStatus = ($scenario['Scenario']['complete'] & SCENARIO_RESOURCES)? $scenario['Scenario']['complete'] : $scenario['Scenario']['complete']+SCENARIO_RESOURCES; // add new status
	              	$this->Scenario->id = $scenario['Scenario']['id'];
	              	$this->Scenario->saveField('complete', $newStatus);
	              	$this->Session->setFlash('Resource files are complete');
	              	$this->redirect('edit/'.$scenario['Scenario']['id']);
	              	exit;
		  		}
              	else{
		  	    	$this->Session->setFlash('Warning: some resource files are not properly assigned to parameter values.<br /> ' . $validationRetMsg['msg_string']);		  	    
                	$this->redirect('edit/'.$scenario['Scenario']['id'] . '/' . $validationRetMsg['msg_string']);
               	 	exit;
		  		}	           	
        	}
        }
    }
    
    /**
    * upload resource files for the scenario with given ID
    * The function is called by the upload link in the view
    * @access public requires author rights
    * @param $scenario_id the new scenario id from the add scenario form
    */
    function admin_uploadResourceFiles($scenario_id = null ){
        $this->__requireRole(ROLE_AUTHOR);
        if (empty($this->data)){
            $this->set('isFileLoader',true);//include the file loader javascripts
            $this->set('scenario_id',$scenario_id);
            $data = $this->Scenario->findById($scenario_id);
            if (!$this->_checkRights($data['Scenario']['player_id'])){
               $this->Session->setFlash('You are only allowed to edit your own scenarios.');
               $this->redirect('/authoring');
            }
            preg_match_all('/\$'.SHELL_PARAM.'[0-9]{1,3}/',$data['Scenario']['setup_script'], $shell_params);
            $validParams = $this->Parameter->findAll('(name="'.implode('" OR name="', $shell_params[0]).'") AND scenario_id='.$scenario_id);
            $parameterValues = array();
//             debug($validParams);exit;
            for($k=0; $k<sizeof($validParams); $k++){
                $parameterValues[$k] = array();
                for($l=0; $l<sizeof($validParams[$k]['Parametervalue']); $l++){
                    $key = $validParams[$k]['Parametervalue'][$l]['id'];
                    $parameterValues[$k][$key] = $validParams[$k]['Parametervalue'][$l]['value'];
                }
            }
            //debug($parameterValues);exit;
            $this->set('shell_params',$shell_params[0]);
            $this->set('headline', 'upload resource files for scenario &quot;'.$data['Scenario']['name'].'&quot;');
            $this->set('parameterValues', $parameterValues);
            $this->set('data',$data);
            $this->render();
        } else {
            $this->set('isFileLoader',true);//include the file loader javascripts
            //debug($this->data);exit; //any further action is being done by the attachment controller
        }
    }

    /**
     * This function is used from the admin_resources() function for ajax updates 
     */
    function admin_ajaxResourceForm(){
        $this->layout = 'ajax';
        $this->render();
    }

    /**
    * This action deletes the scenario with given ID and all related data from the DB.
    * Deletion includes scripts, parameters, parametervalues and resource files.
    * @access public requires author role
    * @param $id scenario id from the DB
    * @todo perhaps also delete the scenario history... 
    */
    function admin_delete($id=null){
        $this->__requireRole(ROLE_AUTHOR);

        $scenario = $this->Scenario->findById($id);
        //debug($scenario); exit;
        if (empty($scenario)){
            $this->flash('Scenario with id '.$id.' not found in DB.','scenarios'); exit;
        } else {
           if (!$this->_checkRights($scenario['Scenario']['player_id'])){
              $this->Session->setFlash('You are only allowed to edit your own scenarios.');
              $this->redirect('/authoring');
           }
            // delete Scenario including parameters, parameter values and attachments:
            if ($this->Scenario->delete($id, true)){
                // delete from scenarios_skills table:
//                $this->ScenarioRequirement->deleteAll(array('scenario_id'=>$id));
                // delete from players_scenarios table (player history of completed scenarios):
                $this->PlayersScenario->deleteAll(array('scenario_id'=>$id));
                $this->Session->setFlash('Scenario has been deleted.');
                $this->redirect('index'); exit;
            } else {
                $this->Session->setFlash('ERROR: Could not delete scenario.');
                $this->redirect('index'); exit;
            }
        }
    }

    /**
    * display a screen with the introduction for a scenario with given ID
    * @access public requires login
    * @param $id scenario id from the DB
    */
    function introduction($id)
    {
        $this->__requireLogin();
        $scenario = $this->Scenario->findById($id);

        // check if player has all required skills to play this scenario:
        $scenarioDetails = $this->_checkRequirements($id);
        if(!$scenarioDetails['isAllowed']){
            $this->flash('You are not allowed to play this scenario!', '/scenarios'); return;
        }

        $this->set('headline', 'Introduction');
        $this->set('scenario', $scenario);

    }

    /**
    * validate the data submitted for parametervalues and resources for completeness. 
    * This is a "sanity check" for scenarios
    * @access protected
    * @param int $scenario_id identifies the scenario
    * @param int $validation_status_type the string defined in app/config/nets-x.php
    * @return array with 2 strings: status and message
    */
    function _validateCompletionStatus($scenario_id = null, $validation_status_type = null)
    {
    	$retMsg = array();//init
    	$retMsg['completion_status'] = COMPLETION_STATUS_OK;
    	$retMsg['msg_string'] = COMPLETION_STATUS_OK;     	
    	
    	switch($validation_status_type){
    		
    		case SCENARIO_BASICS:
    			
    			// Parse comparison field for CAKE Parameters
    			$success = $this->_parseComparison($scenario_id);
    			
    			if($success) {
    				$retMsg['msg_string'] = 'Comparison field parsed successfully.';
			   		$retMsg['completion_status'] = COMPLETION_STATUS_OK;
    			} else {
    				$retMsg['msg_string'] = 'Error during parsing the comparison field for parameters.';
			   		$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
    			}
    			break;
    		case SCENARIO_REQUIREMENTS:
    			break;
    		case SCENARIO_SCRIPTS:    		
    			//this functionality is a bit more complex
    			$retMsg = $this->_validateScripts($scenario_id); 
    			break;
    		case SCENARIO_PARAMETERS:	
    			//CAKE parameters must have a description
    			
    			$invalidParams = $this->Parameter->findAll("scenario_id = $scenario_id AND description = '' ");
    			//debug($invalidParams);exit;
    			if( !empty($invalidParams)){
    				$retMsg['completion_status'] = 'error'; 
    				$retMsg['msg_string'] = 'Parameters without description were found.';       			 	
    			}    			
    			break;
			case SCENARIO_PARAMETERSETS:
				//all CAKE parameters must be assigned to a parameter set
				$invalidParams = $this->Parameter->findAll("scenario_id = $scenario_id AND parameterset_id = 0");
    			if( !empty($invalidParams)){
    				$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
    				$retMsg['msg_string'] = 'Parameters without parameterset association found.';    				
    			}    			
    			break;
    		case SCENARIO_PARAMETERVALUES:
    			//there must be a equal number of parameter values in each set (10 usernames must have 10 passwords)
    			$this->Parameterset->unbindModel(array('belongsTo'=>array('Scenario')));
    			$parametersets = $this->Parameterset->findAllByScenarioId($scenario_id);
    			foreach($parametersets as $parameterset){
    			   $num_values = sizeof($parameterset['Parameter'][0]['Parametervalue']);
//    			   debug($num_values);exit;
    			   foreach($parameterset['Parameter'] as $parameter){
      				  if( sizeof($parameter['Parametervalue']) != $num_values ){
             			 $retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
             			 $retMsg['msg_string'] = 'Number of parameter values is inconsistent within the set.';    
          		      }    					
    			   }
    			}
    			break;
    		case SCENARIO_RESOURCES:
    			//parameterset-specific resources must be assigned to a parameter set
    			//general resources and systemaccount resources must NOT have a parameterset id assigned
    			$invalidResources = $this->Resource->findAll("(scenario_id = $scenario_id AND parameterset_id != 0) AND sequence_no<0");
    			if( !empty($invalidResources)){
    				$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
    				$retMsg['msg_string'] = 'Parameterset specific resources without parameter value association were found.';    				
    			} 	
    			break;
    			    			
    		default://shall never be reached
    			$this->Session->setFlash('Error while validating completion status: scenario was not found.');
                $this->redirect('edit/'.$scenario_id);
                exit;
    			//break;			    		
    	}
    	//debug($retMsg);exit;
    	return $retMsg;
    }

    /**
     * This function checks the shell scripts for sanity
     * It is called from _validateCompletionStatus()
     * @access protected
     * @param int $scenario_id identifies the scenario
     * @return array contains 2 strings: Status and error message
     */
	function _validateScripts($scenario_id = null){	 		
	 		$retMsg = array();	
		   
			//read out the scenario
	   		$this->Script->recursive = -1;
	      
		    // remove all model associations except Systemuser       
	    	$this->Scenario->unbindModel(
	        array(
	            'hasMany'=>array('Attachment', 'Parameter'),
	            'hasAndBelongsToMany' => array('Systemaccount','Skill')
	        )
	     	 );
	      
	      	$scenario = $this->Scenario->read(null, $scenario_id);
	      
	      	if (empty($scenario)){
		        $this->Session->setFlash('scenario not found');
		        $this->redirect('/'.Configure::read('Routing.admin').'index');
		        exit;
	    	}
	    	
		   //validation in three steps:
		   //1. check if there is both a player setup and a player cleanup script
		   //because these script types are obligatory for game functionality
			   
			$playerSetupScriptFound = false;   	
			$res = $this->Script->findAllByScripttypeId(array('scenario_id'=>$scenario_id, 'scripttype_id'=>PLAYER_SETUP_SCRIPT));
			
			if( empty($res) ){
			   	$retMsg['msg_string'] = "No player setup script defined.";	
			   	$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
			}else{
				$playerSetupScriptFound = true;	
			}
			
			
		   $playerCleanupScriptFound = false;
		   $res = $this->Script->findAllByScripttypeId(array('scenario_id'=>$scenario_id, 'scripttype_id'=>PLAYER_CLEANUP_SCRIPT));
			      	
			if( empty($res) ){
			   	$retMsg['msg_string'] = "No player cleanup script defined.";
			   	$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
			   					
			}else{
				$playerCleanupScriptFound = true;
			}
			
			if( !$playerSetupScriptFound || !$playerCleanupScriptFound ){
				
				return $retMsg;
				//$this->Session->setFlash('Warning: Shell scripts are incomplete.<br />' . $retMsg);
			    //$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/edit/'.$scenario_id);
			    //exit;
			}
			
		    //2. check if there is at least one cleanup script for each type of setup script in the script stack
			    
			//for the environment scripts (optional)
			$environmentSetupScriptFound = false;
			$environmentCleanupScriptFound = false;
			
			//does an environment setup script exist?
			$res = $this->Script->findAllByScripttypeId(array('scenario_id'=>$scenario_id, 'scripttype_id'=>ENVIRONMENT_SETUP_SCRIPT));   		
			if( empty($res)){
				$environmentSetupScriptFound = false;
			}else{
				$environmentSetupScriptFound = true;	
			}
			
			//does an environment cleanup script exist?
			$res = $this->Script->findAllByScripttypeId(array('scenario_id'=>$scenario_id, 'scripttype_id'=>ENVIRONMENT_CLEANUP_SCRIPT)); 
			   if( empty($res)){
					$environmentCleanupScriptFound = false;	
				}	
				else{
					$environmentCleanupScriptFound = true;
			}
			
			//is there a discrepancy on either side? If so, throw warning and redirect
			   if( $environmentSetupScriptFound && !$environmentCleanupScriptFound ){
			   	$retMsg['msg_string'] = "No environment cleanup script defined for the environment setup script.";
			   	$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
			    return $retMsg;
			}
			    if( !$environmentSetupScriptFound && $environmentCleanupScriptFound ){
			   	$retMsg['msg_string'] = "No environment setup script defined for the environment cleanup script.";
			   	$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
			    return $retMsg;
			}
			
		   	//for the drone scripts (optional)
			$droneSetupScriptFound = false;
			$droneCleanupScriptFound = false;
			
			//does an drone setup script exist?
			$res = $this->Script->findAllByScripttypeId(array('scenario_id'=>$scenario_id, 'scripttype_id'=>ENVIRONMENT_SETUP_SCRIPT));   		
			if( empty($res) ){
				$droneSetupScriptFound = false;
			}else{
				$droneSetupScriptFound = true;	
			}
			
			//does an drone cleanup script exist?
			$res = $this->Script->findAllByScripttypeId(array('scenario_id'=>$scenario_id, 'scripttype_id'=>ENVIRONMENT_CLEANUP_SCRIPT)); 
			   if( empty($res) ){
					$droneCleanupScriptFound = false;	
				}	
				else{
					$droneCleanupScriptFound = true;
			}
			
			//is there a discrepancy on either side? If so, throw warning and redirect
			   if( $droneSetupScriptFound && !$droneCleanupScriptFound ){
			   	
			   	$retMsg['msgString'] = "No drone cleanup script defined for the drone setup script.";
			   	$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
			    return $retMsg;
			}
			    if( !$droneSetupScriptFound && $droneCleanupScriptFound ){
			   	$retMsg['msgString'] = "No drone setup script defined for the drone cleanup script.";
			   	$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
			    return $retMsg;
			}
			
			//3. If the evaluation type is shell-based, there must be a player evaluation script
			
			if($scenario['Scenario']['evaluationtype_id'] == SHELL_BASED){
				$playerEvaluationScriptFound = false;
		    	$res = $this->Script->findAllByScripttypeId(array('scenario_id'=>$scenario_id, 'scripttype_id'=>PLAYER_EVALUATION_SCRIPT));
				if( empty($res) ){
					$retMsg['msg_string'] = "No player evaluation script has been defined for this shell-based scenario.";
					$retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
			    	return $retMsg;	
				}
			}
			 	
	   		//if these three conditions are all ok, then parse the scripts for their parameters
	    	
	   		$success = $this->_parseScripts($scenario_id, $scenario);
			   
		    if($success){
			   $newStatus = ($scenario['Scenario']['complete'] & SCENARIO_SCRIPTS)? $scenario['Scenario']['complete']: $scenario['Scenario']['complete']+SCENARIO_SCRIPTS; // add new status
			   $this->Scenario->id = $scenario['Scenario']['id'];
			   $this->Scenario->saveField('complete', $newStatus);
			   $retMsg['msg_string'] = 'Shell scripts are complete.';
			   $retMsg['completion_status'] = COMPLETION_STATUS_OK;
			   return $retMsg;
		    }
		    else{
			   $retMsg['msg_string'] = 'Error while parsing the shell scripts.';
			   $retMsg['completion_status'] = COMPLETION_STATUS_ERROR;
			   return $retMsg;
		    }
	   }
	
	function _parseComparison($scenario_id) {
		$this->__requireRole(ROLE_AUTHOR);
		$this->Parameter->recursive = 0;
		$existing = $this->Parameter->find('all', array('fields'=>array('id','name'), 'conditions'=>array('scenario_id'=>$scenario_id)));
		$existing = (!empty($existing))? Set::combine($existing, '{n}.Parameter.name','{n}.Parameter.id') : array();
		// make a copy.
		// this contains all existing Params at first, they are removed if still used (found) in the shell scripts
		$toDel = $existing;
		$ok = true;
		
		// remove all model associations except Systemuser       
    	$this->Scenario->unbindModel(
        array(
            'hasMany'=>array('Attachment', 'Parameter'),
            'hasAndBelongsToMany' => array('Systemaccount','Skill')
        )
     	 );
      
      	$scenario = $this->Scenario->read(null, $scenario_id);
      
      	if (empty($scenario)){
	        $this->Session->setFlash('scenario not found');
	        $this->redirect('/'.Configure::read('Routing.admin').'index');
	        exit;
    	}
		
		$regExp = '/\$[A-Z]+[0-9]*/';
		preg_match_all($regExp, $this->data['Scenario']['comparison'], $found);
		foreach($found[0] as $param){
			if (isset($existing[$param])) {
				if (isset($toDel[$param])) {
	               unset($toDel[$param]);
	            }
			} else {
				// Parameter does not exist, yet
				// Create it
				
                if (!$this->Parameter->save(array('id'=>null ,'name'=>$param, 'scenario_id'=>$scenario_id, 'description'=>'no description added yet') , false)){
                   $ok = false;
                }
                $existing[$param] = 'new';
            }
		}
		
		
		// Also parse the scripts to ensure that parameters that are used in
		// the scripts won't be deleted
		$loginCredentials = array('$'.CAKEUSER=>false, '$'.CAKEPASS=>false);
	    foreach($scenario['Script'] as $data){
	       $regExp = '/\$'.SHELL_PARAM.'\d|\$'.CAKEUSER.'|\$'.CAKEPASS.'|\$'.SCRIPTHOST.'/';
	       preg_match_all($regExp, $data['script'], $found);
	       foreach($found[0] as $param){
	          if (isset($existing[$param])){
	             if (isset($toDel[$param])){
	                unset($toDel[$param]);
	             }
	          } else {
	             if (!$this->Parameter->save(array('id'=>null ,'name'=>$param, 'scenario_id'=>$scenario_id, 'description'=>'no description added yet') , false)){
	                $ok = false;
	             }
	             if ($param=='$'.CAKEUSER || $param=='$'.CAKEPASS){
	                $loginCredentials[$param] = $this->Parameter->getLastInsertId();
	             }
	             $existing[$param] = 'new';
	          }
	       }
	    }
	       
		foreach($toDel as $name=>$id){
			if (!$this->Parameter->del($id)){
				$ok = false;
			}
		}
		if (!$ok){
			$this->Session->setFlash('There were errors parsing the comparison field for parameters.<br />Please try again.');
			$this->redirect('/'.Configure::read('Routing.admin').'index');
			exit;
		}
		
		// create the mandatory parameterset with $CAKEUSER and $CAKEPASS:
	    if ($loginCredentials['$'.CAKEUSER] && $loginCredentials['$'.CAKEPASS]){
	         $paramSet = $this->Parameterset->create(array('id'=>null, 'scenario_id'=>$scenario_id, 'name'=>'system login data'));
	         $this->Parameterset->save($paramSet);
	         $setId = $this->Parameterset->getLastInsertId();
	         foreach($loginCredentials as $param_id){
	            $this->Parameter->id = $param_id;
	            $this->Parameter->saveField('parameterset_id', $setId);
	          }
	    }
	      
		return $ok;
	}
	
	/**
	 * This function parses the scripts for parameters and enters them into the DB
	 * It is called from _validateScripts() if a script is valid.
	 * @param int $scenario_id identifies the scenario
	 * @param int $scenario contains the scenario data
	 * @return boolean true on success, false on error
	 */
	function _parseScripts($scenario_id = null, $scenario){
	      unset($this->data);
	      $this->__requireRole(ROLE_AUTHOR);
	      
	      $this->Parameter->recursive = 0;
	      $existing = $this->Parameter->find('all', array('fields'=>array('id','name'), 'conditions'=>array('scenario_id'=>$scenario_id)));
	      $existing = (!empty($existing))? Set::combine($existing, '{n}.Parameter.name','{n}.Parameter.id') : array();
	      //make a copy.
	      // this contains all existing Params at first, they are removed if still used (found) in the shell scripts
	      $toDel = $existing;
	      $ok = true;
	      
	      $loginCredentials = array('$'.CAKEUSER=>false, '$'.CAKEPASS=>false);
	      foreach($scenario['Script'] as $data){
	         $regExp = '/\$'.SHELL_PARAM.'\d|\$'.CAKEUSER.'|\$'.CAKEPASS.'|\$'.SCRIPTHOST.'/';
	         preg_match_all($regExp, $data['script'], $found);
	         foreach($found[0] as $param){
	            if (isset($existing[$param])){
	               if (isset($toDel[$param])){
	                  unset($toDel[$param]);
	               }
	            } else {
	               if (!$this->Parameter->save(array('id'=>null ,'name'=>$param, 'scenario_id'=>$scenario_id, 'description'=>'no description added yet') , false)){
	                  $ok = false;
	               }
	               if ($param=='$'.CAKEUSER || $param=='$'.CAKEPASS){
                      $loginCredentials[$param] = $this->Parameter->getLastInsertId();
                   }
	               $existing[$param] = 'new';
	            }
	         }
	      }
	      
	      	// Also parse the comparison field to ensure that parameters that are used in
			// the field won't be deleted
			$regExp = '/\$[A-Z]+[0-9]*/';
			preg_match_all($regExp, $scenario['Scenario']['comparison'], $found);
			foreach($found[0] as $param) {
				if (isset($existing[$param])) {
					if (isset($toDel[$param])) {
		               unset($toDel[$param]);
		            }
				} else {
					// Parameter does not exist, yet
					// Create it
	                if (!$this->Parameter->save(array('id'=>null ,'name'=>$param, 'scenario_id'=>$scenario_id, 'description'=>'no description added yet') , false)){
	                   $ok = false;
		            }
		            $existing[$param] = 'new';
		        }
			}
		
	      foreach($toDel as $name=>$id){
	         if (!$this->Parameter->del($id)){
	            $ok = false;
	         }
	      }
	      if (!$ok){
	         $this->Session->setFlash('There were errors parsing scripts for parameters.<br />Please try again.');
	         $this->redirect('/'.Configure::read('Routing.admin').'index');
	         exit;
	      }
	      
	      // create the mandatory parameterset with $CAKEUSER and $CAKEPASS:
	      if ($loginCredentials['$'.CAKEUSER] && $loginCredentials['$'.CAKEPASS]){
      	     $paramSet = $this->Parameterset->create(array('id'=>null, 'scenario_id'=>$scenario_id, 'name'=>'system login data'));
      	     $this->Parameterset->save($paramSet);
      	     $setId = $this->Parameterset->getLastInsertId();
      	     foreach($loginCredentials as $param_id){
      	        $this->Parameter->id = $param_id;
      	        $this->Parameter->saveField('parameterset_id', $setId);
   	         }
	      }
	      // everything ok return to validateScripts function:
	      return $ok;
	}

    /**
    * This function checks if a player is allowed to play a scenario with given ID.
    * It is called from the function introduction().
    * @access protected
    * @param int $id scenario id from the DB
    */
    function _checkRequirements($scenario){

        $scenarioDetails = array(
                    'isAllowed'=>true,
                    'name'=>$scenario['name'],
                    'id'=>$scenario['id'],
                    'requirements'=>array() 
                );
        $player_id = ($this->Session->read('Player.id'))? $this->Session->read('Player.id') : NULL;
        if($player_id == NULL) $this->flash('You are not logged in', '/home');
        // see which skills the player has already:
        $inventory = $this->PlayersSkill->findAllByPlayer_id($player_id);
        $player_skills = array(); //associative arr with player skills
        foreach($inventory as $owned){ 
            $player_skills[''.$owned['PlayersSkill']['skill_id']] = true;
        }

        //check if the player has already played this scenario
        $alreadyPlayed = $this->PlayersScenario->find(array('scenario_id'=>$scenario['id'],'player_id'=>$player_id));
        
         $scenarioDetails['completed'] = (sizeof($alreadyPlayed['PlayersScenario']) == 0 )? false : true ;
        
        //check if the requirements are met    
        //$requirements = $this->ScenarioRequirement->findAllByScenario_id($scenario['id']);
        
        $i=0;
//        foreach($requirements as $requirement){
//            $skill = $this->Skill->findById($requirement['ScenarioRequirement']['skill_id']);
//            $scenarioDetails['requirements'][$i]['skill_id'] = $requirement['ScenarioRequirement']['skill_id'];
//            $scenarioDetails['requirements'][$i]['name'] = $skill['Skill']['name'];
//
//            if(isset($player_skills[''.$requirement['ScenarioRequirement']['skill_id']]) && $player_skills[''.$requirement['ScenarioRequirement']['skill_id']] == true){
//                $scenarioDetails['requirements'][$i]['owned'] = true;
//            } else {
//                $scenarioDetails['isAllowed'] = false;
//                $scenarioDetails['requirements'][$i]['owned'] = false;
//            }
//            $i++;
//        }
        //debug($scenarioDetails);
        return $scenarioDetails;
    }
	
    /**
     * This function sets the field "approvedBy".
     * The scenario can not be seen in the scenarios overview if not approved
     * approvedBy = 0 means not approved
     * approvedBy = player_id of logged in tutor means approved
     * @access public requires tutor role
     * @param int $id
     */
    function admin_setApproved($id=null, $isEnabled=true){
       $this->__requireRole(ROLE_TUTOR);
       $isEnabled = ($isEnabled)? $this->Session->read('Player.id') : 0;
       $data = $this->Scenario->read(null, $id);
       if (!$id || empty($data)){
          $this->Session->setFlash('The scenario could not be found.');
       } else {
          $this->Scenario->id = $id;
          $this->Scenario->saveField('approved', $isEnabled);
          $statusText = ($isEnabled)? ' enabled.' : ' disabled.';
          $this->Session->setFlash('The scenario has been'.$statusText);
       }
       $this->redirect('index');
       exit;
    }

    
}
?>
