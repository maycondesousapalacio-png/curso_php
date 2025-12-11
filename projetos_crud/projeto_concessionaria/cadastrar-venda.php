<?php
include('conexao.php');
$sql_clientes = "SELECT * FROM cliente";
$res_clientes = $conn->query($sql_clientes);

$sql_funcionarios = "SELECT * FROM funcionario";
$res_funcionarios = $conn->query($sql_funcionarios);

$sql_modelos = "SELECT m.*, ma.nome_marca FROM modelo m 
                INNER JOIN marca ma ON m.marca_idmarca = ma.idmarca";
$res_modelos = $conn->query($sql_modelos);
?>

<div class="card">
    <div class="card-header">
        <h2>Cadastrar Venda</h2>
    </div>
    <div class="card-body">
        <form action="?page=salvar-venda" method="POST">
            <input type="hidden" name="acao" value="cadastrar">
            <div class="mb-3">
                <label for="data_venda">Data da Venda:</label>
                <input type="date" class="form-control" name="data_venda" required>
            </div>
            <div class="mb-3">
                <label for="valor_venda">Valor da Venda:</label>
                <input type="number" step="0.01" class="form-control" name="valor_venda" required>
            </div>
            <div class="mb-3">
                <label for="cliente_id">Cliente:</label>
                <select class="form-control" name="cliente_id" required>
                    <option value="">Selecione um cliente</option>
                    <?php while ($cliente = $res_clientes->fetch_object()): ?>
                        <option value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nome_cliente; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="funcionario_id">Funcionário:</label>
                <select class="form-control" name="funcionario_id" required>
                    <option value="">Selecione um funcionário</option>
                    <?php while ($funcionario = $res_funcionarios->fetch_object()): ?>
                        <option value="<?php echo $funcionario->idfuncionario; ?>"><?php echo $funcionario->nome_funcionario; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="modelo_id">Modelo:</label>
                <select class="form-control" name="modelo_id" required>
                    <option value="">Selecione um modelo</option>
                    <?php while ($modelo = $res_modelos->fetch_object()): ?>
                        <option value="<?php echo $modelo->idmodelo; ?>">
                            <?php echo $modelo->nome_marca . " - " . $modelo->nome_modelo . " (" . $modelo->ano_modelo . ")"; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>
</div>