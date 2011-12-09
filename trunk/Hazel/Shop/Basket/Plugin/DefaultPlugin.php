<?php
/**
 * Hazel Zend Framework Extended Library
 */

/**
 * Plugin de Teste
 *
 * Processamento utilizado para processar um simples desconto sobre os produtos
 * que estão adicionados no Carrinho de Compras. Todos os produtos receberão 10%
 * de desconto.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
class Hazel_Shop_Basket_Plugin_DefaultPlugin implements Hazel_Shop_Basket_PluginInterface
{
    public function execute(Hazel_Shop_Basket_Basket $basket)
    {
        // Processamento sobre Itens
        foreach ($basket->getItems() as $item) {
            // Aplicação de Desconto
            $discount = $item->getProductValue() * 0.1 * (-1);
            // Gravação do Desconto
            $item->setValue('DefaultPlugin', $discount);
        }
        // Encadeamento
        return $this;
    }

}
