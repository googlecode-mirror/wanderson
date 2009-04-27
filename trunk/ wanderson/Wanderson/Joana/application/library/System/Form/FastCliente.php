<?php
	class System_Form_FastCliente extends System_Form {
		public function __construct() {
			parent::__construct();
			
			$id = new System_Form_Element_PrimaryKey('id');
			
			$nome = new Zend_Form_Element_Text('nome');
			$nome
			->setLabel('Nome')
			->setAttrib('class', 'text')
			->setRequired(true)
			->addValidator(new Zend_Validate_NotEmpty(), true)
			->addValidator(new Zend_Validate_Alpha(true), true)
			->addValidator(new Zend_Validate_StringLength(1,40))
			->addFilter(new Zend_Filter_StringTrim());
			
			$email = new Zend_Form_Element_Text('email');
			$email
			->setLabel('E-mail')
			->setAttrib('class', 'text')
			->addFilter(new Zend_Filter_StringTrim())
			->addFilter(new Zend_Filter_StringToLower());
			
			$telefone = new Zend_Form_Element_Text('telefone');
			$telefone
			->setLabel('Telefone')
			->setAttrib('class', 'text')
			->addFilter(new Zend_Filter_StringTrim())
			->addFilter(new Zend_Filter_Digits());
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit
			->setLabel('Gravar')
			->setAttrib('class', 'button');
			
			$elements = array(
				$id,
				$nome,
				$email,
				$telefone,
				$submit
			);
			
			$this->addElements($elements);
		}
	}
