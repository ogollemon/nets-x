<?php
/**
 * This controller contains the CRUD functions to administer the game topology hosts.
 * @category   Controller
 * @author     Thomas Geimer <thomas.geimer@googlemail.com>
 * @copyright  2008 the NetS-X team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GPL v3
 * @version    Release: 1.0
 * @since      Class available since Release 0.1 (alpha)
 */
class HostsController extends AppController {

    /**
    * class name variable
    * @var string
    */
	var $name = 'Hosts';
	
	/**
    * helpers array
    * @var mixed
    */
	var $helpers = array('Html', 'Form');

	/**
	 * This action renders the paginated overview of all hosts 
	 * @access public requires tutor rights
	 */
	function admin_index() {
	    $this->__requireRole(ROLE_TUTOR);
		$this->Host->recursive = 0;
		$this->set('hosts', $this->paginate());
	}

	/**
	 * This action shows the host with given ID
	 * @access public requires tutor rights
	 * @param int $id the host id to show
	 */
	function admin_view($id = null) {
	    $this->__requireRole(ROLE_TUTOR);
		if (!$id) {
			$this->Session->setFlash(__('Invalid Host.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('host', $this->Host->read(null, $id));
	}

	/**
	 * This function renders an add view and enters a new host into the DB.
	 * @access public requires tutor rights
	 */
	function admin_add() {
	    $this->__requireRole(ROLE_TUTOR);
		if (!empty($this->data)) {
			$this->Host->create();
			if ($this->Host->save($this->data)) {
				$this->Session->setFlash(__('The Host has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Host could not be saved. Please, try again.', true));
			}
		}
	}

	/**
	 * This action is used to edit the host with the provided ID
	 * @access public requires tutor rights
	 * @param int $id identifies the host
	 */
	function admin_edit($id = null) {
	    $this->__requireRole(ROLE_TUTOR);
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Host', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Host->save($this->data)) {
				$this->Session->setFlash(__('The Host has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Host could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Host->read(null, $id);
		}
	}

	/**
	 * This function is used to delete a host from the DB.
	 * @access public requires tutor rights
	 * @param unknown_type $id
	 */
	function admin_delete($id = null) {
	    $this->__requireRole(ROLE_TUTOR);
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Host', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Host->del($id)) {
			$this->Session->setFlash(__('Host deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>