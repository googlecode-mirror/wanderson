<?php
	class System_View extends Zend_View {
		public function __construct($config = array()) {
			parent::__construct($config);
			$front      = Zend_Controller_Front::getInstance();
			$module     = $front->getModuleDirectory();
			$controller = $front->getRequest()->getControllerName();
			$action     = $front->getRequest()->getActionName();
			$baseUrl    = $front->getRequest()->getBaseUrl();
			$path       = realpath("$module/views/scripts/$controller");
			$this->setScriptPath($path);
			$this->assign('baseUrl', $baseUrl);
		}
	}
