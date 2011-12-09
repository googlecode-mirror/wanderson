<?php
/**
 * Hazel Zend Framework Extended Library
 */

namespace Hazel\Shop\Basket;

/**
 * Informações de Item de Carrinho de Compras
 *
 * Existem cálculos específicos que necessitam ser apresentados pelo Carrinho de
 * Compras e que não podem ser implementados dentro do item. Para auxiliar
 * nestes cálculos, o Carrinho de Compras disponibiliza uma instância que
 * obedece ao Padrão de Projeto Strategy e encapsula os cálculos solicitados.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
interface ItemStrategy
{
    /**
     * Captura de Valores
     *
     * Método que possibilita a captura de determinado valor solicitado
     * utilizando um encapsulamento apropriado. Recebendo um item, este deve
     * apresentar o resultado conforme o identificador solicitado.
     *
     * @param string $identifier Identificador do Cálculo
     * @param Item   $item       Item de Carrinho de Compras
     * @return float Valor Resultante do Cálculo Solicitado
     */
    public function get($identifier, Item $item);

}
