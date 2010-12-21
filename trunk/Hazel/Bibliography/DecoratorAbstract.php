<?php

/**
 * Hazel Bibliography Abstract Decorator
 * 
 * @author     Wanderson Henrique Camargo Rosa
 * @category   Hazel
 * @package    Hazel_Bibliography
 * @subpackage Decorator
 */
abstract class Hazel_Bibliography_DecoratorAbstract
{
    /**
     * Renderização de Decorador
     * 
     * @param array $content Conteúdo para Decoração
     * @return string Resultado da Aplicação do Decorador
     */
    abstract public function render(array $content);
}