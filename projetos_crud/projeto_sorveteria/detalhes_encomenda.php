<?php
include 'config.php';
include 'encomenda.php';
include 'item_encomenda.php';
include 'cliente.php';
include 'sabor.php';

$database = new Database();
$db = $database->getConnection();
$encomenda = new Encomenda($db);
$item_encomenda = new ItemEncomenda($db);

$mensagem = "";

// Verificar se ID foi passado
if (!isset($_GET['id'])) {
    header("Location: encomendas.php");
    exit();
}

$encomenda->id = $_GET['id'];
$dados_encomenda = $encomenda->lerUm();

if (!$dados_encomenda) {
    header("Location: encomendas.php");
    exit();
}

// Carregar itens da encomenda
$itens_stmt = $item_encomenda->lerPorEncomenda($encomenda->id);

// Processar atualização de status
if (isset($_POST['atualizar_status'])) {
    if ($encomenda->atualizarStatus($_POST['novo_status'])) {
        $mensagem = "<div class='alert alert-success'>Status atualizado com sucesso!</div>";
        // Recarregar dados
        $dados_encomenda = $encomenda->lerUm();
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao atualizar status.</div>";
    }
}

// Formatar dados
$data_entrega_formatada = date('d/m/Y', strtotime($dados_encomenda['data_entrega']));
$hora_entrega_formatada = date('H:i', strtotime($dados_encomenda['hora_entrega']));
$data_pedido_formatada = date('d/m/Y H:i', strtotime($dados_encomenda['data_pedido']));
$total_formatado = 'R$ ' . number_format($dados_encomenda['total'], 2, ',', '.');
$status_class = "status-{$dados_encomenda['status']}";
$status_text = ucfirst($dados_encomenda['status']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Encomenda - Sorveteria</title>
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
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1rem;">
                <h2 class="section-title">Encomenda #<?php echo $encomenda->id; ?></h2>
                <div class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div>
                    <h3>Informações do Cliente</h3>
                    <p><strong>Nome:</strong> <?php echo $dados_encomenda['cliente_nome']; ?></p>
                    <p><strong>Telefone:</strong> <?php echo $dados_encomenda['cliente_telefone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $dados_encomenda['cliente_email'] ? $dados_encomenda['cliente_email'] : 'Não informado'; ?></p>
                </div>

                <div>
                    <h3>Informações de Entrega</h3>
                    <p><strong>Data:</strong> <?php echo $data_entrega_formatada; ?></p>
                    <p><strong>Hora:</strong> <?php echo $hora_entrega_formatada; ?></p>
                    <p><strong>Endereço:</strong> <?php echo $dados_encomenda['endereco_entrega'] ? $dados_encomenda['endereco_entrega'] : 'Retirar no local'; ?></p>
                    <p><strong>Pedido feito em:</strong> <?php echo $data_pedido_formatada; ?></p>
                </div>
            </div>

            <?php if ($dados_encomenda['observacoes']): ?>
                <div style="margin-top: 1rem;">
                    <h3>Observações</h3>
                    <p><?php echo $dados_encomenda['observacoes']; ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3 class="section-title">Itens do Pedido</h3>

            <?php if ($itens_stmt->rowCount() > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sabor</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_geral = 0;
                        while ($item = $itens_stmt->fetch(PDO::FETCH_ASSOC)):
                            $preco_unitario = 'R$ ' . number_format($item['preco_unitario'], 2, ',', '.');
                            $subtotal = 'R$ ' . number_format($item['subtotal'], 2, ',', '.');
                            $total_geral += $item['subtotal'];
                        ?>
                            <tr>
                                <td><?php echo $item['sabor_nome']; ?></td>
                                <td><?php echo ucfirst($item['sabor_tipo']); ?></td>
                                <td><?php echo $item['quantidade']; ?></td>
                                <td><?php echo $preco_unitario; ?></td>
                                <td><?php echo $subtotal; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                            <td style="font-weight: bold;"><?php echo 'R$ ' . number_format($total_geral, 2, ',', '.'); ?></td>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <p>Nenhum item encontrado para esta encomenda.</p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3 class="section-title">Atualizar Status</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Novo Status:</label>
                    <select name="novo_status" class="form-control" required>
                        <option value="pendente" <?php echo $dados_encomenda['status'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
                        <option value="confirmada" <?php echo $dados_encomenda['status'] == 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                        <option value="preparando" <?php echo $dados_encomenda['status'] == 'preparando' ? 'selected' : ''; ?>>Preparando</option>
                        <option value="pronta" <?php echo $dados_encomenda['status'] == 'pronta' ? 'selected' : ''; ?>>Pronta</option>
                        <option value="entregue" <?php echo $dados_encomenda['status'] == 'entregue' ? 'selected' : ''; ?>>Entregue</option>
                        <option value="cancelada" <?php echo $dados_encomenda['status'] == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>
                <button type="submit" name="atualizar_status" class="btn btn-primary">Atualizar Status</button>
                <a href="encomendas.php" class="btn btn-warning">Voltar para Lista</a>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>