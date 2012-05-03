<?php

/**
 * Configurador Universal
 *
 * Possui acessos dinâmicos para configurações de maneiras diferentes dentro do
 * sistema. Estes valores são manipulados pelo objeto e armazenados num conjunto
 * interno.
 *
 * @category WSL
 * @package  WSL_Model
 */
class WSL_Model_Config implements Countable, IteratorAggregate, ArrayAccess {

    /**
     * Parâmetros Armazenados
     * @var array
     */
    protected $_params = array();

    /**
     * Configura um Parâmetro
     * @param  string $name  Nome do Parâmetro
     * @param  mixed  $value Valor para Configuração
     * @return WSL_Model_Config Próprio Objeto para Encadeamento
     */
    public function setParam($name, $value) {
        // Conversão
        $name = (string) $name;
        // Limpeza?
        if ($value === null) {
            // Remover Parâmetro
            unset($this->_params[$name]);
        } else {
            // Cadastrar Parâmetro
            $this->_params[$name] = $value;
        }
        // Encadeamento
        return $this;
    }

    /**
     * Verifica Existência de Parâmetro
     * @param  string $name Nome do Parâmetro
     * @return bool Verificação de Parâmetro Existente
     */
    public function hasParam($name) {
        // Conversão
        $name = (string) $name;
        // Existência
        return array_key_exists($name, $this->_params);
    }

    /**
     * Captura de Parâmetro
     * @param  string $name Nome do Parâmetro
     * @return mixed Valor Configurado
     */
    public function getParam($name) {
        // Conversão
        $name = (string) $name;
        // Resultado Inicial
        $result = null;
        // Existe Parâmetro?
        if ($this->hasParam($name)) {
            // Captura
            $result = $this->_params[$name];
        }
        // Apresentação
        return $result;
    }

    // Método Mágico: Configuração
    public function __set($name, $value) {
        return $this->setParam($name, $value);
    }

    // Método Mágico: Existência
    public function __isset($name) {
        return $this->hasParam($name);
    }

    // Método Mágico: Captura
    public function __get($name) {
        return $this->getParam($name);
    }

    // Método Mágico: Desconfiguração
    public function __unset($name) {
        return $this->setParam($name, null);
    }

    // Interface: Contabilização
    public function count() {
        return count($this->_params);
    }

    // Interface: Iteração
    public function getIterator() {
        return new ArrayIterator($this->_params);
    }

    // Interface: Configuração Array
    public function offsetSet($name, $value) {
        return $this->setParam($name, $value);
    }

    // Interface: Existência Array
    public function offsetExists($name) {
        return $this->hasParam($name);
    }

    // Interface: Captura Array
    public function offsetGet($name) {
        return $this->getParam($name);
    }

    // Interface: Desconfiguração Array
    public function offsetUnset($name) {
        return $this->setParam($name, null);
    }

}

