<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "Acesso direto não permitido";
    die;
}

if (empty($_POST["num1"]) or empty($_POST["num2"])) {
    $_SESSION["erro"] = "Os dois campos são de preenchimento obrigatório.";
    header("Location: index.php");
    return;
}

$num1 = (int)$_POST["num1"];
$num2 = (int)$_POST["num2"];

if (!is_numeric($_POST["num1"]) or !is_numeric($_POST["num2"]) or $_POST["num1"] < 0 or $_POST["num2"] < 0) {
    $_SESSION["erro"] = "Pelo menos um dos valores informados não é um número positivo.";
    header("Location: index.php");
    return;
} else {
    $resultado = $num1 * $num2;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>RESULTADO</h1>
    <hr>
    <h2><?= $num1 . ' x ' . $num2 . ' = ' . $resultado ?></h2>
</body>

</html>