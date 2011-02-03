<?php

class Cadastro
{
	public function cadastraPessoa(Pessoa $pessoa)
	{
		echo 'Cadastrando a pessoa ' . $pessoa->getNome();
	}
}