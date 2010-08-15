<?php
/**
 * This controller contains the authoring and admin actions
 * 1. action for authoring index view (adding new content for players, authors and tutors).
 * 2. action for admin index (overview for tutor and author)
 *
 * Contains an overview of functions that a player can use to add content
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class AuthoringController extends AppController
{
    /**
    * class name variable
    * @var string
    */
    var $name = 'Authoring';

    /**
    * Array of Strings; which models are used by this controller?
    * @var mixed
    */
    var $uses = array('Article','Assessment','AdventureQuestion');
    
    /**
    * Array of Strings; which helpers are used by this controller?
    * @var array
    */
    var $helpers = array('Html','Form','Javascript','Ajax');
    
    /**
    * admin_index is the default function when /authoring/index is called.
    * no controller action, just render the view
    * @access public requires login
    * @see /app/views/authoring/index.ctp
    */
    function index()
    {
//       Configure::write('debug', 2); //2 means show SQL debugging messages
        $this->__requireLogin();
        $pid = $this->Session->read('Player.id');
        $articles = $this->Article->find('all',
            array(
               'conditions'=>'Article.editedBy='.$pid,
               'fields'=>array('id','remark','title'),
               'order'=>'modified DESC'
            )
        );
        $articles = (empty($articles))? array() : Set::extract($articles, '{n}.Article');
        
        $assessments = $this->Assessment->find('all',
            array(
               'conditions'=>'Assessment.player_id='.$pid.' AND Assessment.approvedBy=0',
               'fields'=>array('id','remark','text'),
               'order'=>'modified DESC'
            )
        );
        $assessments = (empty($assessments))? array() : Set::extract($assessments, '{n}.Assessment');
        
        $questions = $this->AdventureQuestion->find('all',
            array(
               'conditions'=>array('player_id='.$pid, 'approvedBy'=>0),
               'fields'=>array('id','remark','text'),
               'order'=>'modified DESC'
            )
        );
        
        $questions = (empty($questions))? array() : Set::extract($questions, '{n}.AdventureQuestion');
        //$questions = array();
        
        $this->set('articles', $articles);
        $this->set('assessments', $assessments);
        $this->set('questions', $questions);
        $this->render();
    }
    
    /**
    * administration is the default function when /admin or /admin/index is called.
    * For this there are also two routes in app/config/routes.php
    * @access public requires author rights
    * @see /app/views/authoring/administration.ctp
    */
    function administration()
    {
        $this->__requireRole(ROLE_AUTHOR);
        $this->set('role',$this->Session->read('Player.role'));
    }
    
}
?>