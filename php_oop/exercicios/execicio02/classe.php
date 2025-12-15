<?php class Humanos
{
    private $masculino = [];
    private $feminino = [];
    private $desconhecido = [];

    function definir($sexo, $nome)
    {
        if ($sexo == 'm' or $sexo == 'M') {
            $this->masculino[] = $nome;
        } elseif ($sexo == 'f' or $sexo == 'F') {
            $this->feminino[] = $nome;
        } else {
            $this->desconhecido[] = $nome;
        }
    }

    function exibir_masculino()
    {
        return $this->masculino;
    }
    function exibir_feminino()
    {
        return $this->feminino;
    }
    function exibir_desconhecido()
    {
        return $this->desconhecido;
    }
}
