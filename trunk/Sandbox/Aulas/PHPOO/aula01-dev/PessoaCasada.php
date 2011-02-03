<?php

/* Requisição de Dependências */
require_once 'Pessoa.php';

/**
 * Classe Pessoa Casada
 * Exemplo Básico de Orientação a Objetos
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
class PessoaCasada extends Pessoa
{
    /**
     * Confirmação de Pessoa Casada
     * @var boolean
     */
    private $_casada;

    /**
     * Encapsulamento
     * Configuração da Confirmação de Pessoa Casada
     * 
     * @param boolean $casada Flag de Confirmação
     * @return void
     */
    public function setCasada($casada)
    {
        $this->_casada = (boolean) $casada;
    }

    /**
     * Encapsulamento
     * Informação da Confirmação de Pessoa Casada
     * 
     * @return void
     */
    public function getCasada()
    {
        return $this->_casada;
    }

    /**
     * Sobrescrita de Métodos
     * Regra de Negócio: Necessidade de Sexo Precedendo Nome da Pessoa
     * Especialização da Classe Estendida Conforme Regras de Negócio
     * 
     * @return string Nome da Pessoa Formatado
     */
    public function getNome()
    {
        /* Acesso ao Método da Classe Mãe */
        $nome = parent::getNome();
        $sexo = $this->getSexo();
        return "$sexo $nome";
    }
}