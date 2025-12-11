<?php
include('conexao.php');

$sql = "SELECT v.*, c.nome_cliente, f.nome_funcionario, mo.nome_modelo, ma.nome_marca 
        FROM venda v
        INNER JOIN cliente c ON v.cliente_idcliente = c.idcliente
        INNER JOIN funcionario f ON v.funcionario_idfuncionario = f.idfuncionario
        INNER JOIN modelo mo ON v.modelo_idmodelo = mo.idmodelo
        INNER JOIN marca ma ON mo.marca_idmarca = ma.idmarca";
$res = $conn->query($sql);

if ($res === false) {
    echo '
    <div class="alert alert-danger">
        <h4>Erro na consulta!</h4>
        <p>Erro: ' . $conn->error . '</p>
        <p>Possível problema com a estrutura da tabela venda.</p>
    </div>';
    exit;
}

$qtd = $res->num_rows;
?>

<div class="card">
    <div class="card-header">
        <h2>Listar Vendas</h2>
    </div>
    <div class="card-body">
        <?php if ($qtd > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Cliente</th>
                        <th>Funcionário</th>
                        <th>Modelo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $res->fetch_object()): ?>
                        <tr>
                            <td><?php echo $row->idvenda; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row->data_venda)); ?></td>
                            <td>R$ <?php echo number_format($row->valor_venda, 2, ',', '.'); ?></td>
                            <td><?php echo $row->nome_cliente; ?></td>
                            <td><?php echo $row->nome_funcionario; ?></td>
                            <td><?php echo $row->nome_marca . " " . $row->nome_modelo; ?></td>
                            <td>
                                <a href="?page=editar-venda&id=<?php echo $row->idvenda; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <button onclick="confirmarExclusao(<?php echo $row->idvenda; ?>, 'venda')" class="btn btn-danger btn-sm">Excluir</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">
                <p>Nenhuma venda cadastrada ainda.</p>
                <a href="?page=cadastrar-venda" class="btn btn-primary">Cadastrar Primeira Venda</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function confirmarExclusao(id, tipo) {
        if (confirm('Tem certeza que deseja excluir esta ' + tipo + '?')) {
            window.location.href = '?page=excluir&tipo=' + tipo + '&id=' + id;
        }
    }
</script>