<?php
/**
 * This controller handles the self-assessment quizes for each topic.
 * The play function renders an exam.
 * The index action is used by ajax in the PDA
 * Finally the evaluate function evaluates the player success and awards the score.
 *
 * @category   Controller
 * @author     Alice Boit <boit.alice@gmail.com>
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class ExamsController extends AppController {
    
   /**
    * controller class name
    * @var string
    */
    var $name ='Exams';
    
    /**
    * Which helpers are used
    * @var string
    */
    var $helpers = array('Html','Form','Javascript','Ajax');
    
    /**
    * Array of Strings; which models are used by this controller?
    * @var array
    */	
    var $uses = array('Topic','Exam','Assessment','Answer','Player');

    /**
    * Play a particular exam. 
    * This assessment actually contains the questions about the NetSec topic 
    * (getting really serious here)
    * @access public requires login
    * @param $exam_id the id of the exam to render
    */
    function play($exam_id=NULL) {
        $this->__requireLogin();
        $this->layout = 'pda';
        $this->Exam->recursive = 2;
        $data = $this->Exam->findById($exam_id);
        if (empty($data)){
           $this->Session->setFlash('Exam was not found.');
           $this->redirect('index');
           exit;
        }
        $this->data = $data;
    }
    
    /**
    * Default method. Set topics list with the exams in the PDA.
    * @access public requires login
    */
    function index() {
        $this->__requireLogin();
        $this->set('TopicsList', $this->Topic->findAll());
    }

    /**
    * This function evaluates the player's answers and assigns scores accordingly.
    * @access public requires login
    */
    function evaluate(){
        $this->__requireLogin();
        $this->layout = 'pda';
        
        if(empty($this->data)){
            $this->Session->setFlash('Exam not taken.');
            $this->redirect('index');
            exit;
        }
        $studentData = $this->data;
//        $studentData['Answer'] = Set::combine($studentData, '{n}', )
        $this->Exam->recursive = 2;
        $data = $this->Exam->read(null, $this->data['Exam']['id']);
        $exam_name = $data['Exam']['name'];
        $questions = (!empty($data))? Set::extract($data['Assessment'], '{n}.text') : array();
        $data = (!empty($data['Assessment']))? Set::extract($data['Assessment'], '{n}.Answer') : array();
//        debug($studentData);
//        debug($data); exit;
        $score = 0;
        $correct = 0;
        $percent = 0;
        $exam_score = 0;
        
        
        $feedback = array(); // for feedback!
        
        $i=1;
        foreach($data as $answer){
           $feedback[$i]['text'] = $questions[($i-1)];
           $assessment_valid = true;
           $student_checked = 0;
           $student_correct = 0;
           $student_score = 0;
           
           $question_correct = 0;
           $question_score = 0;
           
           foreach($answer as $item){
              $correct += $item['is_true'];
              $question_correct += $item['is_true'];
              $exam_score += ($item['score']>0)? $item['score'] : 0; // in case of negative score
              $question_score += ($item['score']>0)? $item['score'] : 0; // in case of negative score
              if ($studentData['Answer'][$item['id']]==1){
                 $student_checked ++;
                 if ($item['is_true']){
                    $student_correct += 1;
                    $student_score += $item['score'];
                 }
              }
           }
           
           $feedback[$i]['student'] = array(
                'checked'=>$student_checked,
                'correct'=>$student_correct,
                'score'=>$student_score
           );
           $feedback[$i]['real'] = array(
                'correct'=>$question_correct,
                'score'=>$question_score
           );
           
           // Too many answers checked! Zero points for assessment
           if($student_checked > $question_correct){
              $assessment_valid = false;
              $feedback[$i]['student']['score'] = 0;
              $feedback[$i]['real']['status'] = 'error';
           }
           // No answers checked! Zero points for assessment
           if($student_checked == 0 || $student_score==0){
              $assessment_valid = false;
              $feedback[$i]['real']['status'] = 'error';
           }
           // okay
           if ($assessment_valid){   
              $status = ($student_correct == $question_correct)? 'message' : 'warning';
              $feedback[$i]['real']['status'] = $status;
           }
           $score += $feedback[$i]['student']['score']; // add up
           $i++;
        }
        
        $percent = round(($score * 100 / $exam_score),1);
        $this->set('exam_name', $exam_name);
        $this->set('percent', $percent);
        $this->set('score', $score);
        $this->set('exam_score', $exam_score);
        $this->set('feedback', $feedback);
        // TODO: save exam history!
        if (!$this->Player->awardScore($this->Session->read('Player.id'), $score)){
           $this->Session->setFlash('Error during evaluation of this scenario.');
           $this->redirect('index');
           exit;
        }
    }

}
?>