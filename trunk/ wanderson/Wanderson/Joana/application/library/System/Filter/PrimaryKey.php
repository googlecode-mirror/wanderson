<?php
	class System_Filter_PrimaryKey implements Zend_Filter_Interface {
		public function filter($value) {
			$filter = new Zend_Filter();
			$filter
			->addFilter(new Zend_Filter_Digits())
			->addFilter(new Zend_Filter_Int());
			return $filter->filter($value);
		}
	}