<?php
	class System_Form_Role extends System_Form {
		public function __construct($options = null) {
			parent::__construct($options);
			
			/* Elementos */
			$id = new System_Form_Element_PrimaryKey('id');
			
			$name = new Zend_Form_Element_Text('name');
			$name
			->setLabel('Nome do Grupo')
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
			->addFilter(new Zend_Filter_StringToLower())
			->addFilter(new Zend_Filter_StringTrim());
			
			$table = new Role();
			$rowset = $table->fetchAll(null,'name ASC');
			$father = new System_Form_Element_ForeignKey('father');
			$father
			->setLabel('Grupo Pai')
			->setMultiOptionsFromRowset($rowset, 'name');
			
			$table = new Resource();
			$rowset = $table->fetchAll(null, 'name ASC');
			$resources = new System_Form_Element_ManyToMany('resources');
			$resources
			->setLabel('Permissões Locais')
			->setMultiOptionsFromRowset($rowset, 'name');
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit
			->setAttrib('class', 'button')
			->setLabel('Gravar');
			
			$this->addElements(array($id, $name, $value, $father, $resources, $submit));
		}
	}
