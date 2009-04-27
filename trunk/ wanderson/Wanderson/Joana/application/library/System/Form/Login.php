<?php
	class System_Form_Login extends System_Form {
		public function __construct($options = null) {
			parent::__construct($options);
			
			/* Elementos */
			$username = new Zend_Form_Element_Text('username');
			$username
			->setLabel('Usuário')
			->setRequired(true)
			->setAttrib('class', 'text')
			->addFilter(new Zend_Filter_StripTags())
			->addFilter(new Zend_Filter_StringToLower())
			->removeDecorator('Errors');
			
			$password = new Zend_Form_Element_Password('password');
			$password
			->setLabel('Senha')
			->setRequired(true)
			->setAttrib('class', 'text')
			->setRenderPassword(false)
			->addValidator(new Zend_Validate_NotEmpty())
			->addFilter(new Zend_Filter_StripTags())
			->addFilter(new System_Filter_Md5());
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit
			->setLabel('Login')
			->setAttrib('class', 'button');
			
			/* Adicionar Elementos */
			$this->addElements(array($username,$password,$submit));
		}
	}
