<?php
	class System_Form_Profile extends System_Form {
		public function __construct($options = null) {
			parent::__construct($options);
			
			$username = new Zend_Form_Element_Text('username');
			$username
			->setLabel('Nome do Usuário')
			->setAttrib('class', 'text')
			->setAttrib('disabled', 'disabled');
			
			$password = new Zend_Form_Element_Password('password');
			$password
			->setLabel('Nova Senha')
			->setAttrib('class', 'text')
			->setRequired(false)
			->addFilter(new Zend_Filter_StripTags())
			->addFilter(new System_Filter_Md5());
			
			$role = new Zend_Form_Element_Text('role');
			$role
			->setLabel('Grupo do Usuário')
			->setAttrib('class', 'text')
			->setAttrib('disabled', 'disabled');
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit
			->setAttrib('class', 'button')
			->setLabel('Gravar');
			
			$this->addElements(array($id, $username, $password, $role, $submit));
		}
		
		public function getValues() {
			$data = parent::getValues();
			unset($data['username']);
			return $data;
		}
	}
