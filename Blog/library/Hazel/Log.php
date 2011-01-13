<?php

/**
 * Hazel Log
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Log
 */
class Hazel_Log
{
    /**
     * Singleton Instance
     * @var Hazel_Log
     */
    private static $_instance = null;

    /**
     * Objeto Manipulador das Informações
     * @var Zend_Log
     */
    private $_logger = null;

    /**
     * Construtor Padrão da Classe
     */
    private function __construct()
    {
        $logger = new Zend_Log();

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
        $logger->addWriter($element);

        // Elemento Extra: Identificador do Usuário
        $user = null;
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity()->idpeople;
        }
        $logger->setEventItem('user', $user);

        // Elemento Extra: IP do Cliente
        $front = Zend_Controller_Front::getInstance();
        $address = $front->getRequest()->getClientIp();
        $logger->setEventItem('address', $address);

        $this->_setLogger($logger);
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

    /**
     * Configuração do Manipulador de Informações
     * @param Zend_Log $logger
     * @return Hazel_Log Próprio Objeto para Encadeamento
     */
    protected function _setLogger(Zend_Log $logger)
    {
        $this->_logger = $logger;
        return $this;
    }

    /**
     * Informação do Manipulador de Informações
     * @return Zend_Log Objeto Manipulador de Informações
     */
    public function getLogger()
    {
        return $this->_logger;
    }

    /**
     * Proxy Pattern
     * Acesso Interno Direto ao Objeto de Logging
     * @return Hazel_Log Próprio Objeto para Encadeamento
     */
    public function __call($method, $params)
    {
        $this->getLogger()->__call($method, $params);
        return $this;
    }
}