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
     * Linha Padrão da Tabela
     * @var string
     */
    protected $_rowClass = 'Application_Model_DbTable_Row_Referencia';

    /**
     * Mapa de Referência
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
