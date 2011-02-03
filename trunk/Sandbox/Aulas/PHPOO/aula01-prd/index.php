<?php

require_once 'Pessoa.php';
require_once 'PessoaCasada.php';
require_once 'Cadastro.php';

$wanderson = new Pessoa('Wanderson', 25, 'M');

//$wanderson->nome = 'Wanderson';
//$wanderson->setNome('Wanderson');

//$wanderson->setIdade(25);

//$wanderson->gritarSeuNome(); echo '<br/>';
//$wanderson->gritarSuaIdade();

$cadastro = new Cadastro();
//$cadastro->cadastraPessoa($wanderson);

$amanda = new PessoaCasada('Amanda', 18, 'F');
$amanda->setCasada(true);
$amanda->gritarSuaIdade();
echo ($amanda->getCasada() ? 'Sim' : 'Não');

$cadastro->cadastraPessoa($amanda);

