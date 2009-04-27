<?php
	/**
	 * 
	 * @category System
	 * @package  System_Toolbar
	 */
	class System_Toolbar_Button_Href extends System_Toolbar_Button_Abstract {
		protected $_href;
		protected $_title;
		
		/**
		 * 
		 * @param string $name
		 * @param string $label
		 * @param string $href
		 * @param string $title[optional]
		 * @param System_Toolbar_Abstract $toolbar[optional]
		 */
		public function __construct($name, $label, $href, $title = null, $toolbar = null) {
			$this
			->setHref($href)
			->setTitle($title)
			->setLabel($label)
			->setToolbar($toolbar)
			->_setTag('a')
			->setName($name);
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Href
		 * @param string $href
		 */
		public function setHref($href) {
			$this->_href = (string) $href;
			return $this;
		}
		
		/**
		 * 
		 * @return string
		 */
		public function getHref() {
			return $this->_href;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Href
		 * @param string $title
		 */
		public function setTitle($title) {
			$this->_title = (string) $title;
			return $this;
		}
		
		/**
		 * 
		 * @return string
		 */
		public function getTitle() {
			return $this->_title;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Href
		 * @param string $name
		 * @param string $value
		 */
		public function setAttrib($name, $value) {
			$denied = array('href', 'title');
			if(array_search($name, $denied) === false)
				throw new System_Toolbar_Attrib_Exception();
			return parent::setAttrib($name, $value);
		}
		
		/**
		 * 
		 * @return string
		 */
		protected function _getAttribsCode() {
			$attribs = parent::_getAttribsCode();
			$attribs.= " href=\"{$this->getHref()}\"";
			$attribs.= " title=\"{$this->getTitle()}\"";
			$attribs = trim($attribs);
			return $attribs;
		}
		
		public function __toString() {
			$href = "<{$this->getTag()} {$this->_getAttribsCode()}>{$this->getLabel()}</{$this->getTag()}>";
			return $href;
		}
	}
