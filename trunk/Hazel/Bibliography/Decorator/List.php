<?php

/**
 * Hazel Bibliography List Decorator
 * 
 * @category   Hazel
 * @package    Hazel_Bibliography
 * @subpackage Decorator
 * @author     Wanderson Henrique Camargo Rosa
 */
class Hazel_Bibliography_Decorator_List
    extends Hazel_Bibliography_DecoratorAbstract
{
    public function render(array $content)
    {
        $result = null;
        if (!empty($content)) {
            $result = '<ul><li>'.implode('</li><li>', $content).'</li></ul>';
        }
        return $result;
    }
}