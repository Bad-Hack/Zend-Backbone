<?php
class Admin_StatusController extends Rest_Controller {
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::getAction()
	 */
	public function getAction() {
		$auth = new Zend_Session_Namespace ( 'Admin_Auth' );
		if ($auth->isLoggedIn) {
			$returnData ["isLoggedIn"] = true;
		} else {
			$returnData ["isLoggedIn"] = false;
		}
		$returnData['username'] = isset($auth->username) ? $auth->username : null;
		$returnData['name'] = isset($auth->username) ? $auth->username : null;
		return $this->_helper->json ( $returnData );
	}
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::postAction()
	 */
	public function postAction() {
		$this->_sendError("Low privileges to update the admin status");
	}
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::putAction()
	 */
	public function putAction() {
		$this->_sendError("Low privileges to update the admin status");
	}
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::deleteAction()
	 */
	public function deleteAction() {
		$this->_sendError("Low privileges to update the admin status");
	}
}
