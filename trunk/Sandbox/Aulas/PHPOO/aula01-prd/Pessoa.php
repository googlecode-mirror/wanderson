<?php

class Pessoa
{
	private $_nome;
	private $_idade;
	private $_sexo;
	
	private static $escola;
	
	public static function setEscola($escola)
	{
		self::$escola = $escola;
//		Pessoa::setEscola($escola);
	}
	
	public function __construct($nome, $idade, $sexo)
	{
		$this->setNome($nome);
		$this->setIdade($idade);
		$this->setSexo($sexo);
	}
	
	public function __destruct()
	{
//		echo 'Estou morto!';
	}
	
	public function setIdade($idade)
	{
		if (is_int($idade) && ($idade > 0)) {
			$this->_idade = $idade;
			return true;
		} else {
			return false;
		}
	}
	
	public function getIdade()
	{
		return $this->_idade;
	}
	
	public function setNome($nome)
	{
		$this->_nome = strtoupper($nome);
	}
	
	public function getNome()
	{
		return $this->_nome;
	}

	public function gritarSeuNome()
	{
		echo 'Meu nome é ' . $this->_nome;
	}

	public function gritarSuaIdade()
	{
		echo 'Minha idade é ' . $this->_idade;
	}
	
	public function setSexo($sexo)
	{
		$this->_sexo = $sexo;
	}
	
	public function getSexo()
	{
		return $this->_sexo;
	}
}