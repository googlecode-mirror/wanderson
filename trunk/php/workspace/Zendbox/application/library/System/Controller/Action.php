<?php
	class System_Controller_Action extends Zend_Controller_Action {
		public function init() {
			$this->view
				->setEncoding('UTF-8')
				->doctype(Zend_View_Helper_Doctype::XHTML1_STRICT);
			$config = Zend_Registry::get('config');
			$this->view
				->headTitle($config->system->title);
		}
	}