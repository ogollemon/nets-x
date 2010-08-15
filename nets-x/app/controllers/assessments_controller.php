<?php
/**
 * This controller contains all functions for the administration of exam questions (assessments) for a specific topic.
 * It also contains the administration functions for Tutors as well as the authoring functions
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class AssessmentsController extends AppController {

    /**
    * controller class name
    * @var string
    */
    var $name = 'Assessments';
    
    /**
     * Helpers used in the view
     * @var array
     */
    var $helpers = array('Theme','Html','Javascript','Form', 'Ajax');

    /**
    * Array of Strings; which models are used by this controller?
    * @var array
    */  
    var $uses = array('Exam','Assessment','Answer','Topic','Player');

    /**
    * Default method. Sets the topics list.
    * @access public requires login
    */
    function index() {
        $this->__requireLogin();
        $this->set('TopicsList', $this->Topic->findAll());
        $this->render();
    }
    
    /**
    * This action is called from the "authoring" view and renders
    * a form where players can edit a new assessment and provide answers
    * for this purpose it utilizes the "edit.ctp"
    * @access public requires login
    */
    function add(){
        $this->__requireLogin();
        $this->set('exams', $this->Exam->find('list'));
        $this->set('answers', $this->Answer->answers);
        $pid = $this->Session->read('Player.id');
        
        if (!empty($this->data)){
        
        } else {
           // create an empty Assessment and give it to the edit view:
           $this->data = $this->Assessment->create();
           $this->data['Assessment']['player_id'] = $this->Session->read('Player.id');
           $this->render('edit');
        }
    }
    
    /**
     * This renders a view with the edit form
     * @access public requires login
     * @param int $id the id of the assessment to edit; null if new
     */
    function edit($id=null){
      $this->__requireLogin();
      $this->set('exams', $this->Exam->find('list'));
      $this->set('answers', $this->Answer->answers);
         
      if (empty($this->data)){
         $data = $this->Assessment->findById($id);
         if (!$id || empty($data)){
           $this->Session->setFlash('Assessment could not be found.');
           $this->redirect('/authoring');
           exit;
         }
         $this->data = $data;
       
         $this->render();
         
      } else { // form data submitted:
         
        $pid = $this->Session->read('Player.id');
       
         // remove empty answers:
         for ($i=0; $i < $this->Answer->answers['possible']; $i++){
             $a = ltrim(rtrim($this->data['Answer'][$i]['text']));
             if (strlen($a)>0){
                $this->data['Answer'][$i]['score'] = ($this->data['Answer'][$i]['is_true']==1)? PS_ANSWER : 0 ;
                $this->data['Answer'][$i]['player_id']=$pid;
             } else {
                unset($this->data['Answer'][$i]);
             }
         }
         if ($this->data['Assessment']['score_awarded']==0){ // new assessment
            $this->data['Assessment']['player_id'] = $pid;
         } else {
            $this->data['Assessment']['editedBy']= $pid;
         }
         $aid = $this->data['Assessment']['id'];
         if ($this->Assessment->create($this->data['Assessment']) && $this->Assessment->validates()){
             if (!$this->Assessment->save($this->data['Assessment'])){
                 $this->Session->setFlash('There was an error submitting the assessment.');
                 unset($this->data);
                 $this->redirect('/authoring');
                 exit;
             }
             if (!$aid) $aid = $this->Assessment->getLastInsertId();
             foreach ($this->data['Answer'] as $answer){
                 $answer['assessment_id'] = $aid;
                 $this->Answer->create($answer);
                 $this->Answer->save();
             }
         } else {
             $this->Session->setFlash('The Assessment is not valid.<br />Please correct the errors.');
             $this->render('edit');
             return;
         }
         $this->Session->setFlash('Your Assessment was submitted.');
         unset($this->data);
         $this->redirect('/authoring/index');
         exit;
      }
    }
    
    /**
     * This is the "CMS" overview for the exam assessment questions
     * It shows a list of all exams and the assessments they contain
     * @access public requires tutor role
     */
    function admin_index(){
        $this->__requireRole(ROLE_TUTOR);
        $this->Exam->unbindModel(
            array('hasMany' => array('Assessment'))
        );
        $this->Exam->bindModel(
        array ('hasMany' => array('Assessment' =>
                         array('className'     => 'Assessment',
                               'conditions'    => '',
                               'order'         => '',
                               'limit'         => '',
                               'foreignKey'    => 'exam_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         )
                  )
        ));
        $data = $this->Exam->find('all');
        $this->set('data', $data);
        $this->render();
    }
    
    /**
     * This deletes the assessment with the given id
     * and its answers from the DB
     * @access public requires tutor role
     * @param int $id
     */
    function admin_delete($id=null){
       $this->__requireRole(ROLE_TUTOR);
       if (!$this->Assessment->del($id)){
          $this->Session->setFlash('The Assessment could not be deleted');
       } else {
          $this->Session->setFlash('The Assessment has been deleted');
       }
       $this->redirect('index');
       exit;
    }

    /**
    * show a list of all unpublished assessment questions
    * @access public requires tutor rights
    */
    function admin_approvals(){
        $this->__requireRole(ROLE_TUTOR);
        if (empty($this->data)){
            $data = $this->Assessment->findAll('Assessment.approvedBy=0', null, 'modified ASC');
            for($i=0; $i<sizeof($data); $i++){
                $nickname = $this->Player->findById($data[$i]['Assessment']['player_id']);
                $data[$i]['Assessment']['nick'] = $nickname['Player']['nick'];
            }
            if (!empty($data)){
                $this->set('headline', 'overview of unpublished assessments');
                $this->set('data',$data);
            } else {
                $this->flash('There are currently no new unpublished assessments.', '/'.Configure::read('Routing.admin').'/scenarios/');
            }

        } else {
            if (!$this->Assessment->save($this->data)){
                $this->Session->setFlash('There was an error saving the assessment.');
            } else {
                $this->Session->setFlash('The assessment was saved.');
            }
            unset($this->data);
            $this->redirect('index');
            exit;
        }
    }
    
    /**
     * This function is called when a tutor approves a player submitted assessment question
     * On success the score is awarded to the player.
     * @access public requires tutor rights
     */
    function admin_approve(){
        $this->__requireRole(ROLE_TUTOR);
        $data = $this->Assessment->findById($this->data['Assessment']['id']);
        if (empty($data)){
           $this->Session->setFlash('No Assessment data to approve.');
           $this->redirect('/admin');
           exit;
        }
        $pid = $this->Session->read('Player.id');
        $nick = $this->data['Assessment']['nick'];
        unset($this->data['Assessment']['nick']);
        //calculate score to award:
        if ($data['Assessment']['score_awarded']>0){ // the assessment is not new:
            $score = PS_ASSESSMENT_EDIT; // editing gives only scores once
        } else { // for new assessment: score for question and each answer!
            $score = PS_ASSESSMENT + sizeof($data['Answer'])*PS_ANSWER;
        } 
        
        $this->Assessment->id = $data['Assessment']['id'];
        $saveData = array(
            'approvedBy'=>$pid,
            'editedBy'=> 0,
            'score_awarded'=> $score,
            'remark'=>''
        );

        // award score and save:
        if (!$this->Player->awardScore($data['Assessment']['player_id'], $score)){
            $this->Session->setFlash('There was an error awarding the score.');
        } else if (!$this->Assessment->save($saveData)){
            $this->Session->setFlash('There was an error saving the approval.');
        } else {
            $this->Session->setFlash('The approval was saved, '.$score.' score awarded to <i>'.$nick.'</i>.');
        }
        unset($this->data);
        $this->redirect('/admin');
        exit;
    }
    
    /**
     * This function toggles the field "approvedBy" to 0 or tutorId.
     * If 0, The assessment can not be seen in the exam
     * @access public requires tutor rights
     * @param int $id the assessment id to (dis)approve
     * @param boolean $isEnabled if true the id of currently logged in tutor is set for approvedBy 
     */
    function admin_setApproved($id=null, $isEnabled=true){
       $this->__requireRole(ROLE_TUTOR);
       $isEnabled = ($isEnabled)? $this->Session->read('Player.id') : 0;
       $data = $this->Assessment->read(null, $id);
       if (!$id || empty($data)){
          $this->Session->setFlash('The assessment could not be found.');
       } else {
          $this->Assessment->id = $id;
          $this->Assessment->saveField('approvedBy', $isEnabled);
          $statusText = ($isEnabled)? 'enabled.' : 'disabled.';
          $this->Session->setFlash('The assessment has been '.$statusText);
       }
       $this->redirect('index');
       exit;
    }
    
    /** 
     * this is called with POST-data from admin_approvals
     * Saves the remark
     * @access public require tutor role
     */
    function admin_saveRemark(){
        $this->__requireRole(ROLE_TUTOR);
        $remark = $this->data['Assessment']['remark'];
        $data = $this->Assessment->findById($this->data['Assessment']['id']);
        
        unset($this->data['Assessment']['remark']);
        $data['Assessment']['remark'] = $remark;
        //debug($data);exit;
        if (!$this->Assessment->save($data)){
            $this->Session->setFlash('There was an error saving the remark.');
        } else {
            $this->Session->setFlash('The remark was saved.<br />');
        }
        
        unset($this->data);
        $this->redirect('approvals');
        exit;
    }
    
}
?>