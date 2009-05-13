<?php
	/**
	 * 
	 * @category System
	 * @package  System_Toolbar
	 */
	class System_Toolbar_Button_Image extends System_Toolbar_Button_Href {
		protected $_src;
		
		/**
		 * 
		 * @param string $name
		 * @param string $label
		 * @param string $src
		 * @param string $href[optional]
		 * @param System_Toolbar_Abstract $toolbar[optional]
		 */
		public function __construct($name, $label, $src, $href = null, $toolbar = null) {
			$this
			->setSrc($src)
			->setHref($href)
			->setTitle($label)
			->setToolbar($toolbar)
			->_setTag('a')
			->setName($name);
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Image
		 * @param string $src
		 */
		public function setSrc($src) {
			$this->_src = (string) $src;
			return $this;
		}
		
		/**
		 * 
		 * @return string
		 */
		public function getSrc() {
			return $this->_src;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Button_Image
		 * @param string $name
		 * @param string $value
		 */
		public function setAttrib($name, $value) {
			$denied = array('src');
			if(array_search($name, $denied) === false)
				throw new System_Toolbar_Attrib_Exception();
			return parent::setAttrib($name, $value);
		}
		
		/**
		 * 
		 * @return string
		 */
		public function _getAttribsCode() {
			$attribs = parent::_getAttribsCode();
			return $attribs;
		}
		
		public function __toString() {
			$image = "<img src=\"{$this->getSrc()}\"/>";
			$href  = "<{$this->getTag()} {$this->_getAttribsCode()}>$image</{$this->getTag()}>";
			return $href;
		}
	}
