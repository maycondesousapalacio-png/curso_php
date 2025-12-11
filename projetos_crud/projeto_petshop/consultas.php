<?php
include 'config.php';
include 'consulta.php';
include 'cliente.php';
include 'funcionario.php';

$database = new Database();
$db = $database->getConnection();
$consulta = new Consulta($db);
$cliente = new Cliente($db);
$funcionario = new Funcionario($db);

$mensagem = "";

// Processar formulário
if ($_POST) {
    if (empty($_POST['id'])) {
        // Criar nova consulta
        $consulta->id_cliente = $_POST['id_cliente'];
        $consulta->id_funcionario = $_POST['id_funcionario'];
        $consulta->tipo = $_POST['tipo'];
        $consulta->data_consulta = $_POST['data_consulta'];
        $consulta->observacoes = $_POST['observacoes'];
        $consulta->status = $_POST['status'];

        if ($consulta->criar()) {
            $mensagem = "<div class='alert alert-success'>Consulta agendada com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao agendar consulta.</div>";
        }
    } else {
        // Atualizar consulta
        $consulta->id = $_POST['id'];
        $consulta->id_cliente = $_POST['id_cliente'];
        $consulta->id_funcionario = $_POST['id_funcionario'];
        $consulta->tipo = $_POST['tipo'];
        $consulta->data_consulta = $_POST['data_consulta'];
        $consulta->observacoes = $_POST['observacoes'];
        $consulta->status = $_POST['status'];

        if ($consulta->atualizar()) {
            $mensagem = "<div class='alert alert-success'>Consulta atualizada com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao atualizar consulta.</div>";
        }
    }
}

// Excluir consulta
if (isset($_GET['excluir'])) {
    $consulta->id = $_GET['excluir'];
    if ($consulta->excluir()) {
        $mensagem = "<div class='alert alert-success'>Consulta excluída com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao excluir consulta.</div>";
    }
}

// Atualizar status
if (isset($_GET['status'])) {
    $consulta->id = $_GET['id'];
    if ($consulta->atualizarStatus($_GET['status'])) {
        $mensagem = "<div class='alert alert-success'>Status atualizado com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao atualizar status.</div>";
    }
}

// Ler consulta para edição
$consulta_edicao = null;
if (isset($_GET['editar'])) {
    $consulta->id = $_GET['editar'];
    if ($consulta->lerUm()) {
        $consulta_edicao = $consulta;
    }
}

// Carregar listas para selects
$clientes = $cliente->ler();
$funcionarios = $funcionario->ler();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas - Petshop</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <div class="container">
            <h1>Petshop Sistema</h1>
            <ul class="nav-menu">
                <li><a href="index.php">Início</a></li>
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="funcionarios.php">Funcionários</a></li>
                <li><a href="consultas.php">Consultas</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <?php echo $mensagem; ?>

        <div class="card">
            <h2 class="section-title"><?php echo $consulta_edicao ? 'Editar' : 'Agendar'; ?> Consulta</h2>
            <form method="POST">
                <?php if ($consulta_edicao): ?>
                    <input type="hidden" name="id" value="<?php echo $consulta_edicao->id; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Cliente:</label>
                    <select name="id_cliente" class="form-control" required>
                        <option value="">Selecione o cliente</option>
                        <?php
                        if ($clientes->rowCount() > 0) {
                            while ($row = $clientes->fetch(PDO::FETCH_ASSOC)) {
                                $selected = ($consulta_edicao && $consulta_edicao->id_cliente == $row['id']) ? 'selected' : '';
                                echo "<option value='{$row['id']}' {$selected}>{$row['nome']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Funcionário:</label>
                    <select name="id_funcionario" class="form-control" required>
                        <option value="">Selecione o funcionário</option>
                        <?php
                        if ($funcionarios->rowCount() > 0) {
                            while ($row = $funcionarios->fetch(PDO::FETCH_ASSOC)) {
                                $selected = ($consulta_edicao && $consulta_edicao->id_funcionario == $row['id']) ? 'selected' : '';
                                echo "<option value='{$row['id']}' {$selected}>{$row['nome']} - {$row['funcao']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tipo de Serviço:</label>
                    <select name="tipo" class="form-control" required>
                        <option value="">Selecione o tipo</option>
                        <option value="banho" <?php echo ($consulta_edicao && $consulta_edicao->tipo == 'banho') ? 'selected' : ''; ?>>Banho</option>
                        <option value="tosa" <?php echo ($consulta_edicao && $consulta_edicao->tipo == 'tosa') ? 'selected' : ''; ?>>Tosa</option>
                        <option value="consulta veterinario" <?php echo ($consulta_edicao && $consulta_edicao->tipo == 'consulta veterinario') ? 'selected' : ''; ?>>Consulta Veterinário</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Data e Hora:</label>
                    <input type="datetime-local" name="data_consulta" class="form-control"
                        value="<?php echo $consulta_edicao ? str_replace(' ', 'T', substr($consulta_edicao->data_consulta, 0, 16)) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label>Observações:</label>
                    <textarea name="observacoes" class="form-control" rows="3"><?php echo $consulta_edicao ? $consulta_edicao->observacoes : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" class="form-control" required>
                        <option value="agendada" <?php echo ($consulta_edicao && $consulta_edicao->status == 'agendada') ? 'selected' : ''; ?>>Agendada</option>
                        <option value="realizada" <?php echo ($consulta_edicao && $consulta_edicao->status == 'realizada') ? 'selected' : ''; ?>>Realizada</option>
                        <option value="cancelada" <?php echo ($consulta_edicao && $consulta_edicao->status == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?php echo $consulta_edicao ? 'Atualizar' : 'Agendar'; ?>
                </button>

                <?php if ($consulta_edicao): ?>
                    <a href="consultas.php" class="btn btn-warning">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card">
            <h2 class="section-title">Lista de Consultas</h2>

            <div style="margin-bottom: 1rem;">
                <a href="consultas.php" class="btn btn-primary">Todas</a>
                <a href="consultas.php?filter=agendada" class="btn btn-warning">Agendadas</a>
                <a href="consultas.php?filter=realizada" class="btn btn-success">Realizadas</a>
                <a href="consultas.php?filter=cancelada" class="btn btn-danger">Canceladas</a>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Funcionário</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Filtrar consultas se solicitado
                    if (isset($_GET['filter'])) {
                        $stmt = $consulta->lerPorStatus($_GET['filter']);
                    } else {
                        $stmt = $consulta->ler();
                    }

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            $data_consulta = date('d/m/Y H:i', strtotime($data_consulta));

                            // Definir cor do status
                            $status_class = '';
                            switch ($status) {
                                case 'agendada':
                                    $status_class = 'btn-warning';
                                    break;
                                case 'realizada':
                                    $status_class = 'btn-success';
                                    break;
                                case 'cancelada':
                                    $status_class = 'btn-danger';
                                    break;
                            }

                            echo "<tr>";
                            echo "<td>{$id}</td>";
                            echo "<td>{$cliente_nome}</td>";
                            echo "<td>{$funcionario_nome}</td>";
                            echo "<td>" . ucfirst($tipo) . "</td>";
                            echo "<td>{$data_consulta}</td>";
                            echo "<td><span class='btn {$status_class}' style='padding: 0.25rem 0.5rem; font-size: 0.8rem;'>{$status}</span></td>";
                            echo "<td>";
                            echo "<a href='consultas.php?editar={$id}' class='btn btn-warning'>Editar</a> ";
                            echo "<a href='consultas.php?excluir={$id}' class='btn btn-danger' onclick='return confirmarExclusao()'>Excluir</a> ";

                            if ($status == 'agendada') {
                                echo "<a href='consultas.php?id={$id}&status=realizada' class='btn btn-success'>Realizar</a> ";
                                echo "<a href='consultas.php?id={$id}&status=cancelada' class='btn btn-danger'>Cancelar</a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhuma consulta encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>