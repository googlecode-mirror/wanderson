<?php
	class Modulo extends Zend_Db_Table_Abstract {
		protected $_name = 'modulo';
		protected $_primary = 'id';
		protected $_dependentTables = array('CursoModulo');
		protected $_referenceMap = array();
	}
