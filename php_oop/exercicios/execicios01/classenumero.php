<?php
class class_numero
{
    private $numero;

    function __construct($num)
    {
        $this->numero = $num;
    }

    function get_numero()
    {
        $num = $this->numero;
        return $num;
    }

    function par_ou_impar()
    {
        $num = $this->numero;
        if ($num % 2 == 0) {
            return "O número é Par";
        } else {
            return "O número é Ímpar";
        }
    }

    function tabuada()
    {
        $tabuada = [];
        for ($i = 0; $i <= 10; $i++) {
            array_push($tabuada, $this->numero . " x " . $i . " = " . $this->numero * $i);
        }
        return $tabuada;
    }

    function raiz_quadrada()
    {
        return $this->numero * $this->numero;
    }
}
