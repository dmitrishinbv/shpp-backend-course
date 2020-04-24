<?php
// this class used for connecting templates and transferring data to views
Class Template {
	private $controller;
	private $layouts;
	private $vars = [];
	
	function __construct($layouts, $controllerName) {
	    $this->layouts = $layouts;
		$arr = explode('_', $controllerName);
		$this->controller = strtolower($arr[1]);
	}
	
	// setting variables to views
	function vars($varname, $value) {
		if (isset($this->vars[$varname]) == true) {
			trigger_error ('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.', E_USER_NOTICE);
			return false;
		}
		$this->vars[$varname] = $value;
		return true;
	}
	
	// get the file path to view and include it
	function view($name) {
		$pathLayout = SITE_PATH . 'views/layouts/' .$this->layouts . '.php';
		$contentPage = SITE_PATH . 'views/' . $this->controller . '/' . $name . '.php';

		if (file_exists($pathLayout) == false) {
			trigger_error ('Layout `' . $this->layouts . '` does not exist.', E_USER_NOTICE);
			return false;
		}
		if (file_exists($contentPage) == false) {
			trigger_error ('Template `' . $name . '` does not exist.', E_USER_NOTICE);
			return false;
		}
		
		foreach ($this->vars as $key => $value) {
            $$key = $value;
		}

		include ($pathLayout);
		return true;
	}
	
}