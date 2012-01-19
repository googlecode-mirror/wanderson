<?php

/**
 * Tabela de Permissões
 *
 * @author Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>
 * @category   Acl
 * @package    Acl_Model
 * @subpackage DbTable
 */
class Acl_Model_DbTable_AclPermissions extends Zend_Db_Table_Abstract
{
    protected $_name = 'acl_roles';
    protected $_primary = array('role','resource','privilege');
}
