<?php

/**
 * Message Database Table
 * 
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Blog
 * @package    Blog_Model
 * @subpackage DbTable
 */
class Blog_Model_DbTable_Message extends Zend_Db_Table_Abstract
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
    protected $_name = 'message';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primary = array('idmessage');

    /**
     * Nome da Classe Representante de Tupla da Tabela
     * @var string
     */
    protected $_rowClass = 'Blog_Model_DbTable_Row_Message';

    /**
     * Mapa de Referências para Chaves Estrangeiras
     * @var array
     */
    protected $_referenceMap = array(
        'People' => array(
            'columns' => 'idpeople',
            'refColumns' => 'idpeople',
            'refTableClass' => 'Blog_Model_DbTable_People',
        ),
    );
}