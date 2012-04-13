<?php

/**
 * Autocarregador de Classes
 *
 * @category WSL
 * @package  WSL_Loader
 */
class WSL_Loader_Autoloader {

    /**
     * Instância Singleton
     * @var WSL_Loader_Autoloader
     */
    private static $_instance = null;

    /**
     * Mapeamento de Namespaces
     * @var array
     */
    private $_mapper = array();

    /**
     * Acesso Singleton
     *
     * @return WSL_Loader_Autoloader Elemento Solicitado
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Construtor Singleton
     */
    private function __construct() {
        // Carregamento Automático
        spl_autoload_register(array($this, 'load'));
        // Mapeamento Inicial
        $this->setMapper('WSL', realpath(dirname(__FILE__) . '/../'));
    }

    /**
     * Configuração de Mapeamento
     *
     * Estrutura necessária para criação de mapeamentos utilizando prefixos de
     * classes para diretórios. Assim, podemos armazenar determinadas classes em
     * diretórios específicos.
     *
     * @param  string $prefix  Prefixo da Classe para Mapeamento
     * @param  string $dirname Caminho do Diretório para Configuração
     * @return WSL_Loader_Autoloader Próprio Objeto para Encadeamento
     */
    public function setMapper($prefix, $dirname) {
        // Conversão
        $prefix  = (string) $prefix;
        $dirname = (string) $dirname;
        // Configuração
        $this->_mapper[$prefix] = $dirname;
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Mapeamento
     *
     * As configurações de mapeamento são necessárias para processar os
     * carregamentos de classes de forma automática, pesquisando em nomes de
     * diretórios especificados a partir do prefixo da classe, após concatenando
     * o sufixo desta no diretório.
     *
     * @param  string      $prefix Prefixo da Classe para Mapeamento
     * @return string|null Caminho do Diretório Configurado
     */
    public function getMapper($prefix) {
        // Resultado Inicial
        $result = false;
        // Conversão
        $prefix = (string) $prefix;
        // Existe Mapeamento Configurado?
        if (array_key_exists($prefix, $this->_mapper)) {
            // Capturar Elemento
            $result = $this->_mapper[$prefix];
        }
        // Apresentação
        return $result;
    }

    /**
     * Carregar Classe
     *
     * @param  string $classname Nome da Classe para Carregamento
     * @return bool   Confirmação de Carregamento de Classe
     */
    public function load($classname) {
        // Resultado Inicial
        $result = false;
        // Capturar Prefixo
        if (preg_match('/^(?<prefix>[[:alnum:]]+)_(?<suffix>.*)/', $classname, $match)) {
            // Capturar Mapeamento
            $dirname = $this->getMapper($match['prefix']);
            // Existe Diretório?
            if (!empty($dirname)) {
                // Transformar Sufixo para Diretório
                $suffix = str_replace('_', '/', $match['suffix']) . '.php';
                // Construir Nome de Arquivo
                $filename = realpath("$dirname/$suffix");
                // Existe Arquivo?
                if (!empty($filename)) {
                    // Carregar Arquivo
                    require_once $filename;
                    // Aplicar Resultado
                    $result = class_exists($classname);
                }
            }
        }
        // Resultado
        return $result;
    }

}

