<?php

use Doctrine\ORM\EntityManager, Doctrine\ORM\Configuration;
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	protected $modulesDirName = "";
	protected function _initDoctrine() {
		$returnEm = "";
		try {
			$returnEm = Zend_Registry::get ( "returnEm" );
		} catch ( Exception $ex ) {
			$returnEm = "default";
		}
		
		$config = new Configuration ();
		
		switch (APPLICATION_ENV) {
			case 'staging' :
				$cache = new \Doctrine\Common\Cache\ApcCache ();
				break;
			
			// Both development and test environments will use array cache.
			default :
				$cache = new \Doctrine\Common\Cache\ArrayCache ();
				break;
		}
		
		$config->setMetadataCacheImpl ( $cache );
		
		// get Configure Models path according to the modules availabel
		$modelDirs = array (
				APPLICATION_PATH . '/models' 
		);
		$modulesDir = $this->_getModuleList ();
		if (! empty ( $modulesDir )) {
			$modelDirs = array ();
			foreach ( $modulesDir as $moduleDir ) {
				$modelDirs [] = $this->modulesDirName . "/" . $moduleDir . '/models';
			}
		}
		
		$driverImpl = $config->newDefaultAnnotationDriver ( $modelDirs );
		$config->setMetadataDriverImpl ( $driverImpl );
		
		$config->setQueryCacheImpl ( $cache );
		$config->setProxyDir ( APPLICATION_PATH . '/doctrineModelProxies' );
		$config->setProxyNamespace ( 'appstart\Proxies' );
		
		$options = $this->getOption ( 'doctrine' );
		$em = array ();
		foreach ( $options as $key => $val ) {
			$config->setAutoGenerateProxyClasses ( $val ['auto_generate_proxy_class'] );
			
			$em [$key] = EntityManager::create ( $val ['db'], $config );
			
			Zend_Registry::set ( 'EntityManager_' . $key, $em [$key] );
		}
		
		return isset ( $em [$returnEm] ) ? $em [$returnEm] : $em ["default"];
	}
	protected function _getModuleList() {
		$this->bootstrap ( 'FrontController' );
		$resources = $this->getOption ( 'resources' );
		if (empty ( $resources ) || $resources == null || ! isset ( $resources ["frontController"] ) || ! isset ( $resources ["frontController"] ['moduleDirectory'] )) {
			return array ();
		}
		$this->modulesDirName = $resources ["frontController"] ['moduleDirectory'];
		$modules = scandir ( $resources ["frontController"] ['moduleDirectory'] );
		array_shift ( $modules );
		array_shift ( $modules );
		return $modules;
	}
	protected function _initRestRoutes() {
		$this->bootstrap ( 'FrontController' );
		$frontController = Zend_Controller_Front::getInstance ();
		$restRoute = new Zend_Rest_Route ( $frontController, array (), array (
				'admin' => array('rest')
		) );
		$frontController->getRouter ()->addRoute ( 'adminrestroute', $restRoute );
	}
}