<?php

/**
 * Tabela de Categorias
 * 
 * Controle e Manutenção de Categorias de Artigos
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @category Publisher
 * @package Publisher_Model
 * @subpackage DbTable
 */
class Publisher_Model_DbTable_Category extends Zend_Db_Table_Abstract
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
    protected $_name = 'publisher_category';

    /**
     * Chaves Primárias
     * 
     * @var array
     */
    protected $_primaries = array('idcategory');

    /**
     * Nome da Classe Representante das Linhas da Tabela
     * 
     * @var string
     */
    protected $_rowClass = 'Publisher_Model_DbTable_Row_Category';
}