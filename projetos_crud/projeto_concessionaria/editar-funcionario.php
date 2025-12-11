<?php
include('conexao.php');
$id = $_REQUEST['id'] ?? '';
$sql = "SELECT * FROM funcionario WHERE idfuncionario = $id";
$res = $conn->query($sql);
$row = $res->fetch_object();
?>

<div class="card">
    <div class="card-header">
        <h2>Editar Funcionário</h2>
    </div>
    <div class="card-body">
        <form action="?page=salvar-funcionario" method="POST">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id" value="<?php echo $row->idfuncionario; ?>">
            <div class="mb-3">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $row->nome_funcionario; ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" name="telefone" value="<?php echo $row->telefone_funcionario; ?>">
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $row->email_funcionario; ?>">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>