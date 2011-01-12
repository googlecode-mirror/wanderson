<?php

/**
 * People Database Table
 * 
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Blog
 * @package    Blog_Model
 * @subpackage DbTable
 */
class Blog_Model_DbTable_People extends Zend_Db_Table_Abstract
{
    /**
     * Nome do Conjunto de Tabelas
     * @var string
     */
    protected $_schema = 'blog';

    /**
     * Nome da Tabela
     * @var string
     */
    protected $_name = 'people';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primary = array('idpeople');

    /**
     * Nome da Classe Representante da Tupla da Tabela
     * @var string
     */
    protected $_rowClass = 'Blog_Model_DbTable_Row_People';

    /**
     * Tabelas Dependentes
     * @var array
     */
    protected $_dependentRowset = array(
        'Blog_Model_DbTable_People'
    );

    public function select($withFromPart = self::SELECT_WITHOUT_FROM_PART)
    {
        $select = parent::select($withFromPart);
        $select->where('removed = ?', false);
        return $select;
    }
}