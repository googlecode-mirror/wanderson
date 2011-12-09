<?php
/**
 * Hazel Zend Framework Extended Library
 */

namespace Hazel\Shop\Basket;

/**
 * Calculadora Padrão de Item
 *
 * Buscando facilitar o desenvolvimento, uma calculadora padrão de item é criada
 * tentando efetuar o somatório simples de todos os valores apresentados dentro
 * de cada item do Carrinho de Compras.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
class ItemCalculator implements ItemStrategy
{
    public function get($identifier, Item $item)
    {
        // Valor do Produto
        $value = $item->getProductValue() + array_sum($item->getValues());
        // Valor Negativo
        if ($value < 0) {
            // Valor Zerado
            $value = 0;
        }
        // Resultados
        return $value;
    }
}
