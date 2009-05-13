<?php
	class Resource extends Zend_Db_Table_Abstract {
		protected $_name = 'resource';
		protected $_primary = 'id';
		protected $_dependentTables = array('Permission');
		protected $_referenceMap = array();
	}
