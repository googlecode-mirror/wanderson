<?php

/**
 * Tabela de Privilégios
 *
 * @author Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>
 * @category   Acl
 * @package    Acl_Model
 * @subpackage DbTable
 */
class Acl_Model_DbTable_AclPrivileges extends Zend_Db_Table_Abstract
{
    protected $_name = 'acl_privileges';
    protected $_primary = array('resource','name');
}
