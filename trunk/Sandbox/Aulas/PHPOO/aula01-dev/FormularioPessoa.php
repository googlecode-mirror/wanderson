<?php

/* Requisição de Dependências */
require_once 'Formulario.php';

/**
 * Classe Formulário de Pessoas
 * Exemplo Básico para Orientação a Objetos
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
class FormularioPessoa extends Formulario
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
     * Método Sobrescrito da Abstração da Classe Mãe
     * Necessário para Criação de Classe Concreta (Não Abstrata)
     * 
     * @return array Valores Codificados
     */
    public function getValores()
    {
        $valores = array(
            'nome' => $this->getNome(),
            'idade' => $this->getIdade(),
        );
        return $valores;
    }

    /**
     * Encapsulamento
     * Configuração do Nome da Pessoa
     * 
     * @param string $nome Nome da Pessoa
     * @return void
     */
    public function setNome($nome)
    {
        $this->_nome = (string) $nome;
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
     * Configuração da Idade da Pessoa
     * 
     * @param int $idade Idade da Pessoa
     * @return void
     */
    public function setIdade($idade)
    {
        $this->_idade = (int) $idade;
    }

    /**
     * Encapsulamento
     * Informação da Idade da Pessoa
     * 
     * @return int Idade da Pessoa
     */
    public function getIdade()
    {
        return $this->_idade;
    }
}