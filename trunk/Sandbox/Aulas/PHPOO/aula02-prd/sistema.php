<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

require_once 'autoload.php';

$carrinho = new Carrinho();

try {

// Computador ------------------------------------------------------------------

$computador = new Produto();

$computador->setNome('Computador')
           ->setCodigo('COMP')
           ->setIdentificador('comp');

$carrinho->addProduto($computador);

// Mouse -----------------------------------------------------------------------

$mouse = new Produto();

$mouse->setNome('Mouse')
      ->setCodigo('MOUS')
      ->setIdentificador('mous');

$carrinho->addProduto($mouse);

}
catch (ProdutoException $e) {
    echo "Ocorreu um erro de produto: " . $e->getMessage();
}
catch (CarrinhoException $e) {
    echo "O carrinho retornou um erro: " . $e->getMessage();
}
catch (Exception $e) {
    echo "Erro genérico: " . $e;
}

// Visualização ----------------------------------------------------------------

foreach ($carrinho->getProdutos() as $ident => $produto)
{
    echo "$ident: $produto<br/>";
}

echo $carrinho->mous;

$teclado = new Produto();
$teclado->setNome('Teclado')->setCodigo('TECL');
$carrinho->tecl = $teclado;

var_dump($carrinho->getProdutos());

