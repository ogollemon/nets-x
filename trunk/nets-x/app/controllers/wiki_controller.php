<?php
/**
 * This controller handles the game wiki
 * It contains the authoring and viewing functions as well as the administration functions for tutors.
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @author     Alice Boit <alice@boit.net>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class WikiController extends AppController
{
    /**
     * class name
     * @var String
     */
    var $name = 'Wiki';
    
    /**
     * array containing the names of used models
     * @var array
     */
    var $uses = array(
        'Article',
        'Topic',
    	'Player'
    );
    
    /**
     * Array with the names of used view helpers
     * @var array
     */
    var $helpers = array('Html','Form','Javascript','Ajax');
    
    /**
     * Array with the names of used cake components (besides Session)
     * @var array
     */
    var $components = array('RequestHandler');

    /**
    * shows the intro page to the wiki
    * @access public requires login
    */
    public function index()
    {
        $this->__requireLogin();
        $isAjax = $this->RequestHandler->isAjax();
        $this->layout = ($isAjax)? false : 'pda';
        $this->set('isAjax', $isAjax);
        
        $this->Topic->bindModel(
           array(
               'hasMany'=>array('Article'=>array(
                               'className'     => 'Article',
                               'conditions'    => 'approvedBy>0',
                               'order'         => 'title ASC',
                               'fields'        => array('id','title','description'),
                               'foreignKey'    => 'topic_id',
                               'dependent'     => false,
                               'exclusive'     => false)
                )              
           )
        );
        $this->Topic->unbindModel(array('hasMany'=>array('Scenario','Exam')));
        $data = $this->Topic->findAll(null,null,'name ASC');
      
        $this->set('data', $data);
//        debug($data);exit;
        
        $this->render();
    }

    /**
     * This is the "CMS" view for the wiki
     * Here, articles can be edited / deleted 
     * @access public requires tutor rights
     */
    function admin_index(){
       $this->__requireRole(ROLE_TUTOR);
       $this->Topic->bindModel(
           array(
               'hasMany'=>array('Article'=>array(
                               'className'     => 'Article',
                               'conditions'    => '',
                               'order'         => 'title ASC',
                               'fields'        => array('id','title','description', 'approvedBy','editedBy','score_awarded'),
                               'foreignKey'    => 'topic_id',
                               'dependent'     => false,
                               'exclusive'     => false)
                )              
           )
        );
        $this->Topic->unbindModel(array('hasMany'=>array('Scenario','Exam')));
        $data = $this->Topic->find('all');
      
        $this->set('data', $data);
        $this->render();
    }
    
    /**
     * This deletes the article with the given id from the wiki
     * @access public requires tutor rights
     * @param int $id
     */
    function admin_delete($id=null){
       $this->__requireRole(ROLE_TUTOR);
       if (!$this->Article->del($id)){
          $this->Session->setFlash('The Wiki article could not be deleted');
       } else {
          $this->Session->setFlash('The Wiki article has been deleted');
       }
       $this->redirect('index');
       exit;
    }
    
    /**
    * This action renders the article with the provided article_id
    * @access public requires login
    * @param int $id the article id
    * @param boolean $isEditable if true, edit button will be shown
    */
    public function article($id = null, $isEditable=false)
    {
        $this->__requireLogin();
        $data= $this->Article->findById($id);
        if (empty($data)){
            $this->Session->setFlash('Article with ID '.$id.' was not found in the DB.');
            $this->redirect('/');
            exit;
        }
        $this->set('isEditable', $isEditable);
        $this->set('data', $data);
    }
    
    /**
    * This function renders an edit view for a wiki article to the given article id.
    * @access public requires login
    * @param int $id identifies the article to edit
    */
    public function edit($id = null){
    
        $this->__requireLogin();
        if (!$id){
           $this->redirect('/authoring');
           exit;
        }
        
        $isAjax = $this->RequestHandler->isAjax();
        $this->layout = ($isAjax)? false : 'pda';
        
        if(empty($this->data)){//form not submitted yet
            $pid = $this->Session->read('Player.id');
            $this->set('articles', $this->Article->find('all', array('conditions'=>'approvedBy>0', 'order'=>'title ASC')));
            $this->set('topics', $this->Topic->find('list'));
      	    $data= $this->Article->findById($id);//pull up the existing content from the DB
      	    if ($data['Article']['editedBy']>0 && $data['Article']['editedBy']!=$pid){
      	       $this->Session->setFlash('You cannot edit this article. It is pending approval.');
      	       $this->redirect('index');
      	       exit;
      	    }
      	    if (empty($data)){
      		    $this->Session->setFlash('Article with ID '.$id.' was not found in the database.','index');
      		    $this->render();
      	    } else {//show the existing content in the form fields
      		     $this->set('data', $data);
      		     $this->render();
      	    }
      	    
        } else {//save edited wiki item data
           
//            debug($this->data);exit;
            $data = $this->data['Article'];
            $this->Article->id = $data['id'];
            
            if ($data['id']==null){ // a new article
               $data['topic_id'] = $data['edit_topic_id'];
               $data['title'] = $data['edit_title'];
               $data['text'] = $data['edit_text'];
            }
            
            if (!$this->Article->save($data)) {
                $this->Session->setFlash('There was an error saving the article.');
            } else {
                $this->Session->setFlash('The article was saved.');
            }
            unset($this->data);
            $this->redirect('/authoring');
            exit;
        }
        //update the current item index for pagination:
    }
	
	/**
    * This action adds a wiki article to the DB
    * looks quite like the index function.
    * @access public requires login
    */
    public function add(){
    	$this->__requireLogin();
	    if(empty($this->data)){
	        $this->layout = 'pda';
            $new = array(
                'id'=>null,
                'title'=>'',
                'description'=>'',
            	'topic_id'=>0,
                'player_id'=>$this->Session->read('Player.id'),
                'remark'=>'',
                'editedBy'=>0,
                'approvedBy'=>0,
                'short_title'=>'',
                'text'=>''
            );
            $this->set('articles', $this->Article->find('all', array('conditions'=>'approvedBy>0', 'order'=>'title ASC')));
	        $this->set('data', $this->Article->create($new));
	        $this->set('topics', $this->Topic->find('list'));
	        $this->render('edit');
	    } else {//save added wiki item data
	    	debug($this->data);exit;
	    }
    }
    
    /**
    * This action renders a list of all unpublished articles in the admin interface
    * @access public requires tutor rights
    */
    function admin_approvals(){
        $this->__requireRole(ROLE_TUTOR);
		$this->pageTitle = 'Wiki Administration';
        if (empty($this->data)){

        	$data = $this->Article->findAll('approvedBy=0 OR editedBy>0', null, 'modified DESC');
        	//debug(sizeof($data));exit;
        	
            for($i=0; $i<sizeof($data); $i++){
                $new = ($data[$i]['Article']['approvedBy']==0);
                $pid = ($new)? 'player_id' : 'editedBy';
                
            	$nickname = $this->Player->findById($data[$i]['Article'][$pid]);//the author who has submitted/edited the article
            	//debug($nickname);exit;
            	$data[$i]['Article']['nick'] = $nickname['Player']['nick'];
            }
            if (!empty($data)){
                $this->set('data',$data);
                $this->set('topics', $this->Topic->find('list'));
            } else {
                $this->Session-setFlash('There are currently no articles for revision.');
                $this->redirect('/admin');
                exit;
            }

        } else {
            if (!$this->Article->save($this->data)){
                $this->Session->setFlash('There was an error saving the article.');
            } else {
                $this->Session->setFlash('The article was saved.');
            }
            unset($this->data);
            $this->redirect('approvals');
            exit;
        }
    }
	
    /**
     * This function approves an article and awards score to the player
     * It is called with POST-data from admin_approvals
     * The score is awarded to the editing player
     * @access public requires tutor rights
     */
    function admin_approve(){
       
       if (!empty($this->data)){ 
       	  $this->__requireRole(ROLE_TUTOR);
       	  $isNew = $this->data['Article']['isNew'];
       	  unset($this->data['Article']['isNew']);
          $nickAuthor = $this->data['Article']['nick'];        
          $nickTutor = $this->Session->read('Player.nick');
          unset($this->data['Article']['nick']);
          
          $data = $this->Article->findById($this->data['Article']['id']);
          if($isNew){
          	$author = $data['Article']['player_id'];//fresh, unapproved article
          	$score = PS_WIKI_ARTICLE;
          } else {
          	$author = $data['Article']['editedBy'];//edited, "dirty" article
          	$score = PS_WIKI_EDIT;
          }
          $data['Article']['topic_id'] = $data['Article']['edit_topic_id'];
          $data['Article']['edit_topic_id'] = 1;
          $data['Article']['title'] = $data['Article']['edit_title'];
          $data['Article']['edit_title'] = '';
          $data['Article']['text'] = $data['Article']['edit_text'];
          $data['Article']['edit_text'] = '';
          $data['Article']['approvedBy'] = $this->Session->read('Player.id');
          $data['Article']['editedBy'] = 0;
          $data['Article']['remark'] = '';
          $data['Article']['score_awarded'] = $score;
          
          // award score:
          if (!$this->Player->awardScore($author, $score)){
              $this->Session->setFlash('There was an error awarding the score.');
          }
          
          if (!$this->Article->save($data)){
              $this->Session->setFlash('There was an error saving the approval.');
          } else {
              $this->Session->setFlash('The approval was saved.<br />'.$score.' score awarded to <i>'.$nickAuthor.' by ' .$nickTutor . '</i>.');
          }
          
          unset($this->data);
          $this->redirect('index');
          exit;
       } else {
          $this->Session->setFlash('invalid function call');
          $this->redirect('/admin');
          exit;
       }
    }
    
    /**
     * This function toggles the field "approvedBy" to 0 or tutorId.
     * If 0, The article cannot be displayed in the PDA
     * @access public requires tutor rights
     * @param int $id the article id to (dis)approve
     * @param boolean $isEnabled if true the id of currently logged in tutor is set for approvedBy
     */
    function admin_setApproved($id=null, $isEnabled=true){
       $isEnabled = ($isEnabled)? $this->Session->read('Player.id') : 0;
       $data = $this->Article->read(null, $id);
       if (!$id || empty($data)){
          $this->Session->setFlash('The article could not be found.');
       } else {
          $this->Article->id = $id;
          $this->Article->saveField('approvedBy', $isEnabled);
          $statusText = ($isEnabled)? ' enabled.' : ' disabled.';
          $this->Session->setFlash('The article has been'.$statusText);
       }
       $this->redirect('index');
       exit;
    }
    
 	/**
     * this is called with POST-data from admin_approvals
     * Saves the remark
     * @access public requires tutor rights
     */
    function admin_saveRemark(){
        
    	$this->__requireRole(ROLE_TUTOR);
    	$remark = $this->data['Article']['remark'];
    	$data = $this->Article->findById($this->data['Article']['id']);
    	
    	unset($this->data['Article']['remark']);
    	$data['Article']['remark'] = $remark;
        //debug($data);exit;
        if (!$this->Article->save($data)){
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