<?php

/**
 * Relacionamento Artigo Autor
 * 
 * @category   Application
 * @package    Application_Model
 * @subpackage DbTable
 */
class Application_Model_DbTable_RArtigoAutor extends Zend_Db_Table_Abstract
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
    protected $_name = 'r_artigo_autor';

    /**
     * Chaves Primárias
     * @var array
     */
    protected $_primaries = array('idartigo','idautor');

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
        'Autor' => array(
            'columns' => array('idautor'),
            'refColumns' => array('idautor'),
            'refTableClass' => 'Application_Model_DbTable_Autor',
        ),
    );
}
