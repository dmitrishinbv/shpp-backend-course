<?php
// абстрактый класс контроллера
Abstract Class Controller_Base {

	protected $template;
	protected $layouts; // шаблон
	
	public $vars = array();

	// в конструкторе подключаем шаблоны
	function __construct() {
		$this->template = new Template($this->layouts, get_class($this));
	}

	abstract function index();
	
}
