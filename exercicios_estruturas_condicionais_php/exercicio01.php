<?php

/* Usando como ponto de partida o array de produtos,
apresente no HTML uma unordenered list (ul) contendo
todos os produtos do array*/

$produtos = ['arroz', 'batata', 'laranja'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercícios 1</title>
</head>

<body>

    <ul>
        <li>
            <?php echo $produtos[0] ?>
        </li>
        <li>
            <?php echo $produtos[1] ?>
        </li>
        <li>
            <?php echo $produtos[2] ?>
        </li>
    </ul>



</body>

</html>