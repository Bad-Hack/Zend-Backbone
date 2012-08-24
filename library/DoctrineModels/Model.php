<?php

abstract class DoctrineModels_Model {
	protected $_em;
	protected $_class_vars;
	protected $_reflection_properties;
	protected $_em_class = "default";
	
	public function __construct(array $options = null) {
		$this->_em = Zend_Registry::get ( 'EntityManager_'.$this->_em_class );
		
		$this->_setClassVars();
		
		if (is_array ( $options )) {
			$this->setOptions ( $options );
		}
	}
	
	final private function _setClassVars()
	{
		$reflection = new ReflectionClass($this);
		$vars = $reflection->getProperties();
		foreach($vars as $reflectionProperty)
		{
			$reflectionProperty->setAccessible(true);
			$this->_reflection_properties[$reflectionProperty->getName()]=$reflectionProperty;
			$this->_class_vars[] = $reflectionProperty->getName();
		}
	}
	
	final public function __set($name, $value) {
		$method = 'set' . ucwords($name);
		if (('mapper' == $name)) {
			throw new Exception ( 'Invalid User property ' . $name );
		}
		$this->$method ( $value );
	}
	
	final public function __get($name) {
		$method = 'get' . ucwords($name);
		if (('mapper' == $name)) {
			throw new Exception ( 'Invalid User property ' . $name );
		}
		return $this->$method ();
	}
	
	final public function setOptions(array $options) {
		foreach ( $options as $key => $value ) {
			$method = 'set' . ucwords ($key) ;
			$this->$method ( $value );
		}
		return $this;
	}
	
	final public function __call($method, $arguments) {
		// Automatic Set and Get Methods
		$type = substr ( $method, 0, 3 );
		$classMethod = substr ( $method, 3 );
		$variableName = $this->_createVariable ( $classMethod );
		
		if (in_array ( $variableName, $this->_class_vars )) {
			if ($type == "get") {
				return $this->_reflection_properties[$variableName]->getValue($this);
			} elseif ($type == "set") {
				if (isset ( $arguments [0] )) {
					$this->_reflection_properties[$variableName]->setValue($this,$arguments[0]);
					return $this;
				} else {
					$this->_reflection_properties[$variableName]->setValue($this,"");
					return $this;
				}
			} else {
				throw new Zend_Exception ( 'Invalid Method: ' . $method . '()' );
			}
		}
		else
		{
			throw new Zend_Exception ( 'Invalid Property: ' . $variableName );
		}
	}
	
	private function _createVariable($method) {
		
		/*$isInitialLetter = true;
		for($i = 0; $i < strlen ( $method ); $i ++) {
			if ($method [$i] == strtoupper ( $method [$i] ) && ! $isInitialLetter) {
				$string .= "_" . strtolower ( $method [$i] );
			} else {
				if ($isInitialLetter) {
					$string .= strtolower ( $method [$i] );
					$isInitialLetter = false;
				} else {
					$string .= $method [$i];
				}
			}
		}*/
		$method[0] = strtolower($method[0]);
		
		return $method;
	}
	
	final public function toArray() {
		$columns = array_keys ( get_class_vars ( get_class ( $this ) ) );
		$modelArray = array ();
		foreach ( $columns as $column ) {
			$getMethod = 'get' . str_replace ( " ", "", ucwords ( str_replace ( "_", " ", $column ) ) );
			$modelArray [$column] = $this->$getMethod ();
		}
		return $modelArray;
	}
}