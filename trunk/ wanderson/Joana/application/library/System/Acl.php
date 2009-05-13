<?php
	/**
	 * System_Acl
	 * Permission Tree for Users in Joana System
	 * @author     Wanderson Henrique Camargo Rosa
	 * @package    System
	 * @subpackage Acl
	 */
	class System_Acl extends Zend_Acl {
		private static $_file     = 'joana.acl';
		private static $_instance = null;
		
		private function __construct() {}
		
		/**
		 * Singleton Method
		 * @return System_Acl
		 */
		public static function getInstance() {
			if(is_null(self::$_instance))
				self::$_instance = self::_load();
			return self::$_instance;
		}
		
		/**
		 * File Setting
		 * @return void
		 * @param  string $file Serialized Object
		 */
		public static function setFile($file) {
			if(!is_file($file))
				throw new System_Exception();
			self::$_file = $file;
		}
		
		/**
		 * Serialized Load
		 * @return System_Acl
		 */
		private static function _load() {
			$content  = @file_get_contents(self::$_file);
			if($content  === false)
				throw new System_Exception();
			$instance = @unserialize($content);
			if($instance === false)
				throw new System_Exception();
			if(!is_a($instance, 'System_Acl'))
				throw new System_Exception();
			return $instance;
		}
		
		/**
		 * Database Load
		 * @return System_Acl
		 */
		public static function loadFromDb() {
			/* Create a New Instance */
			$instance = new self();
			/* Resources */
			$table = new Resource();
			$resources = $table->fetchAll();
			foreach($resources as $resource)
				$instance->add(new Zend_Acl_Resource($resource->value));
			/* Roles */
			$table = new Role(array('rowClass' => 'Row_Role'));
			$roles = $table->fetchAll(null,'level ASC');
			foreach($roles as $role) {
				if($role->value == $role->parent->value)
					$role->parent->value = null;
				$instance->addRole(new Zend_Acl_Role($role->value), $role->parent->value);
				/* Permissions */
				$resources = $role->findManyToManyRowset('Resource', 'Permission');
				foreach($resources as $resource)
					$instance->allow($role->value, $resource->value);
			}
			/* Serialize */
			$instance->_save();
			/* Singleton */
			self::$_instance = $instance;
			return $instance;
		}
		
		/**
		 * Serialized Method
		 * @return System_Acl
		 */
		private function _save() {
			$fp = @fopen(self::$_file, 'w');
			if($fp === false)
				throw new System_Exception();
			$content = @serialize($this);
			$result  = @fwrite($fp, $content);
			if($result === false)
				throw new System_Exception();
			return $this;
		}
	}
