<?php

/**
 * Hazel Log
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Log
 */
class Hazel_Log extends Zend_Log
{
    /**
     * Singleton Instance
     * @var Hazel_Log
     */
    private static $_instance = null;

    const LOGIN = 8; // Login: Autenticação do Usuário no Sistema

    public function __construct(Zend_Log_Writer_Abstract $writer = null)
    {
        parent::__construct($writer);

        // Adicionar Escritor de Banco de Dados
        $mapper = array(
            'ip' => 'address',
            'info' => 'info',
            'content' => 'message',
            'created' => 'timestamp',
            'idpeople' => 'user',
            'priority' => 'priority',
            'priorityname' => 'priorityName',
        );
        $table = new Blog_Model_DbTable_Message();
        $adapter = $table->getAdapter();
        $tableName = $table->info(Zend_Db_Table::NAME);
        $element = new Zend_Log_Writer_Db($adapter, $tableName, $mapper);
        $this->addWriter($element);

        // Elemento Extra: Identificador do Usuário
        $user = null;
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity()->idpeople;
        }
        $this->setEventItem('user', $user);

        // Elemento Extra: IP do Cliente
        $front = Zend_Controller_Front::getInstance();
        $address = $front->getRequest()->getClientIp();
        $this->setEventItem('address', $address);
    }

    /**
     * Padrão de Projeto Singleton
     * @return Hazel_Log
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Hazel_Log();
        }
        return self::$_instance;
    }
}