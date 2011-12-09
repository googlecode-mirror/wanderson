<?php
/**
 * Hazel Zend Framework Extended Library
 */

namespace Hazel\Shop\Basket;

/**
 * Plugin para Carrinho de Compras
 *
 * Um Carrinho de Compras pode receber Plugins para processamento dos preços dos
 * itens que estão adicionados ao seu escopo. Estes itens possuem valores que
 * são armazenados durante a persistência de dados. Os Plugins não devem ser
 * armazenados na persistência, portanto devem utilizar os valores de atributos
 * do carrinho apra salvar suas informações necessárias.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
interface PluginInterface
{
    /**
     * Execução do Plugin
     *
     * O Plugin deve ser executado através do Carrinho de Compras, recebendo
     * assim uma referência deste. Caso seja necessário, o Plugin pode solicitar
     * o processamento de outro Plugin diretamente pelo Carrinho de Compras.
     *
     * @param  Basket          $basket Carrinho de Compras Utilizado
     * @return PluginInterface Próprio Objeto para Encadeamento
     */
    public function execute(Basket $basket);

}
