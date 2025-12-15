<?php

/* 
O ficheiro dados.csv contém um conjunto de 40 linhas com informações sobre veículos.
Deves construir uma classe abstrata Veiculos que contém 3 propriedades protegidas:
tipo, marca e ano.
Essa classe deve ter um construtor que recebe cada uma das linhas do ficheiro CSV.
Deve ter também um método get_tipo() para devolver o valor de $tipo que é protegido.

Cria 3 classes derivadas de Veiculos: automovel, aviao e barco.

Cada uma das classes deve ter um método apresentar().
Esse método devolve uma string com o seguinte formato:
    "Este objeto guarda os dados de um automóvel da marca [marca], do ano [ano]"
    "Este objeto guarda os dados de um avião da marca [marca], do ano [ano]"
    "Este objeto guarda os dados de um barco da marca [marca], do ano [ano]"

Cria um array vazio Veiculos. Ele vai guardar uma coleção de diferentes
objetos (automovel, aviao e barco).
Cada uma das linhas do ficheiro CSV deverá ser carregada, analisada e,
consoante o tipo, adicionada ao array Veiculos como um novo objeto do tipo
correto.

No final, apresenta as frases criadas pelo método apresentar, de cada um
dos objetos da coleção veiculos.
Tudo isto dentro de um layout de HTML com um h1 para cada tipo de veiculo
e uma lista não ordenada para cada frase.
*/

require_once('classes.php');

$veiculos = [];

$files = fopen('dados.csv', 'r');
while (!feof($files)) {
    $linha = fgetcsv($files);
    if ($linha[0] == 'automovel') {
        $automovel = new Automovel($linha);
        $veiculos[] = $automovel;
    } else if ($linha[0] == 'aviao') {
        $aviao = new Aviao($linha);
        $veiculos[] = $aviao;
    } else if ($linha[0] == 'barco') {
        $barco = new Barco($linha);
        $veiculos[] = $barco;
    }
}
fclose($files);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 3</title>
</head>

<body>
    <h1>Automóvel</h1>
    <ul>
        <?php foreach ($veiculos as $veiculo) :
            if ($veiculo->get_tipo() == 'automovel'): ?>
                <li><?php $veiculo->apresentar(); ?></li>
        <?php endif;
        endforeach; ?>
    </ul>

    <br>
    <hr><br>

    <h1>Avião</h1>
    <ul>
        <?php foreach ($veiculos as $veiculo) :
            if ($veiculo->get_tipo() == 'aviao'): ?>
                <li><?php $veiculo->apresentar(); ?></li>
        <?php endif;
        endforeach; ?>
    </ul>

    <br>
    <hr><br>

    <h1>Barco</h1>
    <ul>
        <?php foreach ($veiculos as $veiculo) :
            if ($veiculo->get_tipo() == 'barco'): ?>
                <li><?php $veiculo->apresentar(); ?></li>
        <?php endif;
        endforeach; ?>
    </ul>
</body>

</html>