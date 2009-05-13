<?php
	class Row_Identity extends Zend_Db_Table_Row_Abstract {
		public function init() {
			$this->_data['role'] = $this->findParentRow('Role');
		}
	}
