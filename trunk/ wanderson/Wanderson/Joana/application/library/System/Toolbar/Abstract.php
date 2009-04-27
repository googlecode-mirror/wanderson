<?php
	/**
	 * 
	 * @category System
	 * @package  System_Toolbar
	 */
	abstract class System_Toolbar_Abstract extends System_Toolbar_Attrib_Abstract {
		protected $_external;
		protected $_internal;
		protected $_buttons = array();
		
		/**
		 * 
		 * @return System_Toolbar_Abstract
		 * @param string $tag
		 */
		public function setExternalTag($tag) {
			$this->_external = (string) $tag;
			return $this;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Abstract
		 * @param string $tag
		 */
		public function setInternalTag($tag) {
			$this->_internal = (string) $tag;
			return $this;
		}
		
		/**
		 * 
		 * @return string
		 */
		public function getExternalTag() {
			return $this->_external;
		}
		
		/**
		 * 
		 * @return string
		 */
		public function getInternalTag() {
			return $this->_internal;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Abstract
		 * @param System_Toolbar_Button_Abstract $button
		 */
		public function addButton($button) {
			if(!is_a($button, System_Toolbar_Button_Abstract))
				throw new System_Toolbar_Exception();
			$this->_buttons[$button->getName()] = $button;
			return $this;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Abstract
		 * @param array $buttons
		 */
		public function addButtons(array $buttons) {
			foreach($buttons as $button)
				$this->addButton($button);
			return $this;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Abstract
		 */
		public function clearButtons() {
			$this->_buttons = array();
			return $this;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Abstract
		 * @param array $buttons
		 */
		public function setButtons(array $buttons) {
			$this->clearButtons()->addButtons($buttons);
			return $this;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Abstract
		 * @param string $name
		 */
		public function getButton($name) {
			$name = (string) $name;
			return $this->_buttons[$name];
		}
		
		/**
		 * 
		 * @return array
		 */
		public function getButtons() {
			return $this->_buttons;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Abstract
		 * @param string $name
		 */
		public function __get($name) {
			return $this->getButton($name);
		}
		
		/**
		 * 
		 * @return void
		 * @param string $name
		 * @param System_Toolbar_Button_Abstract $value
		 */
		public function __set($name, $value) {
			throw new System_Toolbar_Exception();
		}
	}
