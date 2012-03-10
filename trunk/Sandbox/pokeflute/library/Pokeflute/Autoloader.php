<?php
/**
 * Pokeflute Library
 * @author Wanderson Henrique Camargo Rosa
 */
namespace Pokeflute;

/**
 * Pokeflute Class Loader
 *
 * @category Pokeflute
 * @package  Pokeflute_Loader
 */
class Autoloader {

    /**
     * Singleton Instance
     * @var Autoloader
     */
    private static $_instance = null;

    /**
     * Mapa de Diretórios para Carregamento
     * @var array
     */
    protected $_mapper = array();

    /**
     * Singleton Access
     * @return Autoloader Singleton Instance
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Singleton Constructor
     */
    private function __construct() {
        // Registro em Autocarregamento
        spl_autoload_register(array($this, 'load'));
        // Configuração de Mapeamento
        $this->setMapper('Pokeflute', dirname(__FILE__))
             ->setMapper('Model', APPLICATION_PATH . '/models');
    }

    /**
     * Configuração de Mapeamento
     *
     * Durante o carregamento de classes, precisamos consultar a camada de
     * mapeamento de diretórios para certificar-se de que os prefixos
     * solicitados existem no sistema. Utilizando os caminhos configurados,
     * podemos pesquisar os arquivos naquele local.
     *
     * @param  string     $prefix Prefixo Referente ao Diretório
     * @param  string     $directory Caminho do Diretório para Configuração
     * @return Autoloader Próprio Objeto para Encadeamento
     */
    public function setMapper($prefix, $directory) {
        // Conversão
        $prefix    = (string) $prefix;
        $directory = (string) $directory;
        // Configurações
        $this->_mapper[$prefix] = $directory;
        // Encadeamento
        return $this;
    }

    /**
     * Consulta em Camada de Mapeamento
     *
     * Possibilidade de consulta da camada de mapeamento para verificar se
     * determinado sufixo em nome de classe recebeu uma configuração. Caso este
     * parâmetro não esteja configurado, será apresentado um valor nulo.
     *
     * @param  string      $prefix Prefixo para Consulta
     * @return string|null Valor Encontrado ou Elemento Nulo
     */
    public function getMapper($prefix) {
        // Conversão
        $prefix = (string) $prefix;
        // Resultado Inicial
        $result = null;
        // Pesquisa
        if (array_key_exists($prefix, $this->_mapper)) {
            $result = $this->_mapper[$prefix];
        }
        // Apresentação
        return $result;
    }

    /**
     * Carregar Classe ou Interface
     *
     * Pesquisando pelo nome de classe, podemos carregar um arquivo conforme
     * estrutura padrão do sistema a partir de prefixo da nomenclatura.
     *
     * @return bool Confirmação de Execução com Sucesso ou Falha
     */
    public function load($classname) {
        // Captura de Prefixo
        $counter = preg_match('/^(?<prefix>[[:alnum:]]+)\\\\(?<suffix>.+)$/', $classname, $match);
        // Contabilização de Resultados
        if ($counter === 1) {
            // Verificação de Mapeamento
            $directory = $this->getMapper($match['prefix']);
            // Diretório Mapeado?
            if (!empty($directory)) {
                // Conversão de Sufixo para Diretório
                $filename = implode(DIRECTORY_SEPARATOR, array_merge(array($directory), explode('\\', $match['suffix']))) . '.php';
                // Requisição de Arquivo
                require_once $filename;
                // Confirmação
                return true;
            }
        }
        // Problema Encontrado
        return false;
    }
}

