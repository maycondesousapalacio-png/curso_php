<?php
include('conexao.php');

$acao = $_POST['acao'];
$nome = $_POST['nome'];

if ($acao == 'cadastrar') {
    $sql = "INSERT INTO marca (nome_marca) VALUES ('$nome')";
    $mensagem = 'Marca cadastrada com sucesso!';
} else {
    $id = $_POST['id'];
    $sql = "UPDATE marca SET nome_marca = '$nome' WHERE idmarca = $id";
    $mensagem = 'Marca atualizada com sucesso!';
}

$res = $conn->query($sql);

if ($res == true) {
    print "<script>alert('$mensagem');</script>";
    print "<script>location.href='?page=listar-marca';</script>";
} else {
    print "<script>alert('Erro ao salvar!');</script>";
    print "<script>location.href='?page=listar-marca';</script>";
}
