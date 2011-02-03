<?php

abstract class Formulario
{
	public function enviar()
	{
		$values = $this->getValues();
		$values = implode(' ', $values);
		echo 'Enviando Formulário... Valores: ' . $values;
	}
	
	abstract public function getValues();
}