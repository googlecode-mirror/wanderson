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
     * Gênero
     * @var string
     */
    private $_sexo;

    /**
     * Construtor da Classe
     * Chamado em Tempo de Construção de Objetos
     * 
     * @param string $nome  Nome da Pessoa
     * @param int    $idade Idade da Pessoa
     * @param string $sexo  Gênero
     */
    public function __construct($nome, $idade, $sexo)
    {
        /* Utilização dos Encapsulamentos */
        $this->setNome($nome);
        $this->setIdade($idade);
        $this->setSexo($sexo);
    }

    /**
     * Destruidor da Classe
     * Chamado em Tempo de Destruição de Objetos
     * 
     * @return void
     */
    public function __destruct()
    {
//        echo 'Eu estou morto!';
    }

    /**
     * Encapsulamento
     * Configuração do Nome com Filtro para Maiúsculas
     * 
     * @param string $nome Nome da Pessoa
     * @return void
     */
    public function setNome($nome)
    {
        $this->_nome = strtoupper($nome);
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
     * @return void
     */
    public function setIdade($idade)
    {
        $confirm = false;
        if (is_int($idade) && ($idade > 0)) {
            $this->_idade = $idade;
            $confirm = true;
        }
        return $confirm;
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
     * Encapsulamento
     * Configuração do Gênero
     * 
     * @param string $sexo Gênero Masculino ou Feminino
     * @return void
     */
    public function setSexo($sexo)
    {
        $sexo = strtoupper(substr($sexo, 0, 1));
        switch ($sexo) {
            case 'M':
            case 'F':
                $this->_sexo = $sexo;
                break;
            default:
                $this->_sexo = 'M';
        }
    }

    /**
     * Encapsulamento
     * Informação do Gênero
     * 
     * @return string Gênero Masculino ou Feminino
     */
    public function getSexo()
    {
        return $this->_sexo;
    }

    /**
     * Ação de Gritar o Próprio Nome
     * Informa na Saída Padrão o Nome Configurado
     * 
     * @return void
     */
    public function gritarMeuNome()
    {
        echo "Meu nome é {$this->getNome()}!";
    }

    /**
     * Ação de Gritar a Própria Idade
     * Informa na Saída Padrão a Idade Configurada
     * 
     * @return void
     */
    public function gritarMinhaIdade()
    {
        echo "Eu tenho {$this->getIdade()} anos!";
    }
}