<?php
abstract class Veiculos
{
    protected $tipo;
    protected $marca;
    protected $ano;

    function __construct($linhacsv)
    {
        $this->tipo = $linhacsv[0];
        $this->marca = $linhacsv[1];
        $this->ano = $linhacsv[2];
    }
    function get_tipo()
    {
        return $this->tipo;
    }

    function get_ano()
    {
        return $this->ano;
    }
}

class Automovel extends Veiculos
{
    function apresentar()
    {
        echo 'Este objeto guarda os dados de um automóvel da marca ' . $this->marca . ', do ano ' . $this->ano;
    }
}
class Aviao extends Veiculos
{
    function apresentar()
    {
        echo 'Este objeto guarda os dados de um avião da marca ' . $this->marca . ', do ano ' . $this->ano;
    }
}
class Barco extends Veiculos
{
    function apresentar()
    {
        echo 'Este objeto guarda os dados de um barco da marca ' . $this->marca . ', do ano ' . $this->ano;
    }
}
