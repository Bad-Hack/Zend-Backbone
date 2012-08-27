<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap{
	
	protected function _initRestRoutes() {
		$this->bootstrap ( 'FrontController' );
		$frontController = Zend_Controller_Front::getInstance ();
		$restRoute = new Zend_Rest_Route ( $frontController, array (), array (
				'admin' => array('rest','status','login')
		) );
		$frontController->getRouter ()->addRoute ( 'adminrestroute', $restRoute );
	}
}

