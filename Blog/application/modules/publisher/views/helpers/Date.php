<?php

/**
 * Auxiliar da Camada de Visualização para Formatar Datas
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @category Publisher
 * @package Publisher_View
 * @subpackage Helper
 */
class Publisher_View_Helper_Date extends Zend_View_Helper_Abstract
{
    /**
     * Formatação de Datas
     * 
     * @param string $value Valor para Formatação
     * @param string $format Formato de Saída
     */
    public function date($value, $format = null)
    {
        if ($format === null) {
            $format = Zend_Date::DATETIME_FULL;
        }
        $date = new Zend_Date($value);
        return $date->get($format);
    }
}