<?php

/**
 * Elemento Postscript
 * 
 * @author Wanderson Henrique Camargo Rosa
 */
class PSNode extends Node
{
    /**
     * Distância entre Elementos
     * Eixo das Abscissas
     * @var float
     */
    protected static $_distancex = 0.0;

    /**
     * Distância entre Elementos
     * Eixo das Ordenadas
     * @var float
     */
    protected static $_distancey = 0.0;

    /**
     * Altura da Árvore
     * @var integer
     */
    protected $_height = 0;

    /**
     * Configura a Distância entre Elementos nas Abscissas
     * @param float $distance Valor para Configuração
     * @return NULL
     */
    public static function setDistanceX($distance)
    {
        self::$_distancex = (float) $distance;
    }

    /**
     * Informa a Distância entre Elementos nas Abscissas
     * @return float Valor Solicitado
     */
    public static function getDistanceX()
    {
        return self::$_distancex;
    }

    /**
     * Configura a Distância entre Elementos nas Ordenadas
     * @param float $distance Valor para Configuração
     * @return NULL
     */
    public static function setDistanceY($distance)
    {
        self::$_distancey = (float) $distance;
    }

    /**
     * Informa a Distância entre Elementos nas Ordenadas
     * @return float Valor Solicitado
     */
    public static function getDistanceY()
    {
        return self::$_distancey;
    }

    /**
     * Configura a Altura da Árvore
     * @param int $height Valor para Configuração
     * @return PSNode Próprio Objeto para Encadeamento
     */
    public function setHeight($height)
    {
        $this->_height = (int) $height;

        /* Atualização da Altura Esquerda */
        $left  = $this->getLeft();
        if (isset($left)) {
            $left->setHeight($height - 1);
        }
        /* Atualização da Altura Direita */
        $right = $this->getRight();
        if (isset($right)) {
            $right->setHeight($height - 1);
        }

        return $this;
    }

    /**
     * Informa a Altura da Árvore
     * @return int Valor Solicitado
     */
    public function getHeight()
    {
        return $this->_height;
    }

    /**
     * Renderização do Elemento no Plano Cartesiano
     * @param float $positionx Posição no Eixo das Abscissas
     * @param float $positiony Posição no Eixo das Ordenadas
     * @return PSNode Próprio Objeto para Encadeamento
     */
    public function render($positionx, $positiony)
    {
        /* Deslocamentos */
        $distancex = self::getDistanceX() * $this->getHeight();
        $distancey = self::getDistanceY();
        /* Renderização Local (x,y) */
        $content = $this->getContent();
        /* Elemento */
        echo "newpath $positionx $positiony 10 0 360 arc closepath fill\n";
        /* Identificador */
        echo "newpath $positionx 10 add $positiony 10 sub moveto ($content) show\n";
        /* Subárvores */
        $left  = $this->getLeft();
        $right = $this->getRight();
        /* Renderização de Filhas */
        if ($left !== NULL) {
            /* @var $left PSNode */
            /* Caminho de Ligação */
            echo "newpath $positionx $positiony moveto $positionx $distancex sub $positiony $distancey sub lineto stroke\n";
            /* Renderização Esquerda */
            $left->render($positionx - $distancex, $positiony - $distancey);
        }
        if ($right !== NULL) {
            /* @var $right PSNode */
            /* Caminho de Ligação */
            echo "newpath $positionx $positiony moveto $positionx $distancex add $positiony $distancey sub lineto stroke\n";
            /* Renderização Direita */
            $right->render($positionx + $distancex, $positiony - $distancey);
        }
        return $this;
    }

    public function insert(PSNode $node)
    {
        /* Sobrescrita para Tipagem Correta */
        parent::insert($node);

        /* Verificação de Alturas */
        $left  = $this->getLeft();
        $right = $this->getRight();
        /* Configuração de Alturas */
        $lheight = 0;
        $rheight = 0;
        /* Altura da Subárvore Esquerda */
        if ($left !== NULL) {
            $lheight = $left->getHeight();
        }
        /* Altura da Subárvore Direita */
        if ($right !== NULL) {
            $rheight = $right->getHeight();
        }
        /* Altura Local */
        $height = $lheight < $rheight ? $rheight : $lheight;
        $this->setHeight($height + 1);

        return $this;
    }

}
