<?php

/* Usando como ponto de partida o array de produtos,
inverta a ordem dos mesmos, e acrescente no final
'maçã' e 'pêra' e apresente numa ul*/

$produtos = ['arroz', 'batata', 'laranja'];
$produtos = array_reverse($produtos)
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercícios 2</title>
</head>

<body>

    <?php array_push($produtos, 'maçã', 'batata');  ?>

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
        <li>
            <?php echo $produtos[3] ?>
        </li>
        <li>
            <?php echo $produtos[4] ?>
        </li>
    </ul>



</body>

</html>