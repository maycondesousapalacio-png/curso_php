<?php
/*Constrói um array com todos os resultados da tabuada do 327.
e apresente os dados do array com um ciclo foreach (apenas valores)*/

$resultados = [];

for ($i = 0; $i <= 10; $i++) {
    array_push($resultados, 237 * $i);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 3</title>
</head>

<body>
    <?php foreach ($resultados as $resultado): ?>
        <p><?= $resultado ?></p>
    <?php endforeach; ?>
</body>

</html>