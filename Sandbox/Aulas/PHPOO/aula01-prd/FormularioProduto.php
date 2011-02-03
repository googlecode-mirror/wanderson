<?php

require_once 'Formulario.php';

final class FormularioProduto extends Formulario
{
	private $nome;
	private $codigo;
	
	public function getValues()
	{
		return array($this->nome, $this->codigo);
	}
	
	public function __construct($nome, $codigo)
	{
		$this->nome = $nome;
		$this->codigo = $codigo;
	}
}