<?php

/**
 * Relacionamento Artigo Referência
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_RArtigoReferencia extends Local_Db_TableAbstract
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
            'columns' => array('idreferencia'),
            'refColumns' => array('idreferencia'),
            'refTableClass' => 'Application_Model_DbTable_Referencia',
        ),
    );
}

