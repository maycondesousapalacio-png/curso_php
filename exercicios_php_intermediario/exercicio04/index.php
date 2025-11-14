<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valor = $_POST['valor'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 4</title>
    <style>
        .vermelho {
            color: red;
        }

        .verde {
            color: green;
        }
    </style>
</head>

<body>
    <form action="index.php" method="post">
        <input type="text" name="valor">
        <input type="submit">
    </form>
    <?php if ($_POST['valor'] == ''): ?>
        <p class="vermelho">Campo de texto vazio</p>
    <?php elseif (is_numeric($valor)):
        file_put_contents('dados_numericos.txt', $valor . PHP_EOL, FILE_APPEND); ?>
        <P class="verde">Valor numérico guardado com sucesso.</P>
    <?php elseif (is_string($valor)):
        file_put_contents('dados_string.txt', $valor . PHP_EOL, FILE_APPEND); ?>
        <p class="verde">Valor string guardado com sucesso.</p>
    <?php endif; ?>

</body>

</html>