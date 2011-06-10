<?php

/**
 * Artigo
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_Artigo extends Zend_Db_Table_Abstract
{
    /**
     * Esquema
     * @var string
     */
    protected $_schema = 'sistema';

    /**
     * Nome da Tabela
     * @var string
     */
    protected $_name = 'artigo';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primaries = array('idartigo');

    /**
     * Tabelas Dependentes
     * @var array
     */
    protected $_dependentTables = array(
        'RArtigoAutor' => 'Application_Model_DbTable_RArtigoAutor',
        'RArtigoFigura' => 'Application_Model_DbTable_RArtigoFigura',
        'RArtigoReferencia' => 'Application_Model_DbTable_RArtigoReferencia',
    );

    /**
     * Mapa de Referências
     * @var array
     */
    protected $_referenceMap = array(
        'Usuario' => array(
            'columns' => array('idusuario'),
            'refColumns' => array('idusuario'),
            'refTableClass' => 'Application_Model_DbTable_Usuario',
        ),
    );
}
