<?php
class carro
{
    public $nome;
}

$gol = new carro();
$gol->nome = "Gol";

$celta = new carro();
$celta->nome = "Celta";
echo $gol->nome;
echo '<br>' . $celta->nome;

class carro2
{
    public $nome;
    public $cor;
    public $ano;

    public function apresentar_carro()
    {
        return "O nome do carro é {$this->nome}, a cor é {$this->cor} e o ano é {$this->ano}";
    }
}

$voyage = new carro2();
$voyage->nome = "Voyage";
$voyage->cor = "Prata";
$voyage->ano = "2012";

echo '<br>' . $voyage->apresentar_carro();
