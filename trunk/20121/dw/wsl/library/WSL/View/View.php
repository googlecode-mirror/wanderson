<?php

/**
 * Camada de Visualização
 *
 * @category WSL
 * @package  WSL_View
 */
class WSL_View_View {

    /**
     * Parâmetros de Visualização
     * @var array
     */
    protected $_params = array();

    /**
     * Caminhos de Visualização
     * @var array
     */
    protected $_paths = array(
        'script' => array(),
        'helper' => array(),
    );

    /**
     * Configuração de Parâmetro
     *
     * @param  string $name  Nome do Parâmetro
     * @param  mixed  $value Valor para Configuração
     * @return WSL_View_View Próprio Objeto para Encadeamento
     */
    public function setParam($name, $value) {
        // Conversão
        $name = (string) $name;
        // Configurar ou Remover?
        if ($value === null) {
            // Remover Parâmetro
            unset($this->_params[$name]);
        } else {
            // Configurar Parâmetro
            $this->_params[$name] = $value;
        }
        // Encadeamento
        return $this;
    }

    /**
     * Existência de Parâmetro
     *
     * @param  string $name Nome do Parâmetro
     * @return bool   Confirmação de Existência
     */
    public function hasParam($name) {
        // Conversão
        $name = (string) $name;
        // Confirmação
        return isset($name, $this->_params);
    }

    /**
     * Captura de Parâmetro
     *
     * @param  string $name Nome do Parâmetro
     * @return mixed  Valor Configurado
     */
    public function getParam($name) {
        // Resultado Inicial
        $result = null;
        // Existe Parâmetro?
        if ($this->hasParam($name)) {
            // Conversão
            $name   = (string) $name;
            // Captura de Resultado
            $result = $this->_params[$name];
        }
        // Resultado
        return $result;
    }

    /**
     * Configuração de Conjunto de Parâmetros
     *
     * @param  string $params Conjunto para Configuração
     * @return WSL_View_View Próprio Objeto para Encadeamento
     */
    public function setParams(array $params) {
        // Iterador
        foreach ($params as $name => $value) {
            // Configuração
            $this->setParam($name, $value);
        }
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Parâmetros
     *
     * @return array Conjunto de Parâmetros Configurados
     */
    public function getParams() {
        // Apresentação
        return $this->_params;
    }

    /**
     * Adicionar Caminho de Visualização
     *
     * @param  string $path Caminho para Inclusão
     * @return WSL_View_View Próprio Objeto para Encadeamento
     */
    public function addScriptPath($path) {
        // Conversão
        $path = (string) $path;
        // Inclusão de Caminho
        array_unshift($this->_paths['script'], $path);
        // Encadeamento
        return $this;
    }

    /**
     * Captura de Caminhos de Visualização
     *
     * @return array Conjunto de Caminhos Configurados
     */
    public function getScriptPaths() {
        // Apresentação
        return $this->_paths['script'];
    }

    /**
     * Renderização de Conteúdo para Visualização
     *
     * @param  string $script Nome do Arquivo para Renderização
     * @return string|bool Resultado do Processamento ou Erro Encontrado
     */
    public function render($script) {
        // Conteúdo Inicial
        $result = false;
        // Conversão
        $script = (string) $script;
        // Arquivo Encontrado
        $filename = false;
        // Processamento
        foreach ($this->getScriptPaths() as $path) {
            // Arquivo Existe no Diretório?
            $filename = realpath($path . DIRECTORY_SEPARATOR . $script);
            // Arquivo Encontrado?
            if (!empty($filename)) break;
        }
        // Arquivo Encontrado?
        if (!empty($filename)) {
            // Renderização
            ob_start();
            // Inclusão de Conteúdo
            include $filename;
            // Captura do Resultado
            $result = ob_get_clean();
        }
        // Apresentação
        return $result;
    }

// Métodos Mágicos -------------------------------------------------------------

    // Configuração
    public function __set($name, $value) {
        return $this->setParam($name, $value);
    }

    // Existência
    public function __isset($name) {
        return $this->hasParam($name);
    }

    // Captura
    public function __get($name) {
        return $this->getParam($name);
    }

    // Desconfiguração
    public function __unset($name) {
        return $this->setParam($name, null);
    }

}

