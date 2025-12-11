<?php
include('conexao.php');

$acao = $_POST['acao'];
$data_venda = $_POST['data_venda'];
$valor_venda = $_POST['valor_venda'];
$cliente_id = $_POST['cliente_id'];
$funcionario_id = $_POST['funcionario_id'];
$modelo_id = $_POST['modelo_id'];

if ($acao == 'cadastrar') {
    $sql = "INSERT INTO venda (data_venda, valor_venda, cliente_idcliente, funcionario_idfuncionario, modelo_idmodelo) 
            VALUES ('$data_venda', '$valor_venda', '$cliente_id', '$funcionario_id', '$modelo_id')";
    $mensagem = 'Venda cadastrada com sucesso!';
} else {
    $id = $_POST['id'];
    $sql = "UPDATE venda SET 
            data_venda = '$data_venda',
            valor_venda = '$valor_venda',
            cliente_idcliente = '$cliente_id',
            funcionario_idfuncionario = '$funcionario_id',
            modelo_idmodelo = '$modelo_id'
            WHERE idvenda = $id";
    $mensagem = 'Venda atualizada com sucesso!';
}

$res = $conn->query($sql);

if ($res == true) {
    print "<script>alert('$mensagem');</script>";
    print "<script>location.href='?page=listar-venda';</script>";
} else {
    print "<script>alert('Erro ao salvar!');</script>";
    print "<script>location.href='?page=listar-venda';</script>";
}
