<?php
/**
 * Hazel Zend Framework Extended Library
 *
 * LICENSE
 *
 * Copyright (c) 2010, Wanderson Henrique Camargo Rosa.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permited provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 *
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 *     * Neither the name of the author nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Zend Framework
 * Copyright (c) Zend Technologies Ltd. All rights reserved.
 *
 * @category Hazel
 * @package  Hazel_Basket
 * @author   Wanderson Henrique Camargo Rosa
 * @link     http://code.google.com/p/wanderson/wiki/Hazel
 */

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
class Hazel_Shop_Basket_ItemCalculator implements Hazel_Shop_Basket_ItemStrategy
{
    // Valor Total Unitário do Produto
    const CALCULATE_VALUE = 'CALCULATE_VALUE';

    // Valor Total da Quantidade * Valor Unitário
    const CALCULATE_TOTAL = 'CALCULATE_TOTAL';

    // Cálculo Centralizado
    public function get($identifier, Hazel_Shop_Basket_Item $item)
    {
        // Valor Inicial
        $value = 0.0;
        // Identificador do Pedido
        switch ($identifier) {
            case self::CALCULATE_VALUE:
                // Valor do Produto
                $value = $item->getProductValue() + array_sum($item->getValues());
                break;
            case self::CALCULATE_TOTAL:
                // Valor pela Quantidade
                $value = $this->get(self::CALCULATE_VALUE, $item) * $item->getQuantity();
                break;
            default:
                // Valor Padrão
                $value = 0.0;
        }
        // Valor Negativo
        if ($value < 0) {
            // Valor Zerado
            $value = 0.0;
        }
        // Resultados
        return $value;
    }
}
