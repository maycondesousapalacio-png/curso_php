<?php
include('conexao.php');
$sql = "SELECT m.*, ma.nome_marca FROM modelo m 
        INNER JOIN marca ma ON m.marca_idmarca = ma.idmarca";
$res = $conn->query($sql);
$qtd = $res->num_rows;
?>

<div class="card">
    <div class="card-header">
        <h2>Listar Modelos</h2>
    </div>
    <div class="card-body">
        <?php if ($qtd > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cor</th>
                        <th>Ano</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $res->fetch_object()): ?>
                        <tr>
                            <td><?php echo $row->idmodelo; ?></td>
                            <td><?php echo $row->nome_modelo; ?></td>
                            <td><?php echo $row->cor_modelo; ?></td>
                            <td><?php echo $row->ano_modelo; ?></td>
                            <td><?php echo $row->tipo_modelo; ?></td>
                            <td><?php echo $row->nome_marca; ?></td>
                            <td>
                                <a href="?page=editar-modelo&id=<?php echo $row->idmodelo; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <button onclick="confirmarExclusao(<?php echo $row->idmodelo; ?>, 'modelo')" class="btn btn-danger btn-sm">Excluir</button>
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