<?php

class Factorial
{
    private $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function execute()
    {
        $answer = 1;
        $x = 1;
        while ($x <= $this->input) {
            $answer = $answer * $x;
            $x = $x + 1;
        }
        return $answer;
    }
}

$f = new Factorial(10);
$result = $f->execute();