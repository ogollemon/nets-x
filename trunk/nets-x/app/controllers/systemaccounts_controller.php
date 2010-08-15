<?php
/**
 * This controller handles all operations concerning systemaccounts used in scenarios.
 * It contains the CRUD administration functions for tutors to add/edit/remove a precompiled systemaccount for the use in scenarios.
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class SystemaccountsController extends AppController {
   
    /**
     * The class name
     * @var String
     */
	var $name = 'Systemaccounts';
	
	/**
     * Array of Helper names used by this controller´s view
     * @var Array
     */
	var $helpers = array('Html', 'Form');

	/**
	 * This function renders an overview over the systemaccounts
	 * @access public requires tutor rights
	 */
	function admin_index() {
	   $this->__requireRole(ROLE_TUTOR);
	   $this->Systemaccount->recursive = 0;
	   $this->set('systemaccounts', $this->paginate());
	}

	/**
	 * This renders a view to add a new systemaccount.
	 * @access public requires tutor rights
	 */
	function admin_add() {
       $this->__requireRole(ROLE_TUTOR);
       if (!empty($this->data)) {
         $this->data['Systemaccount']['passwd'] = md5($this->data['Systemaccount']['passwd_clear']);
       	 $this->Systemaccount->create();
       	 if ($this->Systemaccount->save($this->data)) {
       		$this->Session->setFlash(__('The Systemaccount has been saved', true));
       		$this->redirect(array('action'=>'index'));
       	 } else {
       	    $this->Session->setFlash(__('The Systemaccount could not be saved. Please, try again.', true));
         }
       }
	}

	/**
     * This renders a view to edit a systemaccount with provided id.
     * @access public requires tutor rights
     * @param int $id identifies the systemaccount to edit
     */
	function admin_edit($id = null) {
	    $this->__requireRole(ROLE_TUTOR);
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Systemaccount', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
		    $this->data['Systemaccount']['passwd'] = md5($this->data['Systemaccount']['passwd_clear']);
			if ($this->Systemaccount->save($this->data)) {
				$this->Session->setFlash(__('The Systemaccount has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Systemaccount could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Systemaccount->read(null, $id);
		}
	}

	/**
	 * This function removes a systemaccount from the DB
	 * @access public requires tutor rights
	 * @param int $id 
	 */
	function admin_delete($id = null) {
	    $this->__requireRole(ROLE_TUTOR);
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Systemaccount', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Systemaccount->del($id)) {
			$this->Session->setFlash(__('Systemaccount deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>