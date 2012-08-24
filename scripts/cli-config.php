<?php

// Define path to application directory
defined ( 'APPLICATION_PATH' ) || define ( 'APPLICATION_PATH', realpath ( dirname ( __FILE__ ) . '/../application' ) );

// Define application environment
defined ( 'APPLICATION_ENV' ) || define ( 'APPLICATION_ENV', (getenv ( 'APPLICATION_ENV' ) ? getenv ( 'APPLICATION_ENV' ) : 'development') );
// Ensure library/ is on include_path
set_include_path ( implode ( PATH_SEPARATOR, array (realpath ( APPLICATION_PATH . '/../library' ), get_include_path () ) ) );

/**
 * Zend_Application
 */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application ( APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini' );

// Check Param 1 for em_class
$class = "default";
if(strpos($argv[1],'em_class=')!==false){
	$class = str_replace("em_class=","",$argv[1]);
	// Backup 0st Param from command line
	$param0 = array_shift($_SERVER["argv"]);
	// Remove 1st Param from command line
	array_shift($_SERVER["argv"]);
	// Restore 0th Param from command line
	array_unshift($_SERVER["argv"],$param0);
}

// Doctrine and Symfony Classes
require_once 'Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPLICATION_PATH . '/../library');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', APPLICATION_PATH . '/../library/Doctrine');
$classLoader->register();

Zend_Registry::set("returnEm",$class);

$application->bootstrap ( 'doctrine' );

$em = Zend_Registry::get ( 'EntityManager_'.$class );

$helpers = array ('db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper ( $em->getConnection () ), 'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper ( $em ) );