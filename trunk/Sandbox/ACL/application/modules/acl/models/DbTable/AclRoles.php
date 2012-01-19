<?php

/**
 * Tabela de Funções
 *
 * @author Wanderson Henrique Camargo Rosa <wandersonwhcr@gmail.com>
 * @category   Acl
 * @package    Acl_Model
 * @subpackage DbTable
 */
class Acl_Model_DbTable_AclRoles extends Zend_Db_Table_Abstract
{
    protected $_name = 'acl_roles';
    protected $_primary = array('name');
}
