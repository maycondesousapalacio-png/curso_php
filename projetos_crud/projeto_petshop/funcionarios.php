<?php
include 'config.php';
include 'funcionario.php';

$database = new Database();
$db = $database->getConnection();
$funcionario = new Funcionario($db);

$mensagem = "";

// Processar formulário
if ($_POST) {
    if (empty($_POST['id'])) {
        // Criar novo funcionário
        $funcionario->nome = $_POST['nome'];
        $funcionario->funcao = $_POST['funcao'];

        if ($funcionario->criar()) {
            $mensagem = "<div class='alert alert-success'>Funcionário criado com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao criar funcionário.</div>";
        }
    } else {
        // Atualizar funcionário
        $funcionario->id = $_POST['id'];
        $funcionario->nome = $_POST['nome'];
        $funcionario->funcao = $_POST['funcao'];

        if ($funcionario->atualizar()) {
            $mensagem = "<div class='alert alert-success'>Funcionário atualizado com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao atualizar funcionário.</div>";
        }
    }
}

// Excluir funcionário
if (isset($_GET['excluir'])) {
    $funcionario->id = $_GET['excluir'];
    if ($funcionario->excluir()) {
        $mensagem = "<div class='alert alert-success'>Funcionário excluído com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao excluir funcionário.</div>";
    }
}

// Ler funcionário para edição
$funcionario_edicao = null;
if (isset($_GET['editar'])) {
    $funcionario->id = $_GET['editar'];
    if ($funcionario->lerUm()) {
        $funcionario_edicao = $funcionario;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários - Petshop</title>
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
            <h2 class="section-title"><?php echo $funcionario_edicao ? 'Editar' : 'Cadastrar'; ?> Funcionário</h2>
            <form method="POST">
                <?php if ($funcionario_edicao): ?>
                    <input type="hidden" name="id" value="<?php echo $funcionario_edicao->id; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control"
                        value="<?php echo $funcionario_edicao ? $funcionario_edicao->nome : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label>Função:</label>
                    <select name="funcao" class="form-control" required>
                        <option value="">Selecione a função</option>
                        <option value="Veterinário" <?php echo ($funcionario_edicao && $funcionario_edicao->funcao == 'Veterinário') ? 'selected' : ''; ?>>Veterinário</option>
                        <option value="Tosador" <?php echo ($funcionario_edicao && $funcionario_edicao->funcao == 'Tosador') ? 'selected' : ''; ?>>Tosador</option>
                        <option value="Banhista" <?php echo ($funcionario_edicao && $funcionario_edicao->funcao == 'Banhista') ? 'selected' : ''; ?>>Banhista</option>
                        <option value="Atendente" <?php echo ($funcionario_edicao && $funcionario_edicao->funcao == 'Atendente') ? 'selected' : ''; ?>>Atendente</option>
                        <option value="Gerente" <?php echo ($funcionario_edicao && $funcionario_edicao->funcao == 'Gerente') ? 'selected' : ''; ?>>Gerente</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?php echo $funcionario_edicao ? 'Atualizar' : 'Cadastrar'; ?>
                </button>

                <?php if ($funcionario_edicao): ?>
                    <a href="funcionarios.php" class="btn btn-warning">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card">
            <h2 class="section-title">Lista de Funcionários</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Função</th>
                        <th>Data Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $funcionario->ler();
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            $data_cadastro = date('d/m/Y H:i', strtotime($data_cadastro));
                            echo "<tr>";
                            echo "<td>{$id}</td>";
                            echo "<td>{$nome}</td>";
                            echo "<td>{$funcao}</td>";
                            echo "<td>{$data_cadastro}</td>";
                            echo "<td>";
                            echo "<a href='funcionarios.php?editar={$id}' class='btn btn-warning'>Editar</a> ";
                            echo "<a href='funcionarios.php?excluir={$id}' class='btn btn-danger' onclick='return confirmarExclusao()'>Excluir</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhum funcionário cadastrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>