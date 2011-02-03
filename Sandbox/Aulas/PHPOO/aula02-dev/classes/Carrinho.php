<?php

/**
 * Controle de Carrinho
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
class Carrinho
{
    /**
     * Cadastamento de Produtos
     * @var array
     */
    private $_produtos = array();

    /**
     * Adiciona um Produto no Carrinho
     * @param Produto $elemento Elemento para Adição
     * @throws CarrinhoException Produto Já Adicionado
     * @return Carrinho Próprio Objeto para Encadeamento
     */
    public function addProduto(Produto $elemento)
    {
        $id = $elemento->getId();

        if (isset($this->_produtos[$id])) {
            throw new CarrinhoException("Produto Já Adicionado");
        }

        $this->_produtos[$id] = $elemento;

        return $this;
    }

    /**
     * Retorno de um Produto Solicitado
     * @param string $id Identificador do Produto
     * @throws CarrinhoException Produto Inexistente
     * @return Produto Produto Solicitado
     */
    public function getProduto($id)
    {
        if (!isset($this->_produtos[$id])) {
            throw new ProdutoException("Produto Inexistente");
        }

        return $this->_produtos[$id];
    }

    /**
     * Remove um Produto do Carrinho
     * @param string $id Identificador do Produto
     * @throws CarrinhoException Produto Inexistente
     * @return Carrinho Próprio Objeto para Encadeamento
     */
    public function removeProduto($id)
    {
        if (!isset($this->_produtos[$id])) {
            throw new ProdutoException("Produto Inexistente");
        }

        unset($this->_produtos[$id]);

        return $this;
    }

    /**
     * Conjunto de Produtos do Carrinho
     * @return array Conjunto de Produtos
     */
    public function getProdutos()
    {
        return $this->_produtos;
    }

    /**
     * Remove Todos os Produtos do Carrinho
     * @return Carrinho Próprio Objeto para Encadeamento
     */
    public function cleanProdutos()
    {
        $this->_produtos = array();
        return $this;
    }

    /**
     * Método Mágico
     * Acesso Direto ao Produto pelo Identificador
     * @param string $nome Identificador do Produto
     * @return Produto Produto Solicitado
     */
    public function __get($nome)
    {
        return $this->getProduto($nome);
    }

    /**
     * Método Mágico
     * Configuração Direta do Produto Conforme Identificador
     * @param string $nome Identificador do Produto
     * @param Produto $elemento Produto para Configuração
     * @return void
     */
    public function __set($nome, $elemento)
    {
        $elemento->setId($nome);
        $this->addProduto($elemento);
    }
}