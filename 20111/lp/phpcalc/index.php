<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', true);

/* Carregamento de Classes -------------------------------------------------- */

function __autoload($classname) {
    $filename = implode(DIRECTORY_SEPARATOR, array(
        str_replace('\\', '/', $classname) . '.php'
    ));
    if (!is_readable($filename)) {
        throw new ErrorException("File Not Found: '$classname'");
    }
    require_once $filename;
    if (!class_exists($classname)) {
        throw new ErrorException("Class Not Found: '$classname'");
    }
}

/* Testes ------------------------------------------------------------------- */

class CalculatorLexerTest extends PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $lexer = new Hazel\Calculator\Lexer();
        $lexer->read('1+');
        /* Saída */
        $tokenA = $lexer->getToken();
        $tokenB = $lexer->getToken();
        $tokenC = $lexer->getToken();
        /* Afirmações */
        /* Token A */
        $this->assertTrue($tokenA->isA('T_NUMBER'));
        $this->assertFalse($tokenA->isA('T_OPERATOR'));
        /* Token B */
        $this->assertTrue($tokenB->isA('T_OPERATOR'));
        $this->assertFalse($tokenB->isA('T_NUMBER'));
        /* Token C */
        $this->assertSame(null, $tokenC);
    }
}