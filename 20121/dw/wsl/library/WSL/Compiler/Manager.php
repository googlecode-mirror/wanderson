<?php

/**
 * Gerenciador de Plugins
 *
 * Elemento utilizado no gerenciamento para compilação de documentos LaTeX
 * dentro do sistema, possuindo uma característica de modularização do
 * processamento, dividindo as tarefas em plugins que podem ser executados com
 * dependência entre si.
 *
 * @category WSL
 * @package  WSL_Compiler
 */
class WSL_Compiler_Manager {

    /**
     * Contexto de Execução
     * @var WSL_Compiler_Context
     */
    protected $_context = null;

    /**
     * Nome do Plugin para Execução Anterior
     * @var string
     */
    protected $_beforePlugin = null;

    /**
     * Nome do Plugin para Execução Posterior
     * @var string
     */
    protected $_afterPlugin = null;

    /**
     * Construtor Padrão
     *
     * @param WSL_Compiler_Context $context Contexto de Execução
     */
    public function __construct(WSL_Compiler_Context $context) {
        // Configurações
        $this->_setContext($context);
    }

    /**
     * Configuração do Plugin de Execução Anterior
     *
     * Nome do elemento que deve ser executado antes do início da compilação do
     * conteúdo armazenado no diretório de trabalho dentro do sistema. Quando
     * houver a necessidade de configuração de muitos plugins de execução,
     * precisamos criar um plugin que execute a chamada destes outros elementos
     * durante a execução.
     *
     * @param  string $name Nome do Plugin
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    public function setBeforePlugin($name) {
        // Configuração
        $this->_beforePlugin = (string) $name;
        // Encadeamento
        return $this;
    }

    /**
     * Configuração do Plugin de Execução Posterior
     *
     * Nome do elemento que deve ser executado após o início da compilação do
     * conteúdo armazenado no diretório de trabalho dentro do sistema.
     * Obedecendo a mesma regra de execução, quando houver a necessidade de
     * execução de muitos plugins, precisamos criar um novo que execute as
     * dependências necessárias.
     *
     * @param  string $name Nome do Plugin
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    public function setAfterPlugin($name) {
        // Configuração
        $this->_afterPlugin = (string) $name;
        // Encadeamento
        return $this;
    }

    public function execute($name) {}
    public function compile() {}

    /**
     * Configuração do Contexto
     *
     * Possibilidade de encapsulamento do configurador de contexto de execução
     * do gerenciador de plugins. Este contexto serve como meio de acesso aos
     * arquivos utilizados pelo compilador para processamento do documento.
     *
     * @param  WSL_Compiler_Context $context Elemento para Configuração
     * @return WSL_Compiler_Manager Próprio Objeto para Encadeamento
     */
    protected function _setContext(WSL_Compiler_Context $context) {
        // Configuração
        $this->_context = $context;
        // Encadeamento
        return $this;
    }

    /**
     * Apresentação do Contexto
     *
     * O contexto de execução é um objeto utilizado que é apresentado junto com
     * o gerenciador para armazenar informações sobre a execução, como nomes de
     * elementos considerados como arquivos durante o processamento.
     *
     * @return WSL_Compiler_Context Elemento Solicitado
     */
    public function getContext() {
        // Apresentação
        return $this->_context;
    }
}
