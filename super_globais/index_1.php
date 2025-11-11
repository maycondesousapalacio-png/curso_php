<?php

// SUPER GLOBAIS
/*
São variáveis em forma de arrays que estão sempre disponíveis
durante a execução do código e às quais podemos aceder e manipular
em qualquer escopo da aplicação. 
*/

/*
Vejamos o exemplo de uma variável que pode ser usada dentro
de uma função. Neste caso, todas as variáveis que têm um escopo
global podem ser acedidas através da super global $GLOBALS
*/

$nome = "joao";

apresentar();

echo $nome . '<br>';
echo $apelido;

function apresentar(){
    global $nome;
    echo $nome . '<br>';

    // ou

    echo $GLOBALS['nome'] . '<br>';

    // podemos alterar o valor da variável global.
    $GLOBALS['nome'] = "carlos";
    $GLOBALS['apelido'] = 'ribeiro';

    // IMPORTANTE: Existem algumas alterações que não podemos fazer
    // como por exemplo:
    // $GLOBALS = [];
}