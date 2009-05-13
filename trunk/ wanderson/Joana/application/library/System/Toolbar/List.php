<?php
	/**
	 * @category System
	 * @package  System_Toolbar
	 */
	class System_Toolbar_List extends System_Toolbar_Abstract {
		/**
		 * 
		 * @param array $buttons[optional]
		 */
		public function __construct($buttons = array()) {
			$this
			->addButtons($buttons)
			->setExternalTag('ul')
			->setInternalTag('li');
		}
		
		public function __toString() {
			$html = "";
			foreach($this->getButtons() as $button) {
				$toolbar = (string) $button->getToolbar(); 
				$html   .= "<{$this->getInternalTag()}>$button{$toolbar}</{$this->getInternalTag()}>";
			}
			$html = "<{$this->getExternalTag()} {$this->_getAttribsCode()}>$html</{$this->getExternalTag()}>";
			return $html;
		}
	}
