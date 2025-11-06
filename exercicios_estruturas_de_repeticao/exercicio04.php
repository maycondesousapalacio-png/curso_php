<?php
/*Dada a coleção de nomes, apresente toda a coleção exceto o nome cujo
índice = 4 (Maria)*/

$nomes = ['joão', 'ana', 'carlos', 'marco', 'maria', 'silvia', 'helena', 'ricardo'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 4</title>
</head>

<body>
    <?php $i = 0;
    while ($i < count($nomes)):
        if ($i == 4) {
            $i++;
            continue;
        } ?>
        <p><?= $nomes[$i] ?> </p>
        <?php $i++; ?>
    <?php endwhile; ?>
</body>

</html>