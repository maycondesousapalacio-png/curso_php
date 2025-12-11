<?php
include('conexao.php');

$acao = $_POST['acao'];
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$dt_nasc = $_POST['dt_nasc'];

if ($acao == 'cadastrar') {
    $sql = "INSERT INTO cliente (nome_cliente, cpf_cliente, email_cliente, telefone_cliente, endereco_cliente, dt_nasc_cliente) 
            VALUES ('$nome', '$cpf', '$email', '$telefone', '$endereco', '$dt_nasc')";
    $mensagem = 'Cliente cadastrado com sucesso!';
} else {
    $id = $_POST['id'];
    $sql = "UPDATE cliente SET 
            nome_cliente = '$nome',
            cpf_cliente = '$cpf',
            email_cliente = '$email',
            telefone_cliente = '$telefone',
            endereco_cliente = '$endereco',
            dt_nasc_cliente = '$dt_nasc'
            WHERE idcliente = $id";
    $mensagem = 'Cliente atualizado com sucesso!';
}

$res = $conn->query($sql);

if ($res == true) {
    print "<script>alert('$mensagem');</script>";
    print "<script>location.href='?page=listar-cliente';</script>";
} else {
    print "<script>alert('Erro ao salvar!');</script>";
    print "<script>location.href='?page=listar-cliente';</script>";
}
