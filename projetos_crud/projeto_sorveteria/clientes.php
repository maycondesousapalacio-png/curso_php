<?php
include 'config.php';
include 'cliente.php';

$database = new Database();
$db = $database->getConnection();
$cliente = new Cliente($db);

$mensagem = "";

// Processar formulário
if ($_POST) {
    if (empty($_POST['id'])) {
        // Criar novo cliente
        $cliente->nome = $_POST['nome'];
        $cliente->telefone = $_POST['telefone'];
        $cliente->email = $_POST['email'];
        $cliente->endereco = $_POST['endereco'];

        if ($cliente->criar()) {
            $mensagem = "<div class='alert alert-success'>Cliente criado com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao criar cliente.</div>";
        }
    } else {
        // Atualizar cliente
        $cliente->id = $_POST['id'];
        $cliente->nome = $_POST['nome'];
        $cliente->telefone = $_POST['telefone'];
        $cliente->email = $_POST['email'];
        $cliente->endereco = $_POST['endereco'];

        if ($cliente->atualizar()) {
            $mensagem = "<div class='alert alert-success'>Cliente atualizado com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao atualizar cliente.</div>";
        }
    }
}

// Excluir cliente
if (isset($_GET['excluir'])) {
    $cliente->id = $_GET['excluir'];
    if ($cliente->excluir()) {
        $mensagem = "<div class='alert alert-success'>Cliente excluído com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao excluir cliente.</div>";
    }
}

// Ler cliente para edição
$cliente_edicao = null;
if (isset($_GET['editar'])) {
    $cliente->id = $_GET['editar'];
    if ($cliente->lerUm()) {
        $cliente_edicao = $cliente;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Sorveteria</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <div class="container">
            <h1>🍦 Sorveteria Doce Sabor</h1>
            <ul class="nav-menu">
                <li><a href="index.php">Início</a></li>
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="sabores.php">Sabores</a></li>
                <li><a href="encomendas.php">Encomendas</a></li>
                <li><a href="nova_encomenda.php">Nova Encomenda</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <?php echo $mensagem; ?>

        <div class="card">
            <h2 class="section-title"><?php echo $cliente_edicao ? 'Editar' : 'Cadastrar'; ?> Cliente</h2>
            <form method="POST" onsubmit="return validarFormulario(this)">
                <?php if ($cliente_edicao): ?>
                    <input type="hidden" name="id" value="<?php echo $cliente_edicao->id; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control"
                        value="<?php echo $cliente_edicao ? $cliente_edicao->nome : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" class="form-control"
                        value="<?php echo $cliente_edicao ? $cliente_edicao->telefone : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control"
                        value="<?php echo $cliente_edicao ? $cliente_edicao->email : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Endereço:</label>
                    <textarea name="endereco" class="form-control" rows="3"><?php echo $cliente_edicao ? $cliente_edicao->endereco : ''; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?php echo $cliente_edicao ? 'Atualizar' : 'Cadastrar'; ?>
                </button>

                <?php if ($cliente_edicao): ?>
                    <a href="clientes.php" class="btn btn-warning">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card">
            <h2 class="section-title">Lista de Clientes</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Endereço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $cliente->ler();
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo "<tr>";
                            echo "<td>{$id}</td>";
                            echo "<td>{$nome}</td>";
                            echo "<td>{$telefone}</td>";
                            echo "<td>{$email}</td>";
                            echo "<td>" . substr($endereco, 0, 50) . (strlen($endereco) > 50 ? '...' : '') . "</td>";
                            echo "<td>";
                            echo "<a href='clientes.php?editar={$id}' class='btn btn-warning'>Editar</a> ";
                            echo "<a href='clientes.php?excluir={$id}' class='btn btn-danger' onclick='return confirmarExclusao()'>Excluir</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nenhum cliente cadastrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>