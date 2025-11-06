<?php
/*Dada a coleção de nomes, devem ser todos apresentados,
mas a partir de maria (inclusive) devem ser com o texto em vermelho*/

$nomes = ['joão', 'ana', 'carlos', 'marco', 'maria', 'silvia', 'helena', 'ricardo'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 5</title>
    <style>
        .vermelho {
            color: red;
        }
    </style>
</head>

<body>
    <?php foreach ($nomes as $valor => $nome) {
        if ($valor >= 4): ?>
            <p class="vermelho"><?= $nome ?></p>
        <?php continue;
        endif; ?>
        <p><?= $nome ?></p>
    <?php } ?>
</body>

</html>