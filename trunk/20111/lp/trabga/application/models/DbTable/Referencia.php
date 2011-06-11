<?php

/**
 * 
 * Enter description here ...
 * @author Wanderson Henrique Camargo Rosa
 *
 */
class Application_Model_DbTable_Referencia extends Local_Db_TableAbstract
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
    protected $_name = 'referencia';

    /**
     * Chaves Primárias
     * @var string
     */
    protected $_primaries = array('idreferencia');

    /**
     * Mapa de Referências
     * @var array
     */
    protected $_dependentTables = array(
        'RArtigoAutor' => 'Application_Model_DbTable_RArtigoAutor',
    );
}

