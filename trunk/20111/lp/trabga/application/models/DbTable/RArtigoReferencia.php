<?php

/**
 * Relacionamento Artigo Referência
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_RArtigoReferencia extends Zend_Db_Table_Abstract
{
    /**
     * Esquema
     * @var string
     */
    protected $_schema = 'sistema';

    /**
     * Esquema
     * @var string
     */
    protected $_name = 'r_artigo_referencia';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primaries = array('idartigo','idreferencia');

    /**
     * Mapa de Referências
     * @var array
     */
    protected $_referenceMap = array(
        'Artigo' => array(
            'columns' => array('idartigo'),
            'refColumns' => array('idartigo'),
            'refTableClass' => 'Application_Model_DbTable_Artigo',
        ),
        'Referencia' => array(
            'columns' => array('referencia'),
            'refColumns' => array('idautor'),
            'refTableClass' => 'Application_Model_DbTable_Referencia',
        ),
    );
}

