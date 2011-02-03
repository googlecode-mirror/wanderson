<?php

require_once 'Formulario.php';
require_once 'FormularioPessoa.php';

$formulario = new FormularioPessoa('wanderson', 25);
$values = $formulario->getValues();
var_dump($values);
$formulario->enviar();