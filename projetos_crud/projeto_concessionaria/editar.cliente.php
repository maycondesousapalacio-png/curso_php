<?php
include('conexao.php');
$id = $_REQUEST['id'] ?? '';
$sql = "SELECT * FROM cliente WHERE idcliente = $id";
$res = $conn->query($sql);
$row = $res->fetch_object();
?>

<div class="card">
    <div class="card-header">
        <h2>Editar Cliente</h2>
    </div>
    <div class="card-body">
        <form action="?page=salvar-cliente" method="POST">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id" value="<?php echo $row->idcliente; ?>">
            <div class="mb-3">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $row->nome_cliente; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" name="cpf" value="<?php echo $row->cpf_cliente; ?>">
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $row->email_cliente; ?>">
            </div>
            <div class="mb-3">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" name="telefone" value="<?php echo $row->telefone_cliente; ?>">
            </div>
            <div class="mb-3">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" name="endereco" value="<?php echo $row->endereco_cliente; ?>">
            </div>
            <div class="mb-3">
                <label for="dt_nasc">Data de Nascimento:</label>
                <input type="date" class="form-control" name="dt_nasc" value="<?php echo $row->dt_nasc_cliente; ?>">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>