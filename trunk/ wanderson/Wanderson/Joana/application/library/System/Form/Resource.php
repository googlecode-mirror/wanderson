<?php
	class System_Form_Resource extends System_Form {
		public function __construct($options = null) {
			parent::__construct($options);
			
			/* Elementos */
			$id = new System_Form_Element_PrimaryKey('id');
			
			$name = new Zend_Form_Element_Text('name');
			$name
			->setLabel('Nome do Módulo')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Alpha(false), true)
			->addValidator(new Zend_Validate_StringLength(1,20))
			->addFilter(new Zend_Filter_StringTrim());
			
			$value = new Zend_Form_Element_Text('value');
			$value
			->setLabel('Identificador')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Alpha(false), true)
			->addValidator(new Zend_Validate_StringLength(1,10))
			->addFilter(new Zend_Filter_StringTrim())
			->addFilter(new Zend_Filter_StringToLower());
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit
			->setLabel('Gravar')
			->setAttrib('class', 'button');
			
			$this->addElements(array($id, $name, $value, $submit));
		}
	}
