<?php
/*Apresente a frase abaixo 10 vezes, com uma capacidade cada vez MENOR até ser quase invisível

É um exerciício de utilização de um ciclo para repetir um texto e, ao mesmo tempo
alterar o valor da opacidade do estilo de letra.

Deve usar o atributo style para o efeito visual*/

$frase = "Esta frase vai aparecer com diferentes opacidades"
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 6</title>
</head>

<body>

    <?php for ($i = 10; $i >= 0; $i--): ?>
        <p style="opacity:<?= $i / 10 ?>;"><?= $frase ?></p>
    <?php endfor; ?>
</body>

</html>