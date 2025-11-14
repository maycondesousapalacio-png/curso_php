<?php
$numeros_positivos = [];
$numeros_negativos = [];
$textos = [];
$textos_teste = [];
$file = fopen('dados.dat', 'r');
while (!feof($file)) {
    $linha = fgets($file);
    $linha = trim($linha);
    if (is_numeric($linha) and $linha > 0) {
        array_push($numeros_positivos, $linha);
    } elseif (is_numeric($linha) and $linha < 0) {
        array_push($numeros_negativos, $linha);
    } elseif (str_contains($linha, 'TESTE')) {
        array_push($textos_teste, $linha);
    } elseif (is_string($linha) and $linha != 0) {
        array_push($textos, $linha);
    }
}
fclose($file);

adicao($numeros_positivos, 'numeros_positivos.txt');
adicao($numeros_negativos, 'numeros_negativos.txt');
adicao($textos, 'textos.txt');
adicao($textos_teste, 'textos_teste.txt');

exibicao('numeros_positivos.txt');
exibicao('numeros_negativos.txt');
exibicao('textos.txt');
exibicao('textos_teste.txt');



function exibicao($arquivo)
{
    $dados = file_get_contents($arquivo);
    echo 'Arquivos em ' . $arquivo . '<br><br>';
    echo nl2br($dados);
    echo '<br><br>';
}

function adicao($array, $arquivo)
{
    for ($i = 0; $i < count($array); $i++) {
        file_put_contents($arquivo, $array[$i] . PHP_EOL, FILE_APPEND);
    }
}
