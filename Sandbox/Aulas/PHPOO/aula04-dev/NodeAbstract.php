<?php

/**
 * Nó Abstrato para Documentos
 * Hierarquia de Árvores
 * @author Wanderson Henrique Camargo Rosa
 */
abstract class NodeAbstract implements NodeInterface
{
    /**
     * Nome do Nó
     * @var string
     */
    private $_name;

    /**
     * Lista de Parâmetros
     * @var array
     */
    private $_params = array();

    /**
     * Nó sem Conteúdo
     * @var boolean
     */
    private $_closed;

    /**
     * Nó Pai
     * @var NodeAbstract
     */
    private $_parentNode;

    /**
     * Conteúdo do Nó
     * @var array
     */
    private $_content = array();

    /**
     * Tamanho de Indentação
     * @var int
     */
    private static $_indentSize;

    /**
     * Elemento de Indentação
     * @var string
     */
    private static $_indentElement;

    /**
     * Construtor da Classe
     * @param string $name Nome do Nó
     */
    public function __construct($name, $parentNode = null)
    {
        $this->setName($name)->setParentNode($parentNode);
    }

    /**
     * Configuração do Nome do Nó
     * @param string $name Nome do Nó
     * @return NodeAbstract Próprio Objeto para Encadeamento
     * @throws NodeException Nome Vazio Inválido
     */
    public function setName($name)
    {
        if (empty($name)) {
            throw new NodeException('Nome Vazio Inválido');
        }
        $this->_name = (string) $name;
        return $this;
    }

    /**
     * Informação do Nome do Nó
     * @return string Nome do Nó
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Configuração de Parâmetro
     * @param string $name  Nome do Parâmetro
     * @param mixed  $value Valor do Parâmetro
     * @return NodeAbstract Próprio Objeto para Encadeamento
     */
    public function setParam($name, $value)
    {
        $name = (string) $name;
        $this->_params[$name] = $value;
        return $this;
    }

    /**
     * Informação do Valor de Parâmetro
     * @param string $name Nome do Parâmetro
     * @return mixed Valor do Parâmetro
     */
    public function getParam($name)
    {
        $name = (string) $name;
        if (!isset($this->_params[$name])) {
            return null;
        }
        return $this->_params[$name];
    }

    /**
     * Informação de Lista de Parâmetros
     * @return array Conjunto de Parâmetros
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Remoção de Parâmetro
     * @param string $name Nome do Parâmetro
     * @return NodeAbstract Próprio Objeto para Encadeamento
     */
    public function removeParam($name)
    {
        $name = (string) $name;
        if (isset($this->_params[$name])) {
            unset($this->_params[$name]);
        }
        return $this;
    }

    /**
     * Configuração de Fechamento de Nó
     * @param boolean $closed Flag de Fechamento
     * @return NodeAbstract Próprio Objeto para Encadeamento
     */
    public function setClosed($closed)
    {
        $this->_closed = (boolean) $closed;
        return $this;
    }

    /**
     * Informação de Fechamento de Nó
     * @return boolean Flag de Fechamento
     */
    public function getClosed()
    {
        return $this->_closed;
    }

    /**
     * Adiciona um Nó ao Conteúdo
     * @param NodeInterface $node Nó de Conteúdo Interno
     */
    public function addContentNode(NodeInterface $node)
    {
        $node->setParentNode($this);
        $this->_content[] = $node;
        return $this;
    }

    /**
     * Informa um Nó do Conteúdo Conforme Posição Solicitada
     * @param int $index Posição de Pesquisa
     * @return NodeInterface Nó Correspondente à Posição Solicitada
     * @throws NodeException Posição de Nó Inválida
     */
    public function getContentNode($index)
    {
        $index = (int) $index;
        if ($index < 0 || !isset($this->_content[$index])) {
            throw new NodeException("Posição de Nó Inválida: '$index'");
        }
        return $this->_content[$index];
    }

    /**
     * Informa a Lista de Nós do Conteúdo
     * @return array Conjunto de Nós
     */
    public function getContentNodes()
    {
        return $this->_content;
    }

    /**
     * Remove um Nó de Conteúdo
     * @param int $index Posição de Pesquisa
     * @return NodeAbstract Próprio Objeto para Encadeamento
     */
    public function removeContentNode($index)
    {
        $index = (int) $index;
        $node = $this->getContentNode($index);
        $node->_setParentNode(null);

        $count = count($this->_content);
        for ($i = $index; $i < $count - 1; $i++) {
            $this->_content[$index] = $this->_content[$index + 1];
        }
        unset($this->_content[$count - 1]);
        return $this;
    }

    public function setParentNode($parentNode)
    {
        if ($parentNode !== null && !($parentNode instanceof NodeAbstract)) {
            throw new NodeException('Invalid Parent Node');
        }
        return $this;
    }

    public function getParentNode()
    {
        return $this->_parentNode;
    }

    public function render($level = 0)
    {
        $level = abs((int) $level);
        return (string) $this->_render($level);
    }

    /**
     * Renderização do Nó
     * Acesso Interno sem Tratamento de Entrada
     * @param int $level Nível de Indentação
     * @return string Conteúdo Renderizado
     */
    protected abstract function _render($level);

    /**
     * Conversão para String
     * @return string Resultado da Chamada
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Configuração do Tamanho de Indentação
     * @param int $size Tamanho da Indentação
     * @return void
     * @throws NodeException Tamanho de Indentação Inválido
     */
    public static function setIndentSize($size)
    {
        $size = (int) $size;
        if ($size < 0) {
            throw new NodeException("Tamanho de Indentação Inválido: '$size'");
        }
        self::$_indentSize = $size;
    }

    /**
     * Informação do Tamanho de Indentação
     * @return int Tamanho de Indentação
     */
    public static function getIndentSize()
    {
        return self::$_indentSize;
    }

    /**
     * Configuração de Elemento de Indentação
     * @param mixed $element Elemento de Indentação
     * @return void
     */
    public static function setIndentElement($element)
    {
        self::$_indentElement = (string) $element;
    }

    /**
     * Informação de Elemento de Indentação
     * @return mixed Elemento de Indentação
     */
    public static function getIndentElement()
    {
        return self::$_indentElement;
    }
}