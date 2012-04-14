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
            $result = $this->_param[$name];
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

