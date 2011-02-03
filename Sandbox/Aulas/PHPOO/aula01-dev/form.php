<?php

/* Requisição de Dependência */
require_once 'FormularioPessoa.php';

$form = new FormularioPessoa();
$form->setNome('Wanderson');
$form->setIdade(25);
$form->enviar();