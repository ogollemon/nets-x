<?php
/**
 * This controller handles the values of shell script parameters.
 * In order to increase replayability, each script can be parameterized. This way the scenario will use different (randomly chosen) values every time it is played.
 * The functions of this controller deal with the administration of these values.
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @author     Alice Boit <boit.alice@gmail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class ParameterValuesController extends AppController {

	/**
    * Class name
    * @var string
    */
    var $name = 'Parametervalues';
	
    /**
    * Array of Strings; which models are used by this controller?
    * @var array
    */
    var $helpers = array('Html', 'Form');
	
    /**
    * Array of Strings; which helpers are used by the view?
    * @var array
    */
    var $uses = array('Parameter', 'Parameterset', 'Parametervalue');
	
	/**
	 * @todo Deprecated ???
	 */
	function add($parameter_id, $seqNo = null, $scenario_id = null) { // parameter_id is a must!
		
		debug($this->data);
	    $this->__requireRole(ROLE_AUTHOR);
	    if (empty($this->data)){
	       $this->Parameter->recursive = 0;
	       $parameter = $this->Parameter->read(null, $parameter_id);
	       if (empty($parameter)){
	          $this->Session->setFlash('Parameter for new value could not be found.');
	          $this->redirect('/'. Configure::read('Routing.admin').'/scenarios/');
              exit;
	       }
	       $new = $this->Parametervalue->create();
           $new['Parametervalue']['parameter_id'] = $parameter_id;
           $new['Parametervalue']['sequence_no'] = $seqNo;
           $this->data = $new;
	       $this->set('parameter_id',$parameter_id);
	       $this->set('scenario_id',$scenario_id);
           $this->render();
	    } else {
			$this->Parametervalue->create();
			$this->Parametervalue->parameter_id = $parameter_id;
			$this->Parametervalue->sequence_no = $seqNo;
		
			if ($this->Parametervalue->save($this->data, false)) {
				
			  	$parameter = $this->Parameter->read(null, $parameter_id);
           		debug($parameter);exit;
				$this->Session->setFlash('Parameter value has been saved.');
			} else {
				$this->Session->setFlash('Parameter value could not be saved.');
			}
			$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/parametervalues/'.$scenario_id);
            exit;
		}
	}

	/**
	 * This action is used to edit a specific value of one parameter.
	 * @access public requires author role
	 * @param int $id identifies the value to edit 
	 * @param int $seqNo this defines which sequence the values are in (important for linked values in parametersets)
	 * @param int $scenario_id identifies the scenario this value is used in 
	 * @param int $parameter_id identifies the parameter this value is assigned to
	 */
	function edit($id = null, $seqNo = null, $scenario_id = null, $parameter_id=null) {
			
	    $this->__requireRole(ROLE_AUTHOR);
	    if (empty($this->data)) {
      		if (!$id) {
      			$this->Session->setFlash('No ID given.');
      			$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/'.$scenario_id);
      			exit;
      		}
      		if ($id != 'new'){ // try to load Value with given id
      		    $this->data = $this->Parametervalue->read(null, $id);
      		    $this->data['Parametervalue']['sequence_no'] = $seqNo;
      		    if (empty($this->data)){
      		       $this->Session->setFlash('Parameter value not Found.');
                   $this->redirect('/'.Configure::read('Routing.admin').'/scenarios/'.$scenario_id);
                   exit;
      		    }
      		} else { // new Value:
      		   $this->data = $this->Parametervalue->create();
      		   $this->data['Parametervalue']['id'] = 'new'; 
      		   //debug($parameter_id);exit;     		  
               $this->data['Parametervalue']['parameter_id'] = $parameter_id; //this should be checked...
               $this->data['Parametervalue']['sequence_no'] = $seqNo;
               //debug($this->data);
      		}
      		$this->set('scenario_id',$scenario_id);
      		$this->render();
	   } else  { // Form data was submitted
	   		//debug($this->data);exit;
	   		//id is either 'new' or an existing value
			if ($this->Parametervalue->create($this->data)) {
				//debug($this->data);exit;				 
				$this->Parametervalue->save();
				//write the new number of parametervalues in the parametersets table
				$parameter = $this->Parameter->read(null, $this->data['Parametervalue']['parameter_id']);
           		$num_param_values = sizeof($parameter['Parametervalue']);
           		$this->Parameterset->save(array('id'=>$parameter['Parameter']['parameterset_id'], 'num_values'=>$num_param_values));
				//debug($this->Parameterset->read(null, $parameter['Parameter']['parameterset_id']));exit;           		
				$this->Session->setFlash('Parameter value has been saved.');
			} else {
			   $this->Session->setFlash('Parameter value could not be saved.');
			}
			$this->redirect('/'.Configure::read('Routing.admin').'/scenarios/parametervalues/'.$scenario_id);
			exit;
		}
	}

	/**
	 * With this action one specific value can be deleted.
	 * @access public requires author role
	 * @param int $id identifies the value to delete
	 * @param int $scenario_id used for redirection
	 */
	function delete($id = null, $scenario_id = null) {
	    $this->__requireRole(ROLE_AUTHOR);
		if (!$id) {
			$this->Session->setFlash('Invalid id for Parametervalue');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Parametervalue->find($id)) {
			$parameterValue = $this->Parametervalue->find($id);
			$parameter_id = $parameterValue['Parametervalue']['parameter_id'];
			//now the parameter value can be thrown away
			$this->Parametervalue->del($id);
			//write the new number of parametervalues in the parametersets table			
			$parameter = $this->Parameter->read(null, $parameter_id);						
			$num_param_values = sizeof($parameter['Parametervalue']);
           	$this->Parameterset->save(array('id'=>$parameter['Parameter']['parameterset_id'], 'num_values'=>$num_param_values));
           	
			$this->Session->setFlash('Parameter value has been deleted');
			$dest = (!$scenario_id)? '/'.Configure::read('Routing.admin').'/scenarios/' : '/'.Configure::read('Routing.admin').'/scenarios/parametervalues/'.$scenario_id;
			$this->redirect($dest);
		}
	}


}
?>