<?php
include 'config.php';
include 'sabor.php';

$database = new Database();
$db = $database->getConnection();
$sabor = new Sabor($db);

$mensagem = "";

// Processar formulário
if ($_POST) {
    if (empty($_POST['id'])) {
        // Criar novo sabor
        $sabor->nome = $_POST['nome'];
        $sabor->descricao = $_POST['descricao'];
        $sabor->preco = $_POST['preco'];
        $sabor->tipo = $_POST['tipo'];
        $sabor->disponivel = isset($_POST['disponivel']) ? 1 : 0;

        if ($sabor->criar()) {
            $mensagem = "<div class='alert alert-success'>Sabor criado com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao criar sabor.</div>";
        }
    } else {
        // Atualizar sabor
        $sabor->id = $_POST['id'];
        $sabor->nome = $_POST['nome'];
        $sabor->descricao = $_POST['descricao'];
        $sabor->preco = $_POST['preco'];
        $sabor->tipo = $_POST['tipo'];
        $sabor->disponivel = isset($_POST['disponivel']) ? 1 : 0;

        if ($sabor->atualizar()) {
            $mensagem = "<div class='alert alert-success'>Sabor atualizado com sucesso!</div>";
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro ao atualizar sabor.</div>";
        }
    }
}

// Excluir sabor
if (isset($_GET['excluir'])) {
    $sabor->id = $_GET['excluir'];
    if ($sabor->excluir()) {
        $mensagem = "<div class='alert alert-success'>Sabor excluído com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao excluir sabor.</div>";
    }
}

// Ler sabor para edição
$sabor_edicao = null;
if (isset($_GET['editar'])) {
    $sabor->id = $_GET['editar'];
    if ($sabor->lerUm()) {
        $sabor_edicao = $sabor;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabores - Sorveteria</title>
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
            <h2 class="section-title"><?php echo $sabor_edicao ? 'Editar' : 'Cadastrar'; ?> Sabor</h2>
            <form method="POST" onsubmit="return validarFormulario(this)">
                <?php if ($sabor_edicao): ?>
                    <input type="hidden" name="id" value="<?php echo $sabor_edicao->id; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control"
                        value="<?php echo $sabor_edicao ? $sabor_edicao->nome : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label>Descrição:</label>
                    <textarea name="descricao" class="form-control" rows="3"><?php echo $sabor_edicao ? $sabor_edicao->descricao : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Preço:</label>
                    <input type="number" name="preco" class="form-control" step="0.01" min="0"
                        value="<?php echo $sabor_edicao ? $sabor_edicao->preco : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label>Tipo:</label>
                    <select name="tipo" class="form-control" required>
                        <option value="">Selecione o tipo</option>
                        <option value="sorvete" <?php echo ($sabor_edicao && $sabor_edicao->tipo == 'sorvete') ? 'selected' : ''; ?>>Sorvete</option>
                        <option value="picolé" <?php echo ($sabor_edicao && $sabor_edicao->tipo == 'picolé') ? 'selected' : ''; ?>>Picolé</option>
                        <option value="massas" <?php echo ($sabor_edicao && $sabor_edicao->tipo == 'massas') ? 'selected' : ''; ?>>Massas</option>
                        <option value="casquinha" <?php echo ($sabor_edicao && $sabor_edicao->tipo == 'casquinha') ? 'selected' : ''; ?>>Casquinha</option>
                        <option value="cascao" <?php echo ($sabor_edicao && $sabor_edicao->tipo == 'cascao') ? 'selected' : ''; ?>>Cascão</option>
                        <option value="taça" <?php echo ($sabor_edicao && $sabor_edicao->tipo == 'taça') ? 'selected' : ''; ?>>Taça</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="disponivel" value="1"
                            <?php echo ($sabor_edicao && $sabor_edicao->disponivel) ? 'checked' : ''; ?>>
                        Disponível para venda
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?php echo $sabor_edicao ? 'Atualizar' : 'Cadastrar'; ?>
                </button>

                <?php if ($sabor_edicao): ?>
                    <a href="sabores.php" class="btn btn-warning">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card">
            <h2 class="section-title">Cardápio de Sabores</h2>

            <div class="grid-sabores">
                <?php
                $stmt = $sabor->ler();
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $disponivel_class = $disponivel ? 'disponivel' : 'indisponivel';
                        echo "<div class='sabor-card'>";
                        echo "<span class='tipo'>{$tipo}</span>";
                        echo "<h4>{$nome}" . (!$disponivel ? " <small>(Indisponível)</small>" : "") . "</h4>";
                        echo "<p>{$descricao}</p>";
                        echo "<div class='price'>R$ " . number_format($preco, 2, ',', '.') . "</div>";
                        echo "<div style='margin-top: 1rem;'>";
                        echo "<a href='sabores.php?editar={$id}' class='btn btn-warning'>Editar</a> ";
                        echo "<a href='sabores.php?excluir={$id}' class='btn btn-danger' onclick='return confirmarExclusao()'>Excluir</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Nenhum sabor cadastrado.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>