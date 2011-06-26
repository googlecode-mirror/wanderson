<?php

/**
 * Exceção do Pacote
 * 
 * @category Local
 * @package  Local_Parser
 * @author   Wanderson Henrique Camargo Rosa
 */
class Local_Parser_Exception extends Exception
{
    /**
     * Construtor Padrão
     * @param string    $message  Mensagem de Erro
     * @param int       $code     Código da Mensagem
     * @param Exception $previous Exceção Anterior Aninhada
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}