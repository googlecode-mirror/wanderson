<?php
	class System_Form_Element_Textarea extends Zend_Form_Element_Textarea {
		public function __construct($name) {
			parent::__construct($name);
			
			$this
			->setAttrib('cols', '60')
			->setAttrib('rows', '8');
		}
	}
