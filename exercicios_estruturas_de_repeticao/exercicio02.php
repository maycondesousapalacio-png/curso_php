<?php
/*Constrói um array com todos os resultados da tabuada dos números 3,2 e 7.*/

$tabuadas = [];
for ($i = 0; $i <= 10; $i++) {
    $tabuadas[] = 2 * $i;
}
for ($i = 0; $i <= 10; $i++) {
    array_push($tabuadas, 3 * $i);
}
for ($i = 0; $i <= 10; $i++) {
    array_push($tabuadas, 7 * $i);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 2</title>
</head>

<body>
    <h2>Tabuada do 2</h2>
    <?php for ($i = 0; $i <= 10; $i++): ?>
        <p>2 x <?= $i . " = " . $tabuadas[$i] ?></p>
    <?php endfor; ?>
    <h2>Tabuada do 3</h2>
    <?php for ($i = 0; $i <= 10; $i++): ?>
        <p>3 x <?= $i . " = " . $tabuadas[$i + 11] ?></p>
    <?php endfor; ?>
    <h2>Tabuada do 7</h2>
    <?php for ($i = 0; $i <= 10; $i++): ?>
        <p>7 x <?= $i . " = " . $tabuadas[$i + 22] ?></p>
    <?php endfor; ?>

</body>

</html>