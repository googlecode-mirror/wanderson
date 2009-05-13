<?php
	class System_Form_Element_ForeignKey extends Zend_Form_Element_Select {
		public function __construct($name) {
			parent::__construct($name);
			$this
			/* Filtros */
			->addFilter(new Zend_Filter_Digits())
			/* Validações */
			->addValidator(new Zend_Validate_GreaterThan(-1))
			->addValidator(new Zend_Validate_Digits());
		}
		public function setMultiOptionsFromRowset($rowset, $column) {
			/* Exceções */
			if(!is_a($rowset, 'Zend_Db_Table_Rowset'))
				throw new System_Exception();
			if(!is_string($column))
				throw new System_Exception();
			/* Valores */
			$primary = $rowset->getTable()->info(Zend_Db_Table::PRIMARY);
			$id = array_pop($primary);
			$values = array();
			foreach($rowset as $row)
				$values[$row->$id] = $row->$column;
			$this->setMultiOptions($values);
		}
	}
