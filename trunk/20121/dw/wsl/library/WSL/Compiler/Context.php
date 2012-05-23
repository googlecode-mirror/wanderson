<?php

/**
 * Contexto de Execução
 *
 * Estrutura utilizada para comunicação entre diferentes elementos de execução
 * do gerenciador de compilação para LaTeX. Utilizando componentes no formato de
 * plugins, estes podem registrar parâmetros ou consultar neste contexto.
 *
 * @category WSL
 * @package  WSL_Compiler
 */
class WSL_Compiler_Context {

    /**
     * Caminho do Diretório de Trabalho
     * @var string
     */
    protected $_workspacePath = null;

    /**
     * Elementos de Documento
     * @var string[]
     */
    protected $_elements = array();

    /**
     * Configuração do Caminho de Trabalho
     *
     * @param  string $path Valor para Configuração
     * @return WSL_Compiler_Context Próprio Objeto para Encadeamento
     */
    public function setWorkspacePath($path) {
        // Configuração
        $this->_workspacePath = (string) $path;
        // Encadeamento
        return $this;
    }

    /**
     * Apresentação do Caminho de Trabalho
     *
     * @return string Conteúdo Solicitado
     */
    public function getWorkspacePath() {
        // Apresentação
        return $this->_workspacePath;
    }

    /**
     * Configuração de Elemento do Documento
     *
     * Elementos de documento são os objetos responsáveis pela construção do
     * elemento como um todo, possibilitando a divisão de responsabilidades
     * dentro do sistema de compilação. Basicamente, os elementos são arquivos
     * armazenados no sistema operacional utilizados pelos plugins para
     * construção do conteúdo na saída.
     *
     * @param  string $name Nome do Elemento
     * @param  string $path Caminho no Sistema Operacional
     * @return WSL_Compiler_Context Próprio Objeto para Encadeamento
     */
    public function setElement($name, $path) {
        // Conversão
        $path = (string) $path;
        // Caminho Nulo == Remoção do Elemento
        if ($path === null) {
            // Desconfiguração
            unset($this->_elements[$name]);
        } else {
            // Configuração
            $this->_elements[$name] = (string) $path;
        }
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Elemento do Documento
     *
     * Apresentação de informações sobre um elemento de documento, parte do
     * conteúdo que deve ser utilizada no momento da compilação do código. Este
     * elemento é um arquivo armazenado no sistema operacional e que deve ser
     * utilizado para construção do documento.
     *
     * @param  string $name Nome do Elemento
     * @return string string Valor Solicitado
     */
    public function getElement($name) {
        // Conversão
        $name = (string) $name;
        // Existe Elemento?
        if ($this->hasElement($name)) {
            // Apresentação de Conteúdo
            return $this->_elements[$name];
        }
        // Valor não Encontrado
        return null;
    }

    /**
     * Existência de Elemento
     *
     * Verifica se o elemento solicitado está configurado dentro do objeto de
     * contexto. Este elemento é uma parte do documento que deve ser utilizada
     * no momento da compilação, onde seu conteúdo é o caminho do elemento no
     * sistema operacional.
     *
     * @param  string $name Nome do Elemento
     * @return bool Confirmação de Existência
     */
    public function hasElement($name) {
        // Conversão
        $name = (string) $name;
        // Existência
        return array_key_exists($name, $this->_elements);
    }
}
