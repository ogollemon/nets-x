<?php
/**
 * This controller handles sets of shell script parameters.
 * In order to increase replayability, each script can be parameterized. This way the scenario will use different (randomly chosen) values every time it is played.
 * Sometimes these values have a relation to each other. For example the parameters $CAKEUSER and $CAKEPASS logically belong together.
 * This means that their values are "linked". When value "Tom" is chosen for $CAKEUSER the value for $CAKEPASS CANNOT be chosen randomly, but instead has to be
 * the password belonging to that username.
 * For NetS-X, these parameters belong to one parameterset. 
 * The functions of this controller deal with the administration of these sets.
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @author     Alice Boit <boit.alice@gmail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class ParametersetsController extends AppController {

    /**
    * Class name
    * @var string
    */
    var $name = 'Parametersets';
    
    /**
    * Array of Strings; which helpers are used by the view?
    * @var array
    */
    var $helpers = array('Html', 'Form');
    
    /**
    * Array of Strings; which models are used by this controller?
    * @var array
    */
    var $uses = array(
       'Parameterset',
       'Scenario',
       'Parameter'
    );

    /**
     * the parameterset is deleted and also the foreign key in parameters is set to 0
     * @access public requires author role
     * @param int $id identifies the set to delete
     */
    function admin_delete($id = null) {
        $this->__requireRole(ROLE_AUTHOR);
        $admin = '/'.Configure::read('Routing.admin');
        $data = $this->Parameterset->read(null, $id);
        if (empty($data)){
            $this->Session->setFlash('Parameterset was not found');
            $this->redirect($admin.'/scenarios/');
            exit;
        }
        $scenario_id = $data['Scenario']['id'];
        $ok = true;
        foreach ($data['Parameter'] as $param) {
            $this->Parameter->id = $param['id'];
            if (!$this->Parameter->saveField('parameterset_id', 0)){
              $ok = false;
            }
        }
        if (!$ok){
            $this->Session->setFlash('There were errors unbinding the parameters.');
            $this->redirect($admin.'/scenarios/parametersets/'.$scenario_id);
            exit;
        }
        if ($this->Parameterset->del($id)) {
            $this->Session->setFlash('Parameterset deleted');
        } else {
            $this->Session->setFlash('There was an error deleting the Parameterset.');
        }
        $this->redirect($admin.'/scenarios/parametersets/'.$scenario_id);
        exit;
    }
       
    /**
     * This function adds a parameterset for the given scenario_id
     * The new parameterset_id is then saved in the parameters given
     * @access public requires author role
     * @param int $scenario_id identifies the scenario this set belongs to
     */
    function admin_add($scenario_id=null) {
       $this->__requireRole(ROLE_AUTHOR);
       $admin = '/'.Configure::read('Routing.admin');
       if (!$scenario_id){
           $this->redirect($admin.'/scenarios/');
           exit;
        }
        // remove all model associations except Parameter: 
        $this->Scenario->unbindModel(
           array(
               'hasMany'=>array('Attachment', 'Script'),
               'hasAndBelongsToMany' => array('Systemaccount','Skill')
           )
        );
        $this->Scenario->recursive = 1;
        $scenario = $this->Scenario->findById($scenario_id);
        if (empty($this->data)){
           if (!empty($scenario)){
               $scenario['Parameter'] = Set::combine($scenario['Parameter'], '{n}.id', '{n}');
               $this->Parameter->recursive = 0;
               $unassigned = $this->Parameter->findAll('scenario_id='.$scenario_id.' AND parameterset_id=0');
               $unassigned = (!empty($unassigned)) ? Set::combine($unassigned, '{n}.Parameter.id', '{n}.Parameter.name') : array();
               $this->set('unassigned', $unassigned);
               $this->data = $this->Parameterset->create();
               $this->data['Parameterset']['scenario_id'] = $scenario_id;
               $this->render();
           } else {
               $this->Session->setFlash('Scenario was not found.');
               $this->redirect($admin.'/scenarios/');
               exit;
           }
           
        } else { // Form data was submitted and parameterset can be saved
           
           $parameters = $this->data['Parameterset']['Parameter'];
           if (empty($parameters)){
               $this->Session->setFlash('Please select at least one Parameter for this set!');
               $this->redirect($admin.'/scenarios/parametersets/'.$this->data['Parameterset']['scenario_id']);
               exit;
           }
           unset($this->data['Parameterset']['Parameter']);
           $ok = true;
           if (!$this->Parameterset->save($this->data)){
               $ok = false;
               $this->Session->setFlash('There was an error creating the parameterset');
               $this->redirect($admin.'/scenarios/parametersets/'.$this->data['Parameterset']['scenario_id']);
               exit;
           }
           $set_id = $this->Parameterset->getLastInsertID();
           foreach ($parameters as $id){
              $this->Parameter->id = $id;
              if (!$this->Parameter->saveField('parameterset_id', $set_id)){
                 $ok = false;
              }
           }
           if ($ok){
              $this->Session->setFlash('Parameterset was added.');
           } else {
              $this->Session->setFlash('There were errors associating the parameters.');
           }
           $this->redirect($admin.'/scenarios/parametersets/'.$this->data['Parameterset']['scenario_id']);
           unset($this->data);
           exit;
        }
    }

}
?>