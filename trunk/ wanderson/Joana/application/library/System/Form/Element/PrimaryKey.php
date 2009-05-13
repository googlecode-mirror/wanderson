<?php
	class System_Form_Element_PrimaryKey extends Zend_Form_Element_Hidden {
		public function __construct($name) {
			parent::__construct($name);
			$this
			->setValue(0)
			/* Filtros */
			->addFilter(new Zend_Filter_Digits())
			->addFilter(new Zend_Filter_Int())
			/* Validações */
			->addValidator(new Zend_Validate_GreaterThan(-1))
			->addValidator(new Zend_Validate_Digits());
		}
	}
