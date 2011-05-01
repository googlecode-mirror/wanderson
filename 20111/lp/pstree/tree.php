<?php

/**
 * Árvore Binária
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
class Tree
{
    /**
     * Elemento Raiz
     * @var Node
     */
    protected $_root;

    /**
     * Configura o Elemento Raiz
     * @param Node $root Elemento para Configuração
     * @return Tree Próprio Objeto para Encadeamento
     */
    public function setRoot(Node $root)
    {
        $this->_root = $root;
        return $this;
    }

    /**
     * Informa o Elemento Raiz
     * @return Node Elemento Solicitado
     */
    public function getRoot()
    {
        return $this->_root;
    }

    /**
     * Insere um Valor na Árvore
     * @param mixed $content Conteúdo para Inserção
     * @return Tree Próprio Objeto para Encadeamento
     */
    public function insert($content)
    {
        $node = new Node($content);
        $root = $this->getRoot();
        if ($root === NULL) {
            $this->setRoot($node);
        } else {
            $root->insert($node);
        }
        return $this;
    }
}