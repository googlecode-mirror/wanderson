<?php
	class System_Validate_Currency extends Zend_Validate_Abstract {
		const CURRENCY = 'notCurrency';
		protected $_messageTemplates = array(
			self::CURRENCY => "The value '%value%' is not a currency number."
		);
		
		public function isValid($value) {
			$this->_setValue($value);
			$pattern = '/^((0{1})|([1-9]{1}[0-9]*)),[0-9]{2}$/';
			if(!preg_match($pattern, $value)) {
				$this->_error();
				return false;
			}
			return true;
		}
	}
