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
 * Armazenador de Carrinho de Compras
 *
 * Estrutura necessária para persistir um Carrinho de Compras, sendo utilizada
 * para manter as informações entre diferentes requisições. Esta estrutura é
 * adicionada ao Carrinho de Compras durante a sua inicialização e será
 * necessária principalmente durante a destruição do objeto Carrinho de Compras,
 * que solicita o seu armazenamento.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
interface Hazel_Shop_Basket_StorageInterface
{
    /**
     * Construtor do Elemento
     *
     * O construtor necessita ser fixo para que o Padrão de Projeto Factory
     * trabalhe de forma correta durante a inicialização de um Carrinho de
     * Compras. Os parâmetros serão apresentados e estes podem ser verificados
     * dentro do objeto de persistência.
     *
     * @param array $params Conjunto de Parâmetros para Construção
     */
    public function __construct(array $params = array());

    /**
     * Leitura de Carrinho de Compras
     *
     * Durante a leitura, um objeto persistido de Carrinho de Compras deverá ser
     * fornecido pela instância de armazenamento. Caso este método apresente um
     * valor nulo, a classe Carrinho de Comprar irá criar um novo objeto para
     * ser manipulado.
     *
     * @return Hazel_Shop_Basket_Basket|null Carrinho de Compras Persistido ou Carrinho Inexistênte
     */
    public function read();

    /**
     * Gravação de Carrinho de Compras
     *
     * Um Carrinho de Compras deverá ser persistido ao final de sua vida sempre
     * que o objeto estiver em tempo de destruição. A instância de Carrinho de
     * Compras acessa o armazenador e solicita a gravação do mesmo. O método
     * deve apresentar a confirmação de sucesso durante o salvamento.
     *
     * @param  Hazel_Shop_Basket_Basket $basket Carrinho de Compras para Persistência
     * @return bool Confirmação da Persistência Concluída com Sucesso
     */
    public function write(Hazel_Shop_Basket_Basket $basket);

}
