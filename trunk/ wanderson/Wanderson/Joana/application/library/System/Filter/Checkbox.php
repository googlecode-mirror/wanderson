<?php
	class System_Filter_Checkbox implements Zend_Filter_Interface {
		public function filter($value) {
			$value = (boolean) $value;
			$value = (int)     $value;
			return $value;
		}
	}
