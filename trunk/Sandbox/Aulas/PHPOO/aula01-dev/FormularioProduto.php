<?php

/* Requisição de Dependências */
require_once 'Formulario.php';

/**
 * Classe Final de Formulário de Produtos
 * Exemplo Básico de Orientação a Objetos
 * Última Derivação da Árvore de Herança em Orientação a Objetos
 * Classes Finais não podem ser Estendidas
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
final class FormularioProduto extends Formulario
{
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
     * Método Sobrescrito da Abstração da Classe Mãe
     * Necessário para Criação de Classe Concreta (Não Abstrata)
     * 
     * @return array Valores Codificados
     */
    public function getValores()
    {
        $valores = array(
            'nome' => $this->getNome(),
            'codigo' => $this->getCodigo()
        );
        return $valores;
    }

    /**
     * Encapsulamento
     * Configuração do Nome do Produto
     * 
     * @param string $nome Nome do Produto
     * @return void
     */
    public function setNome($nome)
    {
        $this->_nome = (string) $nome;
    }

    /**
     * Encapsulamento
     * Informação do Nome do Produto
     * 
     * @return string Nome do Produto
     */
    public function getNome()
    {
        return $this->_nome;
    }

    /**
     * Encapsulamento
     * Configuração do Código do Produto
     * 
     * @param string $codigo Código do Produto
     * @return void
     */
    public function setCodigo($codigo)
    {
        $this->_codigo = $codigo;
    }

    /**
     * Encapsulamento
     * Informação do Código do Produto
     * 
     * @return string Código do Produto
     */
    public function getCodigo()
    {
        return $this->_codigo;
    }
}