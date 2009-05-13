<?php
	/**
	 * 
	 * @category System
	 * @package  System_Toolbar
	 */
	abstract class System_Toolbar_Button_Abstract extends System_Toolbar_Attrib_Abstract {
		protected $_toolbar = null;
		protected $_tag;
		protected $_label;
		
		/**
		 * 
		 * @return System_Toolbar_Button_Abstract
		 * @param System_Toolbar_Abstract $toolbar
		 */
		public function setToolbar($toolbar) {
			if(!is_a($toolbar, System_Toolbar_Abstract))
				if(!is_null($toolbar))
					throw new System_Toolbar_Button_Exception();
			$this->_toolbar = $toolbar;
			return $this;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Abstract
		 */
		public function getToolbar() {
			return $this->_toolbar;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Abstract
		 */
		public function removeToolbar() {
			$this->setToolbar(null);
			return $this;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Abstract
		 * @param string $tag
		 */
		protected function _setTag($tag) {
			$tag = (string) $tag;
			$this->_tag = $tag;
			return $this;
		}
		
		/**
		 * 
		 * @return string
		 */
		public function getTag() {
			return $this->_tag;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Abstract
		 * @param string $label
		 */
		public function setLabel($label) {
			$label = (string) $label;
			$this->_label = $label;
			return $this;
		}
		
		/**
		 * 
		 * @return string
		 */
		public function getLabel() {
			return $this->_label;
		}
	}
