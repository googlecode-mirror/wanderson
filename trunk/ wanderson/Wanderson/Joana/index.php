<?php
	/*
	 * Bootstrap
	 * Arquivo Inicializador do Joana
	 */
	
	/* Configuração do Path */
	$root = dirname(__FILE__);
	$path = array();
	$path[] = dirname($root).'/library/';    // Zend Framework Library
	$path[] = $root.'/application/library/'; // System Library
	$path[] = $root.'/application/models/';  // Models Directory
	set_include_path(implode(PATH_SEPARATOR, $path));
	ini_set('display_errors', 0);
	
	/* Zend Framework */
	require_once 'Zend/Loader.php';
	Zend_Loader::registerAutoload();
	try {
		/* Zend Config */
		$system = new Zend_Config_Xml($root.'/application/config/joana.xml', 'system');
		$database = new Zend_Config_Xml($root.'/application/config/joana.xml', 'database');
		ini_set('display_errors', $system->error->php);
		/* Zend Db */
		$adapter = Zend_Db::factory($database->adapter, $database->params->toArray());
		Zend_Db_Table::setDefaultAdapter($adapter);
		/* Zend Layout */
		Zend_Layout::startMvc()
		->setLayoutPath($root.'/application/layouts/');
		/* Zend Acl */
		$file = $root.'/application/config/joana.acl';
		System_Acl::setFile($file);
		$acl = System_Acl::getInstance();
		/* Zend Registry */
		Zend_Registry::set('acl', $acl);
		Zend_Registry::set('root', $root);
		Zend_Registry::set('config', $system);
		Zend_Registry::set('database', $database);
		/* Zend Controller Front */
		$front = Zend_Controller_Front::getInstance();
		$front
		->addModuleDirectory($root.'/application/modules/')
		->setModuleControllerDirectoryName('controllers')
		->throwExceptions($system->error->exception);
		/* Joana */
		$front->dispatch();
	}
	catch(Exception $e) {
		header("Content-type: text/plain");
		$system = new Zend_Config_Xml($root.'/application/config/joana.xml', 'system');
		if($system->error->internal)
			echo $e;
		else
			echo 'Erro Interno';
	}
