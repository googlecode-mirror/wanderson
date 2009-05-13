<?php
	/**
	 * @category System
	 * @package  System_Toolbar
	 */
	class System_Toolbar_Button_Text extends System_Toolbar_Button_Abstract {
		public function __construct($label) {
			$this
			->setLabel($label)
			->setName(strtolower($label))
			->_setTag('span');
		}
		public function __toString() {
			$html = "<{$this->getTag()}>{$this->getLabel()}</{$this->getTag()}>";
			return $html;
		}
	}
