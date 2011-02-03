<?php

require_once 'Formulario.php';

class FormularioPessoa extends Formulario implements InterfaceBanco, Countable
{
	private $nome;
	private $idade;
	private $enviar;
	
	public function getValues()
	{
		return array($this->nome, $this->idade, $this->enviar);
	}
	
	public function __construct($nome, $idade)
	{
		$this->nome = $nome;
		$this->idade = $idade;
	}
	
	public function cadastrar()
	{
		
	}
}