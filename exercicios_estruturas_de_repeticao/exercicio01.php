<?php
/*Constrói uma apresentação HTML que mostra a tabuada do 5.*/

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 1</title>
</head>

<body>
    <?php for ($i = 0; $i <= 10; $i++): ?>
        <p>5 x <?= $i . " = " . 5 * $i ?> </p>
    <?php endfor; ?>
</body>

</html>