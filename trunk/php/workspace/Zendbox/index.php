<?php
	/**
	 * Zendbox
	 * The Zend Framework's Sandbox
	 * @author Wanderson Henrique Camargo Rosa
	 */
	
	error_reporting(E_ALL|E_STRICT);
	ini_set('display_errors', true);
	
	$root   = dirname(__FILE__);
	$path   = array();
	$path[] = dirname($root).'/library';
	$path[] = $root.'/application/library';
	$path[] = $root.'/application/models';
	$path[] = get_include_path();
	
	$path = implode(PATH_SEPARATOR, $path);
	set_include_path($path);
	
	require_once 'Zend/Loader/Autoloader.php';
	
	try {
		$loader = Zend_Loader_Autoloader::getInstance();
		
		$front = Zend_Controller_Front::getInstance();
		$front
			->addModuleDirectory($root.'/application/modules')
			->throwExceptions(true);
		
		$front->dispatch();
	}
	catch(Exception $e) {
		header('Content-type: text/plain');
		echo $e;
	}
