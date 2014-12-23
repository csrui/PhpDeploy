<?php

class ClassAutoloader {
	public function __construct() {
		spl_autoload_register(array($this, 'loader'));
	}
	private function loader($className) {
		include __DIR__ . '/libs/' . $className . '.php';
	}
}

$autoloader = new ClassAutoloader();