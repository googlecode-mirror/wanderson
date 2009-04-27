<?php
	class Role extends Zend_Db_Table_Abstract {
		protected $_name = 'role';
		protected $_primary = 'id';
		protected $_dependentTables = array('Role','Identity','Permission');
		protected $_referenceMap = array(
			'Role' => array (
				'columns'       => 'father',
				'refTableClass' => 'Role',
				'refColumn'     => 'id'
			)
		);
	}
