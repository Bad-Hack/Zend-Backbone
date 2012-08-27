<?php
class Admin_LoginController extends Rest_Controller {
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::getAction()
	 */
	public function getAction() {
		$this->_sendError("Low privileges to update the admin status");
	}
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::postAction()
	 */
	public function postAction() {
		$data = $this->_request->getParams();
		// @todo apply the login procedure here
		if($data["username"]=="admin" && $data["password"]=="admin") {
			$auth = new Zend_Session_Namespace('Admin_Auth');
			$auth->username = "admin";
			$auth->password = "admin";
			$auth->isLoggedIn = true;
			$data = array(
					'success' => true,
					'failure' => false,
					'data'	=> array(
							'username' => $auth->username,
							'isLoggedIn' => true,
							'name'	=> 'Administrator'
					)
			);
		} else {
			$data = array(
					'success' => false,
					'failure' => true,
					'data'	=> array()
			);
		}
		$this->_sendData($data);
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
		$auth = new Zend_Session_Namespace('Admin_Auth');
		$auth->isLoggedIn = false;
		$auth->username = null;
		$auth->name = null;
		$data = array(
				'success' => true,
				'failure' => false,
				'data'	=> array(
						'isLoggedIn' => $auth->isLoggedIn,
					 	'username'	=>	$auth->username
				)
		);
		$this->_sendData($data);
	}
}
