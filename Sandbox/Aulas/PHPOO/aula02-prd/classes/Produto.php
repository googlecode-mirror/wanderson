<?php

class Produto
{
    private $_nome;
    private $_codigo;
    private $_identificador;

    public function setNome($nome)
    {
        if (is_string($nome) && !empty($nome)) {
            $this->_nome = $nome;
        } else {
            throw new ProdutoException("Nome Inválido: '$nome'");
        }
        return $this;
    }

    public function getNome()
    {
        return $this->_nome;
    }
    
    public function setCodigo($codigo)
    {
        if (is_string($codigo) && !empty($codigo)) {
            $this->_codigo = $codigo;
        } else {
            throw new ProdutoException("Código Inválido: '$codigo'");
        }
        return $this;
    }
    
    public function getCodigo()
    {
        return $this->_codigo;
    }
    
    public function setIdentificador($identificador)
    {
        if (!preg_match('/^[a-z]+$/', $identificador)) {
            throw new ProdutoException("Identificador Inválido: '$identificador'");
        }
        $this->_identificador = (string) $identificador;
        return $this;
    }
    
    public function getIdentificador()
    {
        if ($this->_identificador === null) {
            throw new ProdutoException("Identificador não configurado!");
        }
        return $this->_identificador;
    }
    
    public function __toString()
    {
        return $this->getNome();
    }
    
    
}