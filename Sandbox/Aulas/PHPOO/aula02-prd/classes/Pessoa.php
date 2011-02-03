<?php

/**
 * Classe Pessoa
 * Exemplo Básico para Orientação a Objetos
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
class Pessoa
{
    /**
     * Nome da Pessoa
     * @var string
     */
    private $_nome;

    /**
     * Idade da Pessoa
     * @var int
     */
    private $_idade;

    /**
     * Encapsulamento
     * Configuração do Nome com Filtro para Maiúsculas
     * 
     * @param string $nome Nome da Pessoa
     * @return Pessoa Próprio Objeto para Encadeamento
     */
    public function setNome($nome)
    {
        if (!preg_match('/^[A-Z]+([ ][A-Z]+)*$/', $nome)) {
            throw new Exception("Nome Inválido: '$nome'");
        }
        $this->_nome = (string) $nome;
        return $this;
    }

    /**
     * Encapsulamento
     * Informação do Nome da Pessoa
     * 
     * @return string Nome da Pessoa
     */
    public function getNome()
    {
        return $this->_nome;
    }

    /**
     * Encapsulamento
     * Configuração da Idade
     * 
     * @param int $idade Valor Inteiro de Idade
     * @return Pessoa Próprio Objeto para Encadeamento
     */
    public function setIdade($idade)
    {
        if (!preg_match('/^[0-9]+$/', $idade)) {
            throw new Exception("Idade Inválida: '$idade'");
        }
        $this->_idade = (int) $idade;
        return $this;
    }

    /**
     * Encapsulamento
     * Informação da Idade
     * 
     * @return int Valor Inteiro de Idade
     */
    public function getIdade()
    {
        return $this->_idade;
    }

    /**
     * Construtor da Classe
     * Chamado em Tempo de Construção de Objetos
     * 
     * @param string $nome  Nome da Pessoa
     * @param int    $idade Idade da Pessoa
     */
    public function __construct($nome, $idade)
    {
        /* Utilização dos Encapsulamentos */
        $this->setNome($nome)->setIdade($idade);
    }
}