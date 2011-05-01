<?php

/**
 * Árvore de Elementos Postscript
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
class PSTree extends Tree
{
    public function insert($content)
    {
        $node = new PSNode($content);
        parent::_insert($node);
        return $this;
    }

    /**
     * Renderização da Árvore no Plano Cartesiano
     * @return PSTree Próprio Objeto para Encadeamento
     */
    public function render()
    {
        $root = $this->getRoot();
        if ($root !== NULL) {
            /* @var $root PSNode */
            $height = $root->render(0,0);
        }
    }
}