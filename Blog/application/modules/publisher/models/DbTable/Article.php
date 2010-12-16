<?php

/**
 * Tabela de Artigos
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @category Publisher
 * @package Publisher_Model
 * @subpackage DbTable
 */
class Publisher_Model_DbTable_Article extends Zend_Db_Table_Abstract
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
    protected $_name = 'publisher_article';

    /**
     * Chaves Primárias
     * 
     * @var array
     */
    protected $_primaries = array('idarticle');

    /**
     * Nome da Classe Representante das Linhas da Tabela
     * 
     * @var string
     */
    protected $_rowClass = 'Publisher_Model_DbTable_Row_Article';

    /**
     * Mapa de Referências
     * 
     * @var array
     */
    protected $_referenceMap = array(
        'Author' => array(
            'columns' => array('idauthor'),
            'refColumns' => array('iduser'),
            'refTableClass' => 'Admin_Model_DbTable_User',
        ),
        'Category' => array(
            'columns' => array('idcategory'),
            'refColumns' => array('idcategory'),
            'refTableClass' => 'Publisher_Model_DbTable_Category',
        ),
    );
}