<?php

function divisao($valor1, $valor2)
{
    if ($valor2 == 0) {
        return null;
    }
    return $valor1 / $valor2;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Nível 1 - Exercício 02</title>
</head>

<body>

    <?php for ($i = 0; $i <= 20; $i++) : ?>

        <?php
        $valor1 = rand(0, 10);
        $valor2 = rand(0, 10);
        ?>
        <?php
        $resultado = divisao($valor1, $valor2);
        if ($resultado == null): ?>
            <h2><?= $valor1 . '/' . $valor2 . ' =  Divisão por zero' ?></h2>

        <?php else: ?>
            <h2><?= $valor1 . '/' . $valor2 . ' = ' . $resultado ?></h2>
        <?php endif; ?>



    <?php endfor; ?>


</body>

</html>