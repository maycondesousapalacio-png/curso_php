<?php
include('conexao.php');

$acao = $_POST['acao'];
$nome = $_POST['nome'];
$cor = $_POST['cor'];
$ano = $_POST['ano'];
$tipo = $_POST['tipo'];
$marca_id = $_POST['marca_id'];

if ($acao == 'cadastrar') {
    $sql = "INSERT INTO modelo (nome_modelo, cor_modelo, ano_modelo, tipo_modelo, marca_idmarca) 
            VALUES ('$nome', '$cor', '$ano', '$tipo', '$marca_id')";
    $mensagem = 'Modelo cadastrado com sucesso!';
} else {
    $id = $_POST['id'];
    $sql = "UPDATE modelo SET 
            nome_modelo = '$nome',
            cor_modelo = '$cor',
            ano_modelo = '$ano',
            tipo_modelo = '$tipo',
            marca_idmarca = '$marca_id'
            WHERE idmodelo = $id";
    $mensagem = 'Modelo atualizado com sucesso!';
}

$res = $conn->query($sql);

if ($res == true) {
    print "<script>alert('$mensagem');</script>";
    print "<script>location.href='?page=listar-modelo';</script>";
} else {
    print "<script>alert('Erro ao salvar!');</script>";
    print "<script>location.href='?page=listar-modelo';</script>";
}
