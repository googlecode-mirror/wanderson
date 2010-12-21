<?php

/**
 * Hazel Bibliography Exception
 * 
 * @category Hazel
 * @package  Hazel_Bibliography
 * @author   Wanderson Henrique Camargo Rosa
 */
class Hazel_Bibliography_Exception extends Exception
{
    /**
     * Construtor Padrão
     * 
     * @param string $message Mensagem de Erro
     * @param int $code Código de Erro
     */
    public function __construct($message = null, $code = null)
    {
        parent::__construct($message, $code);
    }
}