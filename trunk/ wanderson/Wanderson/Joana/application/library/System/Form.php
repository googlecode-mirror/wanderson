<?php
	class System_Form extends Zend_Form {
		public function __construct($options = null) {
			parent::__construct($options);
			/* Zend Translate */
			$root = Zend_Registry::get('root');
			$translate = new Zend_Config_Xml($root.'/application/config/lang-pt_BR.xml');
			$this->setTranslator(new Zend_Translate_Adapter_Array($translate->toArray(), 'pt_BR'));
		}
	}
