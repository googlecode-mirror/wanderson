<?php
	class System_Filter_Md5 implements Zend_Filter_Interface {
		public function filter($value) {
			return md5($value);
		}
	}
