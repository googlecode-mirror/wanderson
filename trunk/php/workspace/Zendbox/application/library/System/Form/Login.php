<?php
	class System_Form_Login extends System_Form {
		public function __construct() {
			parent::__construct();
			
			$username = new Zend_Form_Element_Text('username');
			$username
				->setLabel('Usuário')
				->addValidator(new Zend_Validate_Alpha(false))
				->addFilter(new Zend_Filter_StringToLower());
			
			$password = new Zend_Form_Element_Password('password');
			$password
				->setRenderPassword(false)
				->setLabel('Senha');
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit
				->setLabel('Login');
			
			$elements = array(
				$username,
				$password,
				$submit
			);
			
			$this
				->addElements($elements);
		}
	}
