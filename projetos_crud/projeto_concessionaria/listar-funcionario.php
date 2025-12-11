<?php
include('conexao.php');
$sql = "SELECT * FROM funcionario";
$res = $conn->query($sql);
$qtd = $res->num_rows;
?>

<div class="card">
    <div class="card-header">
        <h2>Listar Funcionários</h2>
    </div>
    <div class="card-body">
        <?php if ($qtd > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $res->fetch_object()): ?>
                        <tr>
                            <td><?php echo $row->idfuncionario; ?></td>
                            <td><?php echo $row->nome_funcionario; ?></td>
                            <td><?php echo $row->telefone_funcionario; ?></td>
                            <td><?php echo $row->email_funcionario; ?></td>
                            <td>
                                <a href="?page=editar-funcionario&id=<?php echo $row->idfuncionario; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <button onclick="confirmarExclusao(<?php echo $row->idfuncionario; ?>, 'funcionario')" class="btn btn-danger btn-sm">Excluir</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-danger">Não encontrou resultados!</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function confirmarExclusao(id, tipo) {
        if (confirm('Tem certeza que deseja excluir este ' + tipo + '?')) {
            window.location.href = '?page=excluir&tipo=' + tipo + '&id=' + id;
        }
    }
</script>