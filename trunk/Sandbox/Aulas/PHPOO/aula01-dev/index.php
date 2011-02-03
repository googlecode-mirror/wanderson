<?php

/* Requisição de Classe Utilizada */
require_once 'Pessoa.php';

/* Criando Nova Instância de Objeto */
$wanderson = new Pessoa('Wanderson', 25, 'Masculino');
echo 'Meu nome é ' . $wanderson->getNome() . '<br/>';
echo 'Minha idade é ' . $wanderson->getIdade() . '<br/>';

/* Requisição de Classe Utilizada */
require_once 'PessoaCasada.php';

/* Criando Nova Instância de Objeto */
$amanda = new PessoaCasada('Amanda', 18, 'Feminino');
$amanda->setCasada(true);
$amanda->gritarMeuNome();
echo '<br/>';
$amanda->gritarMinhaIdade();
echo '<br/>';