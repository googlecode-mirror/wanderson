<?php

/**
 * Classe Provedora de Esquemas de Banco de Dados
 * Ferramenta do Zend Framework para Execução por Terminal
 * @author     Wanderson Henrique Camargo Rosa
 * @package    System
 * @subpackage Db
 * @see        http://github.com/akrabat/Akrabat/
 * @see        http://code.google.com/p/wanderson
 */
class System_Tool_DatabaseSchemaProvider
    extends Zend_Tool_Project_Provider_Abstract
{
    /**
     * Adaptador do Banco de Dados
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;

    /**
     * Arquivo de Configuração da Ferramenta
     * @var Zend_Config
     */
    protected $_config;

    /**
     * Inicialização da Ferramenta
     * @param string $env Ambiente de Execução
     * @throws Zend_Tool_Project_Exception Erro de Configuração do Projeto
     * @return System_Tool_DatabaseSchemaProvider Proprio Objeto
     */
    protected function _init($env)
    {
        $profile = $this->_loadProfile(self::NO_PROFILE_THROW_EXCEPTION);
        $config = $profile->search('applicationConfigFile');

        if ($config == false) {
            throw new Zend_Tool_Project_Exception(
                'A project with an application config file is required');
        }
        $path = $config->getPath();
        $this->_config = new Zend_Config_Ini($path, $env, true);

        require_once 'Zend/Loader/Autoloader.php';
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('System_');

        return $this;
    }

    /**
     * Informa o Número Atual de Versionamento do Migration
     * @param string $env Ambiente de Execução
     * @param string $dir Caminho do Diretório de Migrations
     * @return boolean Confirmação de Sucesso da Chamada de Método
     */
    public function current($env = 'development', $dir = './scripts/migrations')
    {
        $this->_init($env);
        $response = $this->_registry->getResponse();

        try {
            $db = $this->_getDbAdapter();
            $manager = new System_Db_Schema_Manager($dir, $db);
            $version = $manager->getCurrentSchemaVersion();
            $message = sprintf('Current version is %d', $version);
            $response->appendContent($message);
            return true;
        } catch (Exception $e) {
            $response->appendContent('AN ERROR HAS OCCURED:');
            $response->appendContent($e->getMessage());
            return false;
        }
    }

    /**
     * Atualiza o Migration para a Última Versão
     * @param string $env Ambiente de Execução
     * @param string $dir Caminho do Diretório de Migrations
     * @return boolean Confirmação de Sucesso da Atualização
     */
    public function update($env = 'development', $dir = './scripts/migrations')
    {
        return $this->updateTo(null, $env, $dir);
    }

    /**
     * Atualiza o Migration para a Primeira Versão
     * @param string $env Ambiente de Execução
     * @param string $dir Caminho do Diretório de Migrations
     * @return boolean Confirmação de Sucesso da Atualização
     */
    public function reset($env = 'development', $dir = './scripts/migrations')
    {
        return $this->updateTo(0, $env, $dir);
    }

    /**
     * Atualiza o Migration para a Versão Solicitada
     * @param int $version Versão para Atualização
     * @param string $env Ambiente de Execução
     * @param string $dir Caminho do Diretório de Migrations
     * @return boolean Confirmação de Sucesso da Atualização
     */
    public function updateTo($version, $env = 'development',
        $dir = './scripts/migrations')
    {
        $this->_init($env);
        $response = $this->_registry->getResponse();

        try {
            $db = $this->_getDbAdapter();
            $manager = new System_Db_Schema_Manager($dir, $db);

            $result = $manager->updateTo($version);
            $version = $manager->getCurrentSchemaVersion();

            switch ($result) {

                case System_Db_Schema_Manager::RESULT_AT_CURRENT_VERSION:
                    $message = sprintf('Already at version %d', $version);
                    break;

                case System_Db_Schema_Manager::RESULT_NO_MIGRATIONS_FOUND:
                    $message = 'No migration files found to migrate from %d';
                    $message = sprintf($message, $version);
                    break;

                default:
                    $message = 'Schema updated to version %d';
                    $message = sprintf($message, $version);

            }

            $response->appendContent($message);

            return true;

        } catch (Exception $e) {

            $response->appendContent('AN ERROR HAS OCCURED:');
            $response->appendContent($e->getMessage());
            return false;

        }
    }

    /**
     * Informação do Adaptador de Banco de Dados
     * Inicialização se o Adaptador Ainda não foi Instanciado
     * @return Zend_Db_Adapter_Abstract Adaptador Configurado
     */
    protected function _getDbAdapter()
    {
        if (is_null($this->_db)) {
            $config = $this->_config->resources->db;
            $this->_db = Zend_Db::factory($config->adapter, $config->params);
        }
        return $this->_db;
    }

}