<?php

/**
 * Classe para Gerenciamento de Migrations
 * Utiliza um Arquivo de Configuração para Controle do Versionamento
 * @author     Wanderson Henrique Camargo Rosa
 * @package    System
 * @subpackage Db
 * @see        http://github.com/akrabat/Akrabat/
 * @see        http://code.google.com/p/wanderson
 */
class System_Db_Schema_Manager
{
    /**
     * Resultado de Modificações com Sucesso
     * @var string
     */
    const RESULT_OK = 'RESULT_OK';

    /**
     * Resultado das Modificações sem Alterações
     * @var string
     */
    const RESULT_AT_CURRENT_VERSION = 'RESULT_AT_CURRENT_VERSION';

    /**
     * Modificações Não Encontradas
     * @var string
     */
    const RESULT_NO_MIGRATIONS_FOUND = 'RESULT_NO_MIGRATIONS_FOUND';

    /**
     * Diretório de Migrations
     * @var string
     */
    protected $_dir;

    /**
     * Adaptador do Banco de Dados
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;

    /**
     * Configuração do Gerenciador
     * @var Zend_Config_Xml
     */
    protected $_config;

    /**
     * Caminho do Arquivo de Configuração do Gerenciador
     * @var string
     */
    protected $_configPath = './temp/manager.xml';

    /**
     * Construtor da Classe
     * @param string $dir Caminho do Diretório de Migrations
     * @param Zend_Db_Adapter_Abstract $db Adaptador do Banco de Dados
     */
    public function __construct($dir, Zend_Db_Adapter_Abstract $db)
    {
        $this->setDir($dir);
        $this->_db = $db;
    }

    /**
     * Configuração do Diretório de Migrations
     * @param string $dir Diretório para Configuração
     * @return System_Db_Schema_Manager Próprio Objeto
     */
    public function setDir($dir)
    {
        $dir = (string) $dir;
        if (!is_dir($dir)) {
            throw new System_Db_Schema_Exception("Invalid Directory: '$dir'");
        }
        $this->_dir = $dir;
        return $this;
    }

    /**
     * Informa o Diretório de Migrations Configurado
     * @return string Caminho do Diretório
     */
    public function getDir()
    {
        return $this->_dir;
    }

    /**
     * Informa o Número Atual do Versionamento
     * @return int Número do Último Versionamento
     */
    public function getCurrentSchemaVersion()
    {
        return (int) $this->_getConfig()->version;
    }

    /**
     * Consulta de Configuração do Gerenciador
     * @return Zend_Config_Xml Objeto de Configuração do Gerenciador
     */
    protected function _getConfig()
    {
        if ($this->_config === null) {
            $path = $this->_configPath;
            if (!is_file($path)) {
                if (file_put_contents($path, '<manager/>') === false) {
                    throw new System_Db_Schema_Exception('Configuration Error');
                }
            }
            $this->_config = new Zend_Config_Xml($path, null, true);
        }
        return $this->_config;
    }

    /**
     * Seleciona os Arquivos para Execução de Migrations
     * @param int $current Número Atual do Versionamento
     * @param int $stop Número de Parada do Versionamento
     * @return array Informações Pertinentes aos Arquivos Selecionados
     */
    protected function _getMigrationFiles($current, $stop)
    {
        $direction = 'up';
        $from      = (int) $current;
        $to        = (int) $stop;

        if ($stop < $current) {
            $direction = 'down';
            $from      = (int) $stop;
            $to        = (int) $current;
        }

        $files = array();
        $d = dir($this->getDir());
        while (false !== ($entry = $d->read())) {
            if (preg_match('/^([0-9]+)\-(.*)\.php$/i', $entry, $matches)) {
                $version = (int) $matches[1];
                $class   = $matches[2];
                if ($version > $from && $version <= $to) {
                    $files[$version] = array(
                        'filename' => $entry,
                        'version'  => $version,
                        'class'    => $class,
                    );
                }
            }
        }
        $d->close();

        if ($direction == 'up') {
            ksort($files);
        } else {
            krsort($files);
        }

        return $files;
    }

    /**
     * Atualização do Número de Versionamento
     * @param int $version Número para Atualização
     * @return System_Db_Schema_Manager Próprio Objeto
     */
    protected function _updateSchemaVersion($version)
    {
        $path = $this->_configPath;
        $this->_getConfig()->version = (int) $version;

        $writer = new Zend_Config_Writer_Xml(array('filename' => $path));
        $writer->setConfig($this->_config)->write();

        return $this;
    }

    /**
     * Atualizações Entre Versões
     * Efetua Modificações no Banco de Dados para a Versão Solicitada
     * @param int $version Número da Versão Alvo
     * @return string Constante da Classe para Resultado
     */
    public function updateTo($version = null)
    {
        if (is_null($version)) {
            $version = PHP_INT_MAX;
        }
        $version = (int) $version;

        $current = $this->getCurrentSchemaVersion();
        if ($current == $version) {
            return self::RESULT_AT_CURRENT_VERSION;
        }

        $migrations = $this->_getMigrationFiles($current, $version);
        if (empty($migrations)) {
            if ($version == PHP_INT_MAX) {
                return self::RESULT_AT_CURRENT_VERSION;
            }
            return self::RESULT_NO_MIGRATIONS_FOUND;
        }

        $direction = 'up';
        if ($current > $version) {
            $direction = 'down';
        }

        foreach ($migrations as $migration) {
            $this->_processFile($migration, $direction);
        }

        return self::RESULT_OK;
    }

    /**
     * Processamento de Arquivo de Migration
     * @param array $migration Dados do Arquivo de Migration
     * @param string $direction Direção de Migration: up|down
     * @throws System_Db_Schema_Exception Classe Migration Não Encontrada
     * @return System_Db_Schema_Manager Próprio Objeto
     */
    protected function _processFile($migration, $direction)
    {
        $class    = $migration['class'];
        $version  = $migration['version'];
        $filename = $migration['filename'];

        $path = implode(DIRECTORY_SEPARATOR, array($this->getDir(), $filename));
        require_once $path;

        if (!class_exists($class, false)) {
            throw new System_Db_Schema_Exception(
                "Could not find class '$class' in file '$filename'");
        }

        $class = new $class($this->_db);
        $class->$direction();

        if ($direction == 'down') {
            $version = $version - 1;
        }
        $this->_updateSchemaVersion($version);

        return $this;
    }

}
