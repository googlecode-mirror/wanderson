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
interface Hazel_Shop_Basket_ItemStrategy
{
    /**
     * Captura de Valores
     *
     * Método que possibilita a captura de determinado valor solicitado
     * utilizando um encapsulamento apropriado. Recebendo um item, este deve
     * apresentar o resultado conforme o identificador solicitado.
     *
     * @param string $identifier Identificador do Cálculo
     * @param Hazel_Shop_Basket_Item   $item Item de Carrinho de Compras
     * @return float Valor Resultante do Cálculo Solicitado
     */
    public function get($identifier, Item $item);

}
