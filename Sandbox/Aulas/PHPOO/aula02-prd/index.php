<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

require_once 'Pessoa.php';

$pessoa = new Pessoa('WANDERSON', 25);
try {
    // Tenta configurar a Idade
    $pessoa->setIdade('a');
    echo $pessoa->getIdade();
} catch (Exception $e) {
    // Erro capturado, imprimindo mensagem
    echo $e->getMessage();
}