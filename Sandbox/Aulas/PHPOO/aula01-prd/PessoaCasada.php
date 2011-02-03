<?php

require_once 'Pessoa.php';

class PessoaCasada extends Pessoa
{
	private $_casada;
	
	public function setCasada($casada)
	{
		$this->_casada = (bool) $casada;
	}
	
	public function getCasada()
	{
		return $this->_casada;
	}
	
	public function getNome()
	{
		$nome = parent::getNome();
		$sexo = $this->getSexo();
		return "$sexo $nome";
	}
}