<?php
include('conexao.php');

$acao = $_POST['acao'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];

if ($acao == 'cadastrar') {
    $sql = "INSERT INTO funcionario (nome_funcionario, telefone_funcionario, email_funcionario) 
            VALUES ('$nome', '$telefone', '$email')";
    $mensagem = 'Funcionário cadastrado com sucesso!';
} else {
    $id = $_POST['id'];
    $sql = "UPDATE funcionario SET 
            nome_funcionario = '$nome',
            telefone_funcionario = '$telefone',
            email_funcionario = '$email'
            WHERE idfuncionario = $id";
    $mensagem = 'Funcionário atualizado com sucesso!';
}

$res = $conn->query($sql);

if ($res == true) {
    print "<script>alert('$mensagem');</script>";
    print "<script>location.href='?page=listar-funcionario';</script>";
} else {
    print "<script>alert('Erro ao salvar!');</script>";
    print "<script>location.href='?page=listar-funcionario';</script>";
}
