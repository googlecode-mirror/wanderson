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
    protected static $_distancex;

    /**
     * Distância entre Elementos
     * Eixo das Ordenadas
     * @var float
     */
    protected static $_distancey;

    /**
     * Coordenada das Abscissas
     * @var float
     */
    protected $_positionx;

    /**
     * Coordenada das Ordenadas
     * @var float
     */
    protected $_positiony;

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
     * Configura a Posição no Eixo das Abscissas
     * @param float $position Valor para Configuração
     * @return PSNode Próprio Objeto para Encadeamento
     */
    public function setPositionX($position)
    {
        $this->_positionx = (float) $position;
        return $this;
    }

    /**
     * Informa a Posição no Eixo das Abscissas
     * @return float Elemento Solicitado
     */
    public function getPositionX()
    {
        return $this->_positionx;
    }

    /**
     * Configura a Posição no Eixo das Ordenadas
     * @param float $position Valor para Configuração
     * @return PSNode Próprio Objeto para Encadeamento
     */
    public function setPositionY($position)
    {
        $this->_positiony = (float) $position;
        return $this;
    }

    /**
     * Informa a Posição no Eixo das Ordenadas
     * @return float Elemento Solicitado
     */
    public function getPositionY()
    {
        return $this->_positiony;
    }

}
