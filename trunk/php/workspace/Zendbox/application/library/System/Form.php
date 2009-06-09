<?php
	class System_Form extends Zend_Form {
		public function __construct($options = array()) {
			parent::__construct($options);
			
			$root = Zend_Registry::get('root');
			$subtitles = new Zend_Config_Xml($root.'/application/configs/lang-br.xml');
			
			$translator = new Zend_Translate_Adapter_Array($subtitles->toArray());
			$this->setTranslator($translator);
		}
	}
