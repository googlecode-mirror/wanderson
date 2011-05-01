<?php

/**
 * Elemento de Árvore Binária
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
class Node
{
    /**
     * Conteúdo do Elemento
     * @var mixed
     */
    protected $_content;

    /**
     * Subárvore Esquerda
     * @var Node
     */
    protected $_left;

    /**
     * Subárvore Direita
     * @var Node
     */
    protected $_right;

    /**
     * Construtor
     * @param mixed $content Conteúdo do Elemento
     */
    public function __construct($content = NULL)
    {
        $this->setContent($content);
    }

    /**
     * Configura o Conteúdo do Elemento
     * @param mixed $content Valor para Configuração
     * @return Node Próprio Objeto para Encadeamento
     */
    public function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    /**
     * Informa o Conteúdo do Elemento
     * @return mixed Valor Solicitado
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Configura o Elemento Raiz da Subárvore Esquerda
     * @param Node $left Elemento para Configuração
     * @return Node Próprio Objeto para Encadeamento
     */
    public function setLeft(Node $left)
    {
        $this->_left = $left;
        return $this;
    }

    /**
     * Informa o Elemento Raiz da Subávore Esquerda
     * @return Node Elemento Solicitado
     */
    public function getLeft()
    {
        return $this->_left;
    }

    /**
     * Configura o Elemento Raiz da Subárvore Direita
     * @param Node $left Elemento para Configuração
     * @return Node Próprio Objeto para Encadeamento
     */
    public function setRight(Node $right)
    {
        $this->_right = $right;
        return $this;
    }

    /**
     * Informa o Elemento Raiz da Subárvore Direita
     * @return Node Elemento Solicitado
     */
    public function getRight()
    {
        return $this->_right;
    }

    /**
     * Insere Determinado Elemento na Árvore
     * @param Node $node Elemento para Inserção
     * @return Node Próprio Objeto para Encadeamento
     * @throws InvalidArgumentException Conteúdo do Nó Idêntico
     */
    public function insert(Node $node)
    {
        /* Conteúdo Idêntico */
        if ($node->getContent() == $this->getContent()) {
            throw new InvalidArgumentException('Conteúdo Inválido: Valores Idênticos');
        }
        $local = NULL;
        if ($node->getContent() < $this->getContent()) {
            $local = $this->getLeft();
            if ($local === NULL) {
                /* Esquerdo Vazio */
                $this->setLeft($node);
                return $this;
            }
        }
        if ($node->getContent() > $this->getContent()) {
            $local = $this->getRight();
            if ($local === NULL) {
                /* Direito Vazio */
                $this->setRight($node);
                return $this;
            }
        }
        /* Inserção de Subárvore */
        $local->insert($node);
        return $this;
    }
}