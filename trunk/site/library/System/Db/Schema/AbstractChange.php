<?php

/**
 * 
 * Modelo para Criação de Migrations
 * Classe Abstrata para Modificações de Banco de Dados
 * @author     Wanderson Henrique Camargo Rosa
 * @package    System
 * @subpackage Db
 * @see        http://github.com/akrabat/Akrabat/
 * @see        http://code.google.com/p/wanderson
 */
abstract class System_Db_Schema_AbstractChange
{
    /**
     * 
     * Adaptador do Banco de Dados
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;

    /**
     * 
     * Construtor da Classe
     * @param Zend_Db_Adapter_Abstract $db Adaptador do Banco de Dados
     */
    public function __construct(Zend_Db_Adapter_Abstract $db)
    {
        $this->_db = $db;
    }

    /**
     * 
     * Método Abstrato
     * Implementação de Alterações do Banco de Dados
     * @return void
     */
    abstract public function up();

    /**
     * 
     * Método Abstrato
     * Remoção de Alterações do Banco de Dados
     */
    abstract public function down();
}