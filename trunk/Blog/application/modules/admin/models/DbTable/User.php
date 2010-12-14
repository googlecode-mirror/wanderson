<?php

/**
 * Tabela de Usuários
 * Cadastra e mantém os usuários e autores do Blog
 *
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Admin
 * @package    Admin_Model
 * @subpackage DbTable
 */
class Admin_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    /**
     * Esquema do Banco de Dados
     * 
     * @var string
     */
    protected $_schema = 'blog';

    /**
     * Nome da Tabela
     * 
     * @var string
     */
    protected $_name = 'admin_user';

    /**
     * Chave Primária
     * 
     * @var array
     */
    protected $_primary = array('iduser');

    /**
     * Informa uma Seleção sem Elementos Removidos
     * 
     * @return Zend_Db_Table_Select
     */
    public function select($withFromPart = self::SELECT_WITHOUT_FROM_PART)
    {
        $select = parent::select($withFromPart);
        $select->where('deleted = FALSE');
        return $select;
    }
}