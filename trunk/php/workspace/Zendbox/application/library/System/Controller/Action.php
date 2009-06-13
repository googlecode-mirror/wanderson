<?php
	class System_Controller_Action extends Zend_Controller_Action {
		public function init() {
			$baseUrl = $this->getRequest()->getBaseUrl();
			Zend_Registry::set('baseUrl', $baseUrl);
			$this->view->baseUrl = $baseUrl;
			
			$this->view
				->setEncoding('UTF-8')
				->doctype(Zend_View_Helper_Doctype::XHTML1_STRICT);
			$config = Zend_Registry::get('config');
			$this->view
				->headTitle($config->system->title);
			$this->view
				->headLink()->appendStylesheet($baseUrl.'/css/default.css');
		}
	}