<?php
	class System_Form_Login extends System_Form {
		public function __construct() {
			parent::__construct();
			
			$username = new Zend_Form_Element_Text('username');
			$username
				->setLabel('Usuário');
			
			$elements = array(
				$username
			);
			
			$this
				->addElements($elements);
		}
	}
