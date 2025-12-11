<?php
include('conexao.php');
$id = $_REQUEST['id'] ?? '';
$sql = "SELECT * FROM modelo WHERE idmodelo = $id";
$res = $conn->query($sql);
$row = $res->fetch_object();

$sql_marcas = "SELECT * FROM marca";
$res_marcas = $conn->query($sql_marcas);
?>

<div class="card">
    <div class="card-header">
        <h2>Editar Modelo</h2>
    </div>
    <div class="card-body">
        <form action="?page=salvar-modelo" method="POST">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id" value="<?php echo $row->idmodelo; ?>">
            <div class="mb-3">
                <label for="nome">Nome do Modelo:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $row->nome_modelo; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cor">Cor:</label>
                <input type="text" class="form-control" name="cor" value="<?php echo $row->cor_modelo; ?>">
            </div>
            <div class="mb-3">
                <label for="ano">Ano:</label>
                <input type="number" class="form-control" name="ano" value="<?php echo $row->ano_modelo; ?>" min="1900" max="2099">
            </div>
            <div class="mb-3">
                <label for="tipo">Tipo:</label>
                <input type="text" class="form-control" name="tipo" value="<?php echo $row->tipo_modelo; ?>">
            </div>
            <div class="mb-3">
                <label for="marca_id">Marca:</label>
                <select class="form-control" name="marca_id" required>
                    <option value="">Selecione uma marca</option>
                    <?php while ($marca = $res_marcas->fetch_object()): ?>
                        <option value="<?php echo $marca->idmarca; ?>" <?php echo ($marca->idmarca == $row->marca_idmarca) ? 'selected' : ''; ?>>
                            <?php echo $marca->nome_marca; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>