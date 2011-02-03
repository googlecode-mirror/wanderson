<?php

class Carrinho
{
    private $_produtos = array();
    
    public function addProduto(Produto $elemento)
    {
        $ident = $elemento->getIdentificador();
        
        if (isset($this->_produtos[$ident])) {
            throw new CarrinhoException("Produto Já Adicionado");
        }
        
        $this->_produtos[$ident] = $elemento;
        
        return $this;
    }
    
    public function getProduto($ident)
    {
        if (!isset($this->_produtos[$ident])) {
            throw new CarrinhoException("Produto Inexistente");
        }
        
        return $this->_produtos[$ident];
    }
    
    public function removeProduto($ident)
    {
        if (!isset($this->_produtos[$ident])) {
            throw new CarrinhoException("Produto Inexistente");
        }
        
        unset($this->_produtos[$ident]);
        
        return $this;
    }
    
    public function getProdutos()
    {
        return $this->_produtos;
    }
    
    public function __get($name)
    {
        return $this->getProduto($name);
    }
    
    public function __set($name, $elemento)
    {
        $elemento->setIdentificador($name);
        $this->addProduto($elemento);
    }
}


