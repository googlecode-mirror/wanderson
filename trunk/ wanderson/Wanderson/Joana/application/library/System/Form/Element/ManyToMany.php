<?php
	class System_Form_Element_ManyToMany extends Zend_Form_Element_MultiCheckbox {
		public function __construct($name) {
			parent::__construct($name);
			$this
			->setAttrib('class', 'checkbox');
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
			if(is_null($rowset->current())) {
				$values[0] = 'Valores Indisponíveis';
				$this->setAttrib('disabled', 'disabled');
			}
			foreach($rowset as $row)
				$values[$row->$id] = $row->$column;
			$this->setMultiOptions($values);
		}
	}
