<?php
	class Identity extends Zend_Db_Table_Abstract {
		protected $_name = 'identity';
		protected $_primary = 'id';
		protected $_dependentTables = array();
		protected $_referenceMap = array(
			'Role' => array(
				'columns'       => 'fkrole',
				'refTableClass' => 'Role',
				'refColumns'    => 'id'
			)
		);
	}
