<?php
	class System_Form_User extends System_Form {
		public function __construct($options = null) {
			parent::__construct($options);
			
			/* Elementos */
			$id = new System_Form_Element_PrimaryKey('id');
			
			$username = new Zend_Form_Element_Text('username');
			$username
			->setLabel('Nome do Usuário')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Alpha(false), true)
			->addValidator(new Zend_Validate_StringLength(1,20))
			->addFilter(new Zend_Filter_StripTags())
			->addFilter(new Zend_Filter_StringTrim())
			->addFilter(new Zend_Filter_StringToLower());
			
			$password = new Zend_Form_Element_Password('password');
			$password
			->setLabel('Nova Senha')
			->setAttrib('class', 'text')
			->setRequired(false)
			->addFilter(new Zend_Filter_StripTags())
			->addFilter(new System_Filter_Md5());
			
			$allowed = new Zend_Form_Element_Checkbox('allowed');
			$allowed
			->setLabel('Habilitado')
			->setAttrib('class', 'checkbox')
			->setRequired(false)
			->addFilter(new System_Filter_Checkbox());
			
			$fkrole = new System_Form_Element_ForeignKey('fkrole');
			$table = new Role();
			$rowset = $table->fetchAll(null, 'name ASC');
			$fkrole
			->setLabel('Grupo de Usuários')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->setMultiOptionsFromRowset($rowset, 'name');
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit
			->setAttrib('class', 'button')
			->setLabel('Gravar');
			
			$this->addElements(array($id, $username, $password, $allowed, $fkrole, $submit));
		}
	}
