<?php
class Admin_RestController extends Zend_Rest_Controller {
	public function init() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender ( true );
	}
	
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		// return $this->_helper->json(array("Hello Dharmesh"));
		// TODO Auto-generated AdminRestController::indexAction() default action
	}
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::getAction()
	 */
	public function getAction() {
		$returnData = array();
		$auth = new Zend_Session_Namespace('Zend_Auth');
		if($auth->isLoggedIn){
				$returnData["isLoggedIn"] = true;
		} else {
			$returnData["isLoggedIn"] = false;
		}
		return $this->_helper->json($returnData);
	}
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::postAction()
	 */
	public function postAction() {
		return $this->_helper->json ( array (
				$this->_request->getParams () 
		) );
		// TODO Auto-generated method stub
	}
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::putAction()
	 */
	public function putAction() {
		return $this->_helper->json ( array (
				$this->_request->getParam ( 'id' ) 
		) );
		// TODO Auto-generated method stub
	}
	
	/*
	 * (non-PHPdoc) @see Zend_Rest_Controller::deleteAction()
	 */
	public function deleteAction() {
		// TODO Auto-generated method stub
	}
}
