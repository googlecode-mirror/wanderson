<?php

namespace Hazel\Calculator;

use Hazel\Parser\Exception;
use Hazel\Parser\Lexer as LexerAbstract;
use Hazel\Parser\Token;

/**
 * Analisador Léxico para Calculadora
 * 
 * @author   Wanderson Henrique Camargo Rosa
 * @category Hazel
 * @package  Hazel\Calculator
 */
class Lexer extends LexerAbstract
{
    /* Buffer de Caracter Único */
    public function read($input)
    {
        /* Casting */
        $input = (string) $input;
        /* Tamanho da Entrada */
        $length = strlen($input);
        /* Leitura */
        for ($i = 0; $i < $length; $i++) {
            /* Elemento Atual */
            $content = $input[$i];
            if (preg_match('/^[0-9]$/', $content)) {
                /* Número */
                $token = new Token('T_NUMBER');
                $token->setContent($content)->setPosition($i);
                $this->addToken($token);
            } elseif (preg_match('/^[+-\\\*\/^#]$/', $content)) {
                /* Operador */
                $token = new Token('T_OPERATOR');
                $token->setContent($content)->setPosition($i);
                $this->addToken($token);
            } elseif (preg_match('/^[(]$/', $content)) {
                /* Parêntese Esquerdo */
                $token = new Token('T_OB');
                $token->setContent($content)->setPosition($i);
                $this->addToken($token);
            } elseif (preg_match('/^[)]$/', $content)) {
                /* Parêntese Direito */
                $token = new Token('T_CB');
                $token->setContent($content)->setPosition($i);
                $this->addToken($token);
            } elseif (preg_match('/^[ \n\t]$/', $content)) {
                /* Descarte de Entrada */
            } else {
                throw new Exception("Invalid Input: '$content'");
            }
        }
        return $this;
    }
}