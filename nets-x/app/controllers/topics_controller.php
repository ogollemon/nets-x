<?php
/**
 * This controller handles all operations concerning a topic of network security
 * It contains the administration functions for tutors.
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @author     Philipp Daniel <phlipmode23@gmail.com>
 * @author     Alice Boit <boit.alice@gmail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class TopicsController extends AppController
{
    /**
     * The class name
     * @var String
     */         
    var $name = 'Topics';
    
    /**
     * Array of model names used by this controller
     * @var Array
     */
    var $uses = array(
        'Topic',
    	'Exam',
        'AdventureQuestion'
    );

    /**
    * default admin action, lists all scenarios with edit options
    * @access public requires tutor role
    */
    function admin_index()
    {
        $this->__requireRole(ROLE_TUTOR);
        $this->Topic->unbindModel(array('hasMany'=>array('Scenario','Exam')));
        $data = $this->Topic->find('all');     
        $data = (!empty($data))? $data : array() ;
        $this->set('data', $data);
        $this->render();
    }

	/**
    * This function edits a topic or adds a new one depending on the parameter.
    * In case of addition it automatically adds an exam as well.
    * @access public requires tutor rights
    * @param int $topic_id identifies the topic to edit, nothing or "new" to add one
    */
    public function admin_edit($topic_id = 'new'){
    
    	$this->__requireRole(ROLE_TUTOR);
        $headline = ($topic_id == 'new')?'Add a new topic':'Edit topic';        
        
        if (empty($this->data)){ //no Form data
            if($topic_id == 'new'){ //add a new topic
                // create default Topic:
                $new = array(
                'id'=>null,
                'name'=>'',
                'description'=>'',
            	'keywords'=>''                
            );
           
	        $this->set('data', $this->Topic->create($new));
            } else {
               
                $topic = $this->Topic->findById($topic_id);
                if (empty($topic)){
                    $this->Session->setFlash('Topic was not found');
                    $this->redirect('topics');exit;
                }
                //debug($scen['Scenario']);exit;
                $this->set('data', $topic);
            }
                                                       
            $this->set('headline', $headline);                        
            $this->render();
            
        } else { // form data has been submitted
                    
            //debug($this->data);exit;

			if (!$this->Topic->save($this->data)){ 
			$this->Session->setFlash('Error: The scenario could not be saved.');
			$this->redirect('edit/'.$topic_id);exit;
			}
			else {
				if ($this->data['Topic']['id'] == 0){
					$okMessage = 'The new topic has been added.';
					$newExam = $this->Exam->createDefault();
					$new_id = $this->Topic->getInsertID(); 
		            $newExam['Exam']['topic_id'] = $new_id;   
		            $newExam['Exam']['name'] = $this->data['Topic']['name'] . ' Test';   
					$this->Exam->save($newExam);	         
				} 
				
				$this->Session->setFlash('Topic successfully saved.');
				unset($this->data);
           		$this->redirect('index/'); exit;
			}
        }	
    }

  
    /**
    * This function removes the topic with given ID and all related data from all tables.
    * Deletion includes scenarios, exams+assessments, adventure_questions
    * @access public requires tutor rights
    * @param $id topic id from the DB
    */
    function admin_delete($id=null){
        $this->__requireRole(ROLE_TUTOR);
        $topic = $this->Topic->findById($id);
        //debug($topic); exit;
        if (empty($topic)){
            $this->flash('Topic with id '.$id.' not found in DB.','topics'); exit;
        } else {
        	
        	if(empty($this->data)){
        		$this->set('data', $topic);
        	} else {
	            // delete Topic including everything related
	            if ($this->data['Topic']['KeepScenarios'] == 0){
	            	if($this->Topic->delete($id, true)){
		                $this->Scenarios->deleteAll(array('topic_id'=>$id));
		               	$this->Exams->deleteAll(array('topic_id'=>$id));
		               	$this->AdventureQuestion->deleteAll(array('topic_id'=>$id));
		                $this->Session->setFlash('Topic, related scenarios, exams and adventure questions have been deleted.');
	                } else {
	                    $this->Session->setFlash('Topic could not be deleted.');
	                }
	            } else {
	            	if($this->Topic->delete($id, true)){
	            		$this->Exam->deleteAll(array('topic_id'=>$id));
	            		$this->AdventureQuestion->deleteAll(array('topic_id'=>$id));
		                $this->Session->setFlash('Topic, related exams and adventure questions have been deleted. Scenarios kept.');
	                } else{
	                    $this->Session->setFlash('Topic and exams could not be deleted.');
	                }
	            }
	            $this->redirect('index'); exit;
        	}
        }
    }
}
?>
