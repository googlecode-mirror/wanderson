<?php
/**
 * Pokeflute Library
 * @author Wanderson Henrique Camargo Rosa
 */
namespace Pokeflute;

/**
 * Pokeflute Configurations
 *
 * @category Pokeflute
 * @package  Pokeflute_Config
 */
class Config implements \Countable, \IteratorAggregate, \ArrayAccess {

    /**
     * Configurações
     * @var array
     */
    protected $_values = array();

    /**
     * Configura um Valor
     *
     * @param  string $name  Nome do Valor para Configuração
     * @param  mixed  $value Valor para Armazenamento
     * @return Config Próprio Objeto para Encadeamento
     */
    public function set($name, $value) {
        // Conversão
        $name = (string) $name;
        // Verificar Valor para Configuração
        if ($value !== null) {
            // Adicionar Valor
            $this->_values[$name] = $value;
        } else {
            // Desconfigurar Valor
            unset($this->_values[$name]);
        }
        // Encadeamento
        return $this;
    }

    /**
     * Captura um Valor
     *
     * @param  string $name Nome do Valor para Captura
     * @return mixed  Valor Armazenado na Posição
     */
    public function get($name) {
        // Conversão
        $name = (string) $name;
        // Resultado Inicial
        $result = null;
        // Verificar Posição
        if (array_key_exists($name, $this->_values)) {
            // Captura de Resultado
            $result = $this->_values[$name];
        }
        // Apresentação
        return $result;
    }

    /**
     * Consulta de Existência
     *
     * @param  string $name Nome do Valor para Consulta
     * @return mixed  bool  Confirmação de Existência
     */
    public function has($name) {
        return $this->get($name) !== null;
    }

    // Método Mágico: Configuração
    public function __set($name, $value) {
        // Chamada de Elemento Interno
        $this->set($name, $value);
    }

    // Método Mágico: Desconfiguração
    public function __unset($name) {
        // Chamada de Elemento Interno
        $this->set($name, null);
    }

    // Método Mágico: Captura
    public function __get($name) {
        // Chamada de Elemento Interno
        return $this->get($name);
    }

    // Método Mágico: Existência
    public function __isset($name) {
        return $this->has($name);
    }

    // Contagem de Elementos
    public function count() {
        // Contagem de Valores
        return count($this->_values);
    }

    // Iterador Interno
    public function getIterator() {
        // Construção de Iterador
        return new ArrayIterator($this->_values);
    }

    // Acesso por Array: Existência
    public function offsetExists($offset) {
        return $this->has($offset);
    }

    // Acesso por Array: Captura
    public function offsetGet($offset) {
        return $this->get($offset);
    }

    // Acesso por Array: Configuração
    public function offsetSet($offset, $value) {
        return $this->set($offset, $value);
    }

    // Acesso por Array: Desconfiguração
    public function offsetUnset($offset) {
        return $this->set($offset, null);
    }

}

