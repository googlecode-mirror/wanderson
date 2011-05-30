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

class CalculatorTest extends PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $lexer = new Hazel\Calculator\Lexer();

        $lexer->clear()->read('1+');
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

        $lexer->clear()->read('1+2-1');
        /* Saída */
        $tokenA = $lexer->getToken();
        $tokenB = $lexer->getToken();
        $tokenC = $lexer->getToken();
        $tokenD = $lexer->getToken();
        $tokenE = $lexer->getToken();
        /* Afirmações */
        /* Token A */
        $this->assertTrue($tokenA->isA('T_NUMBER'));
        $this->assertFalse($tokenA->isA('T_OPERATOR'));
        /* Token B */
        $this->assertTrue($tokenB->isA('T_OPERATOR'));
        $this->assertFalse($tokenB->isA('T_NUMBER'));
        /* Token C */
        $this->assertTrue($tokenC->isA('T_NUMBER'));
        $this->assertFalse($tokenC->isA('T_OPERATOR'));
        /* Token D */
        $this->assertTrue($tokenD->isA('T_OPERATOR'));
        $this->assertFalse($tokenD->isA('T_NUMBER'));
        /* Token E */
        $this->assertTrue($tokenE->isA('T_NUMBER'));
        $this->assertFalse($tokenE->isA('T_OPERATOR'));
    }

    public function testOperators()
    {
        $lexer = new Hazel\Calculator\Lexer();
        /* Afirmações */
        /* Operador de Soma */
        $token = $lexer->clear()->read('+')->getToken();
        $this->assertTrue($token->isA('T_OPERATOR'));
        $this->assertEquals('+', $token->getContent());
        /* Operador de Subtração */
        $token = $lexer->clear()->read('-')->getToken();
        $this->assertTrue($token->isA('T_OPERATOR'));
        $this->assertEquals('-', $token->getContent());
        /* Operador de Multiplicação */
        $token = $lexer->clear()->read('*')->getToken();
        $this->assertTrue($token->isA('T_OPERATOR'));
        $this->assertEquals('*', $token->getContent());
        /* Operador de Divisão */
        $token = $lexer->clear()->read('/')->getToken();
        $this->assertTrue($token->isA('T_OPERATOR'));
        $this->assertEquals('/', $token->getContent());
    }

    public function testPostfixParser()
    {
        $parser = new Hazel\Calculator\Parser();
        $lexer  = $parser->getLexer();

        /* Entrada */
        $lexer->clear()->read('1+1-1');
        $postfix = $parser->toPostfix();
        $lexer->rewind();
        $result  = '';
        foreach ($postfix as $token) {
            $result .= $token->getContent();
        }
        /* Afirmações */
        $this->assertEquals('11+1-', $result);
        $this->assertEquals(1, $parser->execute());

        /* Entrada */
        $lexer->clear()->read('2+6/3');
        $postfix = $parser->toPostfix();
        $lexer->rewind();
        $result = '';
        foreach ($postfix as $token) {
            $result .= $token->getContent();
        }
        /* Afirmações */
        $this->assertEquals('263/+', $result);
        $this->assertEquals(4, $parser->execute());
    }

    public function testSimpleInfix()
    {
        $parser = new Hazel\Calculator\Parser();
        /* Afirmações */
        /* Soma */
        $this->assertEquals(2, $parser->parse('1+1'));
        $this->assertEquals(3, $parser->parse('1+2'));
        $this->assertEquals(4, $parser->parse('2+2'));
        /* Subtração */
        $this->assertEquals(0, $parser->parse('1-1'));
        $this->assertEquals(1, $parser->parse('2-1'));
        $this->assertEquals(2, $parser->parse('4-2'));
        /* Multiplicação */
        $this->assertEquals(0, $parser->parse('0*0'));
        $this->assertEquals(1, $parser->parse('1*1'));
        $this->assertEquals(2, $parser->parse('2*1'));
        $this->assertEquals(4, $parser->parse('2*2'));
        $this->assertEquals(6, $parser->parse('3*2'));
        /* Divisão */
        $this->assertEquals(1, $parser->parse('1/1'));
        $this->assertEquals(2, $parser->parse('4/2'));
        $this->assertEquals(2, $parser->parse('6/3'));
    }

    public function testDoubleInfix()
    {
        $parser = new Hazel\Calculator\Parser();
        /* Afirmações */
        /* Soma */
        $this->assertEquals(3, $parser->parse('1+1+1'));
        $this->assertEquals(4, $parser->parse('1+1+2'));
        $this->assertEquals(9, $parser->parse('2+3+4'));
        /* Subtração */
        $this->assertEquals(0, $parser->parse('8-7-1'));
        $this->assertEquals(5, $parser->parse('9-1-3'));
        $this->assertEquals(2, $parser->parse('7-2-3'));
        /* Multiplicação */
        $this->assertEquals(1, $parser->parse('1*1*1'));
        $this->assertEquals(6, $parser->parse('2*3*1'));
        $this->assertEquals(8, $parser->parse('2*2*2'));
        /* Divisão */
        $this->assertEquals(1, $parser->parse('1/1/1'));
        $this->assertEquals(2, $parser->parse('8/2/2'));
        $this->assertEquals(3, $parser->parse('9/3/1'));
    }

    public function testMultipleInfix()
    {
        $parser = new Hazel\Calculator\Parser();
        /* Afirmações */
        /* Soma e Subtração */
        $this->assertEquals(1, $parser->parse('1+1-1'));
        $this->assertEquals(4, $parser->parse('3+5-4'));
        $this->assertEquals(5, $parser->parse('8+2-5'));
        /* Soma e Multiplicação */
        $this->assertEquals(10, $parser->parse('2+4*2'));
        $this->assertEquals(15, $parser->parse('3+2*6'));
        $this->assertEquals(7, $parser->parse('1+3*2'));
        /* Soma e Divisão */
        $this->assertEquals(5, $parser->parse('2+6/2'));
        $this->assertEquals(8, $parser->parse('7+3/3'));
        $this->assertEquals(1, $parser->parse('0+5/5'));
        /* Subtração e Soma */
        $this->assertEquals(5, $parser->parse('1*4+1'));
        $this->assertEquals(18, $parser->parse('5*2+8'));
        $this->assertEquals(8, $parser->parse('2*3+2'));
        /* Subtração e Multiplicação */
        $this->assertEquals(2, $parser->parse('5-1*3'));
        $this->assertEquals(1, $parser->parse('7-2*3'));
        $this->assertEquals(7, $parser->parse('9-2*1'));
        /* Subtração e Divisão */
        $this->assertEquals(4, $parser->parse('9-5/1'));
        $this->assertEquals(6, $parser->parse('8-6/3'));
        $this->assertEquals(1, $parser->parse('3-8/4'));
        /* Multiplicação e Soma */
        $this->assertEquals(7, $parser->parse('2*3+1'));
        $this->assertEquals(8, $parser->parse('1*4+4'));
        $this->assertEquals(4, $parser->parse('3*4-8'));
        /* Multiplicação e Subtração */
        $this->assertEquals(5, $parser->parse('2*3-1'));
        $this->assertEquals(4, $parser->parse('4*2-4'));
        $this->assertEquals(0, $parser->parse('9*1-9'));
        /* Multiplicação e Divisão */
        $this->assertEquals(1, $parser->parse('4/2/2'));
        $this->assertEquals(3, $parser->parse('9/3/1'));
        $this->assertEquals(1, $parser->parse('6/3/2'));
        /* Divisão e Soma */
        $this->assertEquals(5, $parser->parse('3/1+2'));
        $this->assertEquals(6, $parser->parse('5/5+5'));
        $this->assertEquals(5, $parser->parse('8/2+1'));
        /* Divisão e Subtração */
        $this->assertEquals(0, $parser->parse('9/3-3'));
        $this->assertEquals(1, $parser->parse('8/4-1'));
        $this->assertEquals(2, $parser->parse('6/2-1'));
        /* Divisão e Multiplicação */
        $this->assertEquals(6, $parser->parse('9/3*2'));
        $this->assertEquals(6, $parser->parse('6/2*2'));
        $this->assertEquals(2, $parser->parse('6/3*1'));
    }

    public function testGeometrics()
    {
        $parser = new Hazel\Calculator\Parser();
        /* Afirmações */
        /* Exponenciação */
        $this->assertEquals(8, $parser->parse('2^3'));
        $this->assertEquals(1, $parser->parse('1^9'));
        $this->assertEquals(0, $parser->parse('0^1'));
        /* Radiciação */
        $this->assertEquals(2, $parser->parse('4#2'));
        $this->assertEquals(3, $parser->parse('9#2'));
        $this->assertEquals(2, $parser->parse('8#3'));
        /* Exponenciação e Soma */
        $this->assertEquals(9, $parser->parse('2^3+1'));
        $this->assertEquals(2, $parser->parse('3^0+1'));
        /* Exponenciação e Subtração */
        $this->assertEquals(0, $parser->parse('2^2-4'));
        $this->assertEquals(4, $parser->parse('3^2-5'));
        /* Exponenciação e Multiplicação */
        $this->assertEquals(8, $parser->parse('2^2*2'));
        $this->assertEquals(4, $parser->parse('2^3-4'));
        /* Exponenciação e Divisão */
        $this->assertEquals(3, $parser->parse('3^2/3'));
        $this->assertEquals(4, $parser->parse('2^3/2'));
        /* Exponenciação e Radiciação */
        $this->assertEquals(2, $parser->parse('2^2#2'));
        $this->assertEquals(3, $parser->parse('3^9#9'));
        /* Soma e Exponenciação */
        $this->assertEquals(9, $parser->parse('1+2^3'));
        $this->assertEquals(5, $parser->parse('2+3^1'));
        /* Subtração e Exponenciação */
        $this->assertEquals(1, $parser->parse('9-2^3'));
        $this->assertEquals(5, $parser->parse('9-2^2'));
        /* Multiplicação e Exponenciação */
        $this->assertEquals(8, $parser->parse('2*2^2'));
        $this->assertEquals(0, $parser->parse('0*3^2'));
        /* Divisão e Exponenciação */
        $this->assertEquals(1, $parser->parse('9/3^2'));
        $this->assertEquals(1, $parser->parse('8/2^3'));
        /* Radiciação e Exponenciação */
        $this->assertEquals(8, $parser->parse('4#2^3'));
        $this->assertEquals(1, $parser->parse('9#2^0'));
        /* Exponenciação e Exponenciação */
        $this->assertEquals(1, $parser->parse('3^2^0'));
        $this->assertEquals(25, $parser->parse('5^1^2'));
    }

    public function testBrackets()
    {
        $parser = new Hazel\Calculator\Parser();
        $lexer  = $parser->getLexer();

        /* Verificação de Tokens */
        $lexer->read('()');
        $tokenA = $lexer->getToken();
        $tokenB = $lexer->getToken();
        /* Afirmações */
        $this->assertTrue($tokenA->isA('T_OB'));
        $this->assertEquals('(', $tokenA->getContent());
        $this->assertTrue($tokenB->isA('T_CB'));
        $this->assertEquals(')', $tokenB->getContent());

        /* Análise Sintática */
        $lexer->clear()->read('1*(2+3)');
        $postfix = $parser->toPostfix();
        $result  = '';
        foreach ($postfix as $token) {
            $result .= $token->getContent();
        }
        $lexer->rewind();
        $this->assertEquals('123+*', $result);
        $this->assertEquals(5, $parser->execute());

        /* Multiplicação e Soma */
        $this->assertEquals(26, $parser->parse('(2*3)+(4*5)'));
        /* Radiciação e Exponenciação */
        $this->assertEquals(10, $parser->parse('5*(7+1)#3'));
    }

    public function testWhitespace()
    {
        $parser = new Hazel\Calculator\Parser();
        /* Afirmações */
        $this->assertEquals(55, $parser->parse("1 + 2\t*\n3^ \t (2+1 )"));
    }

    public function testFloat()
    {
        /* Análise Léxica */
        $parser = new Hazel\Calculator\Parser();
        $lexer = $parser->getLexer();
        $lexer->read('1.1 + 2');

        /* Captura de Tokens */
        $tokenA = $lexer->getToken();
        $tokenB = $lexer->getToken();
        $tokenC = $lexer->getToken();
        /* Afirmações */
        $this->assertTrue($tokenA->isA('T_FLOAT'));
        $this->assertTrue($tokenB->isA('T_OPERATOR'));
        $this->assertTrue($tokenC->isA('T_NUMBER'));

        /* Análise Sintática */
        $this->assertEquals(3.1, $parser->parse('1.1+2'));
        $this->assertEquals(1.44, $parser->parse('1.2^2'));
        $this->assertEquals(4, $parser->parse('2#0.5'));
    }

    public function testAssign()
    {
        /* Análise Léxica */
        $parser = new Hazel\Calculator\Parser();
        $lexer = $parser->getLexer();
        $token = $lexer->read('=')->getToken();
        $this->assertTrue($token->isA('T_ASSIGN'));

        /* Análise Sintática */
        $lexer->clear()->read('$var = 1');
        $postfix = $parser->toPostfix();
        $result = '';
        foreach ($postfix as $token) {
            $result .= $token->getContent();
        }
        $this->assertEquals('$var1=', $result);

        /* Análise Sintática */
        $lexer->clear()->read('$var=2*3+1');
        $postfix = $parser->toPostfix();
        $result = '';
        foreach ($postfix as $token) {
            $result .= $token->getContent();
        }
        $this->assertEquals('$var23*1+=', $result);
    }

    public function testVariable()
    {
        /* Análise Léxica */
        $parser = new Hazel\Calculator\Parser();
        $lexer = $parser->getLexer();
        $lexer->read('$a+1');

        /* Captura de Tokens */
        $tokenA = $lexer->getToken();
        $tokenB = $lexer->getToken();
        $tokenC = $lexer->getToken();
        /* Afirmações */
        $this->assertTrue($tokenA->isA('T_VAR'));
        $this->assertTrue($tokenB->isA('T_OPERATOR'));
        $this->assertTrue($tokenC->isA('T_NUMBER'));
        /* Nomeação */
        $this->assertEquals('$a', $tokenA->getContent());

        /* Análise Sintática */
        $parser->setValue('$var', '1');
        $this->assertEquals(1, $parser->parse('$var'));
        $this->assertEquals(7, $parser->parse('(10+5)/3+$var*2'));

        /* Inferência */
        $this->assertEquals(2, $parser->parse('$var = 2'));
        $this->assertEquals(5, $parser->parse('$var = 1 + ($var * 2)'));
        $this->assertEquals(5, $parser->parse('$var'));
    }

    public function testDefinition()
    {
        $parser = new Hazel\Calculator\Parser();
        $lexer = $parser->getLexer();

        /* Análise Léxica */
        $token = $lexer->read('\\mul')->getToken();
        $this->assertTrue($token->isA('T_DEF'));
        $this->assertEquals('\\mul', $token->getContent());

        /* Analise Léxica */
        $token = $lexer->clear()->read('{1+1}')->getToken();
        $this->assertTrue($token->isA('T_BLOCKDEF'));
        $this->assertEquals('{1+1}', $token->getContent());
    }
}