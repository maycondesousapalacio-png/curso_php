<?php
include('conexao.php');

$tipo = $_GET['tipo'] ?? '';
$id = $_GET['id'] ?? '';

if (empty($tipo) || empty($id)) {
    print "<script>alert('Parâmetros inválidos!');</script>";
    print "<script>location.href='?page=listar-$tipo';</script>";
    exit;
}

// Mapeamento dos tipos para tabelas e redirecionamentos
$mapeamento = [
    'funcionario' => [
        'tabela' => 'funcionario',
        'id' => 'idfuncionario',
        'redirect' => 'listar-funcionario'
    ],
    'cliente' => [
        'tabela' => 'cliente',
        'id' => 'idcliente',
        'redirect' => 'listar-cliente'
    ],
    'marca' => [
        'tabela' => 'marca',
        'id' => 'idmarca',
        'redirect' => 'listar-marca'
    ],
    'modelo' => [
        'tabela' => 'modelo',
        'id' => 'idmodelo',
        'redirect' => 'listar-modelo'
    ],
    'venda' => [
        'tabela' => 'venda',
        'id' => 'idvenda', // Para venda, usamos apenas o idvenda mesmo com chave composta
        'redirect' => 'listar-venda'
    ]
];

if (!isset($mapeamento[$tipo])) {
    print "<script>alert('Tipo inválido!');</script>";
    print "<script>location.href='index.php';</script>";
    exit;
}

$config = $mapeamento[$tipo];

// Para a tabela venda com chave primária composta, usamos apenas idvenda
$sql = "DELETE FROM {$config['tabela']} WHERE {$config['id']} = $id";
$res = $conn->query($sql);

if ($res == true) {
    print "<script>alert('{$tipo} excluído com sucesso!');</script>";
    print "<script>location.href='?page={$config['redirect']}';</script>";
} else {
    // Verifica se é erro de chave estrangeira
    if ($conn->errno == 1451) {
        print "<script>alert('Não é possível excluir este registro pois existem registros relacionados!');</script>";
    } else {
        print "<script>alert('Erro ao excluir: " . $conn->error . "');</script>";
    }
    print "<script>location.href='?page={$config['redirect']}';</script>";
}
