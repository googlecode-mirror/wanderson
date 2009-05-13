<?php
	class Permission extends Zend_Db_Table_Abstract {
		protected $_name = 'permission';
		protected $_primary = 'id';
		protected $_dependentTables = array();
		protected $_referenceMap = array(
			'Role' => array(
				'columns'       => 'fkrole',
				'refTableClass' => 'Role',
				'refColumns'    => 'id'
			),
			'Resource' => array(
				'columns'       => 'fkresource',
				'refTableClass' => 'Resource',
				'refColumns'    => 'id'
			)
		);
	}
