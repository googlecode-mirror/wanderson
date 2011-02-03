<?php

/**
 * Produtos de Carrinho
 * Representante de Produtos que Podem ser Adicionados ao Carrinho
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
class Produto
{
    /**
     * Chave Identificadora do Produto
     * @var string
     */
    private $_id;

    /**
     * Nome do Produto
     * @var string
     */
    private $_nome;

    /**
     * Código do Produto
     * @var string
     */
    private $_codigo;

    /**
     * Encapsulamento
     * Configuração do Identificador do Produto
     * @param string $id Identificador
     * @throws ProdutoException Formato Inválido
     * @return Produto Próprio Objeto para Encadeamento
     */
    public function setId($id)
    {
        if (is_string($id) && preg_match('/[a-z]+/', $id)) {
            $this->_id = $id;
        } else {
            throw new ProdutoException("Formato Inválido: '$id'");
        }
        return $this;
    }

    /**
     * Encapsulamento
     * Informação do Identificador do Produto
     * @return string Identificador do Produto
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Encapsulamento
     * Configuração de Nome
     * @param string $nome Nome do Produto
     * @throws ProdutoException Nome Inválido do Produto
     * @return Produto Próprio Objeto para Encadeamento
     */
    public function setNome($nome)
    {
        if (is_string($nome) && !empty($nome)) {
            $this->_nome = $nome;
        } else {
            throw new ProdutoException("Nome Inválido de Produto: '$nome'");
        }
        return $this;
    }

    /**
     * Encapsulamento
     * Informação de Nome
     * @return string Nome do Produto
     */
    public function getNome()
    {
        return $this->_nome;
    }

    /**
     * Encapsulamento
     * Configuração de Código
     * @param string $codigo Código do Produto
     * @throws ProdutoException Formato de Código Inválido
     * @return Produto Próprio Objeto para Encadeamento
     */
    public function setCodigo($codigo)
    {
        if (is_string($codigo) && !empty($codigo)) {
            $this->_codigo = $codigo;
        } else {
            throw new ProdutoException("Código Inválido de Produto: '$codigo'");
        }
        return $this;
    }

    /**
     * Encapsulamento
     * Informação de Código
     * @return string Código do Produto
     */
    public function getCodigo()
    {
        return $this->_codigo;
    }

    /**
     * Método Mágico
     * Saída Automática de Renderização
     * @return string Conteúdo Renderizado
     */
    public function __toString()
    {
        return $this->getNome();
    }
}