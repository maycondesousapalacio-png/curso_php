<?php
/*Este é um pequeno exemplo de como o OOP permite tornar o nosso código
mais bem organizado, mais profissional, mais estruturado.

1. Criar uma classe (class_numero)
2. A classe deverá ter uma propriedade privada número
3. O construtor da classe serve para definir o número
4. O método get_numero() serve para devolver o número
5. O método par_ou_impar deverá devolver 'par' ou 'impar' após analisar o número
6. O método tabuada deverá devolver um array com a tabuada do número até 10
7. O método raiz quadrada()deverá devolver a raiz quadrada do número
8. Neste script deveremos importar a classe, criar 4 objetos apartir dela
com os valores 5, 7, 16 e 123.
Para cada uma dessas instâncias, deveremos apresentar:
    a) O número através do get_numero()
    b) Se é par ou impar
    c) A raiz quadrada do número
    d) A tabuada do número*/
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício 1</title>
</head>

<body>
    <?php
    include('classenumero.php');

    $cinco = new class_numero(5);
    echo $cinco->get_numero() . "<br>";
    echo $cinco->par_ou_impar() . "<br>";
    echo $cinco->raiz_quadrada() . "<br>";
    foreach ($cinco->tabuada() as $linha) {
        echo $linha . "<br>";
    }

    echo "<br><hr><br>";

    $sete = new class_numero(7);
    echo $sete->get_numero() . "<br>";
    echo $sete->par_ou_impar() . "<br>";
    echo $sete->raiz_quadrada() . "<br>";
    foreach ($sete->tabuada() as $linha) {
        echo $linha . "<br>";
    }

    echo "<br><hr><br>";

    $dezesseis = new class_numero(16);
    echo $dezesseis->get_numero() . "<br>";
    echo $dezesseis->par_ou_impar() . "<br>";
    echo $dezesseis->raiz_quadrada() . "<br>";
    foreach ($dezesseis->tabuada() as $linha) {
        echo $linha . "<br>";
    }

    echo "<br><hr><br>";

    $cento_vinte_tres = new class_numero(123);
    echo $cento_vinte_tres->get_numero() . "<br>";
    echo $cento_vinte_tres->par_ou_impar() . "<br>";
    echo $cento_vinte_tres->raiz_quadrada() . "<br>";
    foreach ($cento_vinte_tres->tabuada() as $linha) {
        echo $linha . "<br>";
    }

    echo "<br><hr><br>";

    ?>
</body>

</html>