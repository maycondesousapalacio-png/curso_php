<?php
session_start();
if (!empty($_SESSION["erro"])) {
    $erro = $_SESSION["erro"];
    unset($_SESSION["erro"]);
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício Multiplicação</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .erro {
            color: red;
        }
    </style>
</head>

<body>
    <form action="tratamento.php" method="post">
        <h2>Multiplicação</h2>
        <label for="num1">Primeiro Número:</label>
        <input type="text" name="num1" id="num1">
        <label for="num2">Segundo Número:</label>
        <input type="text" name="num2" id="num2">
        <?php if (!empty($erro)): ?>
            <p class="erro"><?= $erro ?></p>


        <?php endif; ?>

        <input type="submit">

    </form>
</body>

</html>