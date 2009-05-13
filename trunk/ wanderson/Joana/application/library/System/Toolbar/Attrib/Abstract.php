<?php
	/**
	 * 
	 * @category System
	 * @package  System_Toolbar
	 */
	abstract class System_Toolbar_Attrib_Abstract {
		/**
		 * @var array $_attribs
		 */
		protected $_attribs = array();
		
		/**
		 * @var string $_id
		 */
		protected $_id;
		
		/**
		 * 
		 * @return System_Toolbar_Attrib_Abstract
		 * @param  string $name
		 * @param  string $value
		 */
		public function setAttrib($name, $value) {
			$denied = array('id');
			if(array_search($name, $denied) !== false)
				throw new System_Toolbar_Attrib_Exception();
			$name = (string) $name;
			$this->_attribs[$name] = $value;
			return $this;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Attrib_Abstract
		 * @param  array $attribs
		 */
		public function setAttribs(array $attribs) {
			foreach($attribs as $name => $value)
				$this->setAttrib($name, $value);
			return $this;
		}
		
		/**
		 * 
		 * @return string
		 * @param  string $name
		 */
		public function getAttrib($name) {
			$name  = (string) $name;
			$value = isset($this->_attribs[$name]) ? $this->_attribs[$name] : "";
			return $value;
		}
		
		/**
		 * 
		 * @return array
		 */
		public function getAttribs() {
			return $this->_attribs;
		}
		
		/**
		 * 
		 * @return System_Toolbar_Attrib_Abstract
		 * @param  string $name
		 */
		public function setName($name) {
			$name = (string) $name;
			$this->_id = strtolower($name);
			return $this;
		}
		
		/**
		 * 
		 * @return string
		 */
		public function getName() {
			return $this->_id;
		}
		
		/**
		 * 
		 * @return string
		 */
		protected function _getAttribsCode() {
			$attribs = "";
			$id = $this->getName();
			if(!empty($id))
				$attribs = "id=\"$id\"";
			foreach($this->getAttribs() as $name => $value)
				$attribs .= " $name=\"$value\"";
			$attribs = trim($attribs);
			return $attribs;
		}
		
		/**
		 * 
		 * @return string
		 */
		abstract function __toString();
	}
