<?php
include('conexao.php');
$id = $_REQUEST['id'] ?? '';
$sql = "SELECT * FROM marca WHERE idmarca = $id";
$res = $conn->query($sql);
$row = $res->fetch_object();
?>

<div class="card">
    <div class="card-header">
        <h2>Editar Marca</h2>
    </div>
    <div class="card-body">
        <form action="?page=salvar-marca" method="POST">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id" value="<?php echo $row->idmarca; ?>">
            <div class="mb-3">
                <label for="nome">Nome da Marca:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $row->nome_marca; ?>" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>