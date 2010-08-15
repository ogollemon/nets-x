<?php
/**
 * This controller contains all functions for the administration of random questions
 * asked by NPCs to players within the 2D adventure world.
 * It also contains the administration functions for Tutors as well as the authoring functions
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @author     Philipp Daniel <phlipmode23@gmail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class AdventureQuestionsController extends AppController {

    /**
    * class name variable
    * @var string
    */
	var $name = 'AdventureQuestions';
	
	/**
    * Array of Strings; which helpers are used
    * @var array
    */
    var $helpers = array('Theme','Html','Javascript','Form', 'Ajax');

    /**
    * Array of Strings; which models are used by this controller?
    * @var array
    */	
    var $uses = array(
        'AdventureQuestion',
        'Topic',
        'AdventureAnswer',
        'Player'
    );


    /**
     * This is the "CMS" view for the adventure questions
     * It is accessible for authors and tutors 
     * @access public requires author rights
     */
    function admin_index(){
        $this->__requireRole(ROLE_AUTHOR);
        $this->Topic->unbindModel(
           array(
               'hasMany'=>array('Scenario', 'Exam')
           )
        );
        $this->set('data', $this->Topic->find('all'));
        $this->render();
    }
    
    /**
     * This deletes the adventure question with the given id
     * and its answers from the DB
     * @access public requires author rights
     * @param int $id
     */
    function admin_delete($id=null){
       $this->__requireRole(ROLE_AUTHOR);
       if (!$this->AdventureQuestion->del($id)){
          $this->Session->setFlash('The adventure question could not be deleted');
       } else {
          $this->Session->setFlash('The adventure question has been deleted');
       }
       $this->redirect('index');
       exit;
    }
    
    /**
    * This action is called from the "authoring" view and renders
    * a form where players can edit a new question to the pool of random
    * question that can be used by npcs. The view also provides answers to the questions.
    * for this purpose it utilizes the "edit.ctp"
    * @access public requires login
    */
    function add(){
        $this->__requireLogin();
        
        $this->set('topics', $this->Topic->find('list'));
        $this->set('answers', $this->AdventureAnswer->answers);
        $pid = $this->Session->read('Player.id');
        
        if (empty($this->data)){//form data was not submitted yet
            //show add mask in edit view	        
           // create an empty adventure question and give it to the edit view:
           $this->data = $this->AdventureQuestion->create();
           $this->data['AdventureQuestion']['id'] = null;
           $this->data['AdventureQuestion']['player_id'] = $this->Session->read('Player.id');
           $this->render('edit');
        }
    }
       
    /**
     * This renders a view with the edit form
     * @access public requires login
     * @param int $id the id of the question to edit; null if new
     */
    function edit($id=null){
      $this->__requireLogin();
      $this->set('topics', $this->Topic->find('list'));     
      $this->set('answers', $this->AdventureAnswer->answers);
         
      if (empty($this->data)){
         $data = $this->AdventureQuestion->findById($id);
         if (!$id || empty($data)){
           $this->Session->setFlash('Adventure question could not be found.');
           $this->redirect('/authoring');
           exit;
         }
         $this->data = $data;       
         $this->render();
         
      } else { // form data submitted:
         
        $pid = $this->Session->read('Player.id');
       
//        debug($this->data);exit;
         for ($i=0; $i < $this->AdventureAnswer->answers['possible']; $i++){
             $a = ltrim(rtrim($this->data['AdventureAnswer'][$i]['text']));
             if (strlen($a)>0){
                $this->data['AdventureAnswer'][$i]['score'] = ($this->data['AdventureAnswer'][$i]['is_true']==1)? PS_ADVENTURE_ANSWER : 0 ;
                $this->data['AdventureAnswer'][$i]['player_id']=$pid;
             } else {
                unset($this->data['AdventureAnswer'][$i]);
             }
         }
//      debug($this->data); exit;
         if ($this->data['AdventureQuestion']['score_awarded']==0){ // new adventure question
            $this->data['AdventureQuestion']['player_id'] = $pid;
         } else {
            $this->data['AdventureQuestion']['editedBy']= $pid;
         }
         $aid = $this->data['AdventureQuestion']['id'];
         if ($this->AdventureQuestion->create($this->data['AdventureQuestion']) && $this->AdventureQuestion->validates()){
             if (!$this->AdventureQuestion->save($this->data['AdventureQuestion'])){
                 $this->Session->setFlash('There was an error submitting the question.');
                 unset($this->data);
                 $this->redirect('/authoring');
                 exit;
             }
             if (!$aid) $aid = $this->AdventureQuestion->getLastInsertId();
             foreach ($this->data['AdventureAnswer'] as $answer){
                 $answer['adventure_question_id'] = $aid;
                 $this->AdventureAnswer->create($answer);
                 $this->AdventureAnswer->save();
             }
         } else {
             $this->Session->setFlash('The question is not valid.<br />Please correct the errors.');
             $this->render('edit');
             return;
         }
         $this->Session->setFlash('Your question was submitted.');
         unset($this->data);
         $this->redirect('/authoring/index');
         exit;
      }
    }
    
    /**
     * This is used by authors or tutors to edit questions
     * @access public requires author rights
     * @param int $id the id of the question to edit; null if new
     */
    function admin_edit($id=null){
      $this->__requireRole(ROLE_AUTHOR);
      $this->set('topics', $this->Topic->find('list'));     
      $this->set('answers', $this->AdventureAnswer->answers);
         
      if (empty($this->data)){
         $data = $this->AdventureQuestion->findById($id);
         if (!$id || empty($data)){
           $this->Session->setFlash('Adventure question could not be found.');
           $this->redirect('/authoring');
           exit;
         }
         $this->data = $data;       
         $this->render();
         
      } else { // form data submitted:
         
        $pid = $this->Session->read('Player.id');
//        debug($this->data);exit;
         for ($i=0; $i < $this->AdventureAnswer->answers['possible']; $i++){
             $a = ltrim(rtrim($this->data['AdventureAnswer'][$i]['text']));
             if (strlen($a)>0){
                $this->data['AdventureAnswer'][$i]['score'] = ($this->data['AdventureAnswer'][$i]['is_true']==1)? PS_ADVENTURE_ANSWER : 0 ;
                $this->data['AdventureAnswer'][$i]['player_id']=$pid;
             } else {
                unset($this->data['AdventureAnswer'][$i]);
             }
         }
         if ($this->data['AdventureQuestion']['score_awarded']==0){ // new adventure question
            $this->data['AdventureQuestion']['player_id'] = $pid;
         } else {
            $this->data['AdventureQuestion']['editedBy']= $pid;
         }
//         debug($this->data); exit;
         $aid = $this->data['AdventureQuestion']['id'];
         if ($this->AdventureQuestion->create($this->data['AdventureQuestion']) && $this->AdventureQuestion->validates()){
             if (!$this->AdventureQuestion->save($this->data['AdventureQuestion'])){
                 $this->Session->setFlash('There was an error submitting the question.');
                 unset($this->data);
                 $this->redirect('index');
                 exit;
             }
             if (!$aid) $aid = $this->AdventureQuestion->getLastInsertId();
             foreach ($this->data['AdventureAnswer'] as $answer){
                 $answer['adventure_question_id'] = $aid;
                 $this->AdventureAnswer->create($answer);
                 $this->AdventureAnswer->save();
             }
         } else {
             $this->Session->setFlash('The question is not valid.<br />Please correct the errors.');
             $this->render('edit');
             return;
         }
         $this->Session->setFlash('Adventure question was saved.');
         unset($this->data);
         $this->redirect('index');
         exit;
      }
    }

    /**
     * show a list of all unpublished adventure question
     * @access public requires author rights
     */
    function admin_approvals(){
        $this->__requireRole(ROLE_AUTHOR);
        if (empty($this->data)){
            $data = $this->AdventureQuestion->findAll('approvedBy=0', null, 'modified ASC');
            for($i=0; $i<sizeof($data); $i++){
                $nickname = $this->Player->findById($data[$i]['AdventureQuestion']['player_id']);
                $data[$i]['AdventureQuestion']['nick'] = $nickname['Player']['nick'];
            }
            if (!empty($data)){
                $this->set('headline', 'overview of unpublished question');
                $this->set('data',$data);
            } else {
                $this->flash('There are currently no new unpublished questions.', '/'.Configure::read('Routing.admin'));
            }

        } else {
            if (!$this->AdventureQuestion->save($this->data)){
                $this->Session->setFlash('There was an error saving the question.');
            } else {
                $this->Session->setFlash('The question was saved.');
            }
            unset($this->data);
            $this->redirect('index');
            exit;
        }
    }

    /**
     * This is called when an author or tutor approves a player submitted question
     * The score is awarded to the player.
     * @access public requires author rights
     */
    function admin_approve(){
        $this->__requireRole(ROLE_AUTHOR);
        $data = $this->AdventureQuestion->findById($this->data['AdventureQuestion']['id']);
        if (empty($data)){
           $this->Session->setFlash('No adventure question data to approve.');
           $this->redirect('/admin');
           exit;
        }
        $pid = $this->Session->read('Player.id');
        $nick = $this->data['AdventureQuestion']['nick'];
        unset($this->data['AdventureQuestion']['nick']);
        //calculate score to award:
        if ($data['AdventureQuestion']['score_awarded']>0){ // the adventure question is not new:
            $score = PS_ADVENTURE_QUESTION_EDIT; // editing gives only scores once
        } else { // for new adventure question: score for question and each answer!
            $score = PS_ADVENTURE_QUESTION + sizeof($data['AdventureAnswer'])*PS_ADVENTURE_ANSWER;
        } 
        
        $this->AdventureQuestion->id = $data['AdventureQuestion']['id'];
        $saveData = array(
            'approvedBy'=>$pid,
            'editedBy'=> 0,
            'score_awarded'=> $score,
            'remark'=>''
        );

        // award score and save:
        if (!$this->Player->awardScore($data['AdventureQuestion']['player_id'], $score)){
            $this->Session->setFlash('There was an error awarding the score.');
        } else if (!$this->AdventureQuestion->save($saveData)){
            $this->Session->setFlash('There was an error saving the approval.');
        } else {
            $this->Session->setFlash('The approval was saved, '.$score.' score awarded to <i>'.$nick.'</i>.');
        }
        unset($this->data);
        $this->redirect('/admin');
        exit;
    }
    
	/**
     * This function sets the field "approvedBy" to 0.
     * if not approved the question will not be used by NPCs in the game
     * @access public requires author rights
     * @param int $id id of the question
     * @param boolean $isEnabled 0 to disable, 1 to enable question
     */
    function admin_setApproved($id=null, $isEnabled=true){
       $this->__requireRole(ROLE_AUTHOR);
       $isEnabled = ($isEnabled)? $this->Session->read('Player.id') : 0;
       $data = $this->AdventureQuestion->read(null, $id);
       if (!$id || empty($data)){
          $this->Session->setFlash('The adventure question could not be found.');
       } else {
          $this->AdventureQuestion->id = $id;
          $this->AdventureQuestion->saveField('approvedBy', $isEnabled);
          $statusText = ($isEnabled)? ' enabled.' : ' disabled.';
          $this->Session->setFlash('The adventure question has been'.$statusText);
       }
       $this->redirect('index');
       exit;
    }
    
    /**
     * This function saves the remark of an author or tutor for a specific question for feedback to the author what can/must be improved.
     * @access public requires author rights 
     */
    function admin_saveRemark(){
    	$this->__requireRole(ROLE_AUTHOR);
    	$remark = $this->data['AdventureQuestion']['remark'];
    	$data = $this->AdventureQuestion->findById($this->data['AdventureQuestion']['id']);
    	unset($this->data['AdventureQuestion']['remark']);
    	$data['AdventureQuestion']['remark'] = $remark;
        //debug($data);exit;
        if (!$this->AdventureQuestion->save($data)){
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