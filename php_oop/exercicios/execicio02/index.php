<?php

/* 
1. Criar uma classe Humanos.

2. A classe deve ter 3 propriedades privadas onde 
   vamos guardar masculinos, femininos e desconhecidos

3. No método definir() devemos passar dois argumentos:
   sexo e nome.
   O método deverá implementar a lógica para construir
   as coleções de homens, mulheres e desconhecidos

4. Deverá implementar 3 métodos, cada um deles para
   devolver a coleção de nomes masculinos, femininos e desconhecidos

5. Neste script já existem, uma coleção de dados.
   Deverás importar a classe Humanos, instanciar num objeto $humanos.
   Iterar por todos os elementos da coleção $dados e passar a informação
   para dentro do objeto $humanos.

6. Finalmente, criar uma estrutura básica de HTML dentro do script
   e apresentar um título h1 para cada tipo de identidade e uma
   lista desordenada que vai apresentar cada um dos nomes de cada
   entidade colecionada (masculinos, femininos e desconhecidos)

   Deves separar cada uma das coleções com uma horizontal rule

   NOTA: m ou M = masculino
         f ou F = feminino
         outros... desconhecido
*/

require('classe.php');

$dados = [
   ['m', 'João Ribeiro'],
   ['f', 'Ana Silva'],
   ['M', 'Carlos Martins'],
   ['m', 'Joaquim Santos'],
   ['f', 'Marta Rodrigues'],
   ['M', 'Rui Fernandes'],
   ['F', 'Márcia Antunes'],
   ['g', 'Pantufa'],
   ['f', 'Carla Maria'],
   ['M', 'Fernando Joaquim'],
   ['m', 'Ricardo Moita'],
   ['c', 'Lassie'],
   ['F', 'Daniela Cardoso'],
   ['F', 'Susana Dinis'],
];

$humanos = new Humanos();

foreach ($dados as $item) {
   $sexo = $item[0];
   $nome = $item[1];
   $humanos->definir($sexo, $nome);
}

function exibir($array)
{
   foreach ($array as $nome) {
      echo '<li>Nome: ' . $nome . '</li>';
   }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Exercício 2</title>
</head>

<body>
   <h1>Masculinos</h1>
   <ul>
      <?php exibir($humanos->exibir_masculino()); ?>
   </ul>
   <br>
   <hr><br>
   <h1>Femininos</h1>
   <ul><?php exibir($humanos->exibir_feminino()); ?></ul>
   <br>
   <hr><br>
   <h1>Desconhecidos</h1>
   <ul><?php exibir($humanos->exibir_desconhecido()); ?></ul>
</body>

</html>