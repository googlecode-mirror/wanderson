<?php
/**
 * Hazel Zend Framework Extended Library
 */

namespace \Hazel\Shop\Basket;

/**
 * Interface de Produtos
 *
 * Buscando separar o pacote de Carrinho de Compras de outros projetos, esta
 * Interface deve ser aplicada aos produtos que devem ser armazenados pela
 * estrutura desenvolvida. Lembre-se de que os elementos adicionados também
 * serão armazenados pela camada de persistência.
 *
 * @author     Wanderson Henrique Camargo Rosa <wanderson@f1solucoes.com.br>
 * @see        http://www.wanderson.camargo.nom.br
 * @category   Hazel
 * @package    Hazel_Shop
 * @subpackage Basket
 */
interface ProductInterface
{
    /**
     * Código do Produtos
     *
     * Acesso ao código do produto, identificador único que é utilizado para
     * manipular produtos específicos dentro do Carrinho de Compras.
     *
     * @return string Valor Solicitado
     */
    public function getCode();

    /**
     * Valor do Produto
     *
     * Preço que deve ser utilizado pelo Carrinho de Compras como base para
     * cálculos pelos Plugins de execução.
     *
     * @return float Valor Solicitado
     */
    public function getValue();

}
