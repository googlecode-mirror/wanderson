<?php

/**
 * Árvore de Elementos Postscript
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
class PSTree extends Tree
{
    /**
     * Translação no Eixo das Abscissas
     * @var float
     */
    protected $_translatex = 0.0;

    /**
     * Translação no Eixo das Ordenadas
     * @var float
     */
    protected $_translatey = 0.0;

    /**
     * Configura a Translação no Eixo das Abcissas
     * @param float $translate Valor para Configuração
     * @return PSTree Próprio Objeto para Encadeamento
     */
    public function setTranslateX($translate)
    {
        $this->_translatex = (float) $translate;
        return $this;
    }

    /**
     * Informa a Translação no Eixo das Abcissas
     * @return float Valor Solicitado
     */
    public function getTranslateX()
    {
        return $this->_translatex;
    }

    /**
     * Configura a Translação no Eixo das Ordenadas
     * @param float $translate Valor para Configuração
     * @return PSTree Próprio Objeto para Encadeamento
     */
    public function setTranslateY($translate)
    {
        $this->_translatey = (float) $translate;
        return $this;
    }

    /**
     * Informa a Translação no Eixo das Ordenadas
     * @return float Valor Solicitado
     */
    public function getTranslateY()
    {
        return $this->_translatey;
    }

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
        /* Translação */
        $translatex = $this->getTranslateX();
        $translatey = $this->getTranslateY();
        echo "%!\n";
        echo "$translatex $translatey translate\n";
        echo "/Courier findfont 10 scalefont setfont\n";
        $root = $this->getRoot();
        if ($root !== NULL) {
            /* @var $root PSNode */
            $height = $root->render(0,0);
        }
        echo "showpage\n";
    }
}