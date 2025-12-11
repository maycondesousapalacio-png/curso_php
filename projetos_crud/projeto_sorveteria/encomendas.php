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

// Processar mudança de status
if (isset($_GET['mudar_status'])) {
    $encomenda->id = $_GET['id'];
    if ($encomenda->atualizarStatus($_GET['mudar_status'])) {
        $mensagem = "<div class='alert alert-success'>Status atualizado com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao atualizar status.</div>";
    }
}

// Excluir encomenda
if (isset($_GET['excluir'])) {
    $encomenda->id = $_GET['excluir'];
    if ($encomenda->excluir()) {
        $mensagem = "<div class='alert alert-success'>Encomenda excluída com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao excluir encomenda.</div>";
    }
}

// Determinar qual lista carregar
if (isset($_GET['status'])) {
    $stmt = $encomenda->lerPorStatus($_GET['status']);
    $titulo_status = ucfirst($_GET['status']) . 's';
} else {
    $stmt = $encomenda->ler();
    $titulo_status = 'Todas as Encomendas';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encomendas - Sorveteria</title>
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
            <h2 class="section-title"><?php echo $titulo_status; ?></h2>

            <div class="filter-buttons">
                <a href="encomendas.php" class="btn btn-primary">Todas</a>
                <a href="encomendas.php?status=pendente" class="btn btn-warning">Pendentes</a>
                <a href="encomendas.php?status=confirmada" class="btn btn-info">Confirmadas</a>
                <a href="encomendas.php?status=preparando" class="btn btn-primary">Preparando</a>
                <a href="encomendas.php?status=pronta" class="btn btn-success">Prontas</a>
                <a href="encomendas.php?status=entregue" class="btn btn-secondary">Entregues</a>
                <a href="encomendas.php?status=cancelada" class="btn btn-danger">Canceladas</a>
            </div>

            <div class="encomendas-list">
                <?php
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $data_entrega_formatada = date('d/m/Y', strtotime($data_entrega));
                        $hora_entrega_formatada = date('H:i', strtotime($hora_entrega));
                        $data_pedido_formatada = date('d/m/Y H:i', strtotime($data_pedido));
                        $total_formatado = 'R$ ' . number_format($total, 2, ',', '.');

                        // Cor do status
                        $status_class = "status-{$status}";
                        $status_text = ucfirst($status);

                        echo "<div class='card' style='margin-bottom: 1rem;'>";
                        echo "<div style='display: flex; justify-content: between; align-items: start; flex-wrap: wrap; gap: 1rem;'>";
                        echo "<div style='flex: 1; min-width: 300px;'>";
                        echo "<h3>Encomenda #{$id} - {$cliente_nome}</h3>";
                        echo "<p><strong>Telefone:</strong> {$cliente_telefone}</p>";
                        echo "<p><strong>Entrega:</strong> {$data_entrega_formatada} às {$hora_entrega_formatada}</p>";
                        echo "<p><strong>Endereço:</strong> " . ($endereco_entrega ? $endereco_entrega : 'Retirar no local') . "</p>";
                        echo "<p><strong>Pedido em:</strong> {$data_pedido_formatada}</p>";
                        if ($observacoes) {
                            echo "<p><strong>Observações:</strong> {$observacoes}</p>";
                        }
                        echo "</div>";

                        echo "<div style='text-align: right;'>";
                        echo "<div class='status-badge {$status_class}'>{$status_text}</div>";
                        echo "<div class='total-pedido' style='margin-top: 0.5rem;'>{$total_formatado}</div>";
                        echo "</div>";
                        echo "</div>";

                        // Itens da encomenda
                        $itens_stmt = $item_encomenda->lerPorEncomenda($id);
                        if ($itens_stmt->rowCount() > 0) {
                            echo "<div style='margin-top: 1rem;'>";
                            echo "<h4>Itens do Pedido:</h4>";
                            echo "<table class='table' style='margin-top: 0.5rem;'>";
                            echo "<thead><tr><th>Sabor</th><th>Tipo</th><th>Quantidade</th><th>Preço Unit.</th><th>Subtotal</th></tr></thead>";
                            echo "<tbody>";
                            while ($item = $itens_stmt->fetch(PDO::FETCH_ASSOC)) {
                                $preco_unitario = 'R$ ' . number_format($item['preco_unitario'], 2, ',', '.');
                                $subtotal = 'R$ ' . number_format($item['subtotal'], 2, ',', '.');
                                echo "<tr>";
                                echo "<td>{$item['sabor_nome']}</td>";
                                echo "<td>" . ucfirst($item['sabor_tipo']) . "</td>";
                                echo "<td>{$item['quantidade']}</td>";
                                echo "<td>{$preco_unitario}</td>";
                                echo "<td>{$subtotal}</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                        }

                        // Ações
                        echo "<div style='margin-top: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;'>";
                        echo "<a href='detalhes_encomenda.php?id={$id}' class='btn btn-primary'>Ver Detalhes</a>";

                        if ($status == 'pendente') {
                            echo "<a href='encomendas.php?id={$id}&mudar_status=confirmada' class='btn btn-info'>Confirmar</a>";
                            echo "<a href='encomendas.php?id={$id}&mudar_status=cancelada' class='btn btn-danger'>Cancelar</a>";
                        } elseif ($status == 'confirmada') {
                            echo "<a href='encomendas.php?id={$id}&mudar_status=preparando' class='btn btn-primary'>Preparar</a>";
                        } elseif ($status == 'preparando') {
                            echo "<a href='encomendas.php?id={$id}&mudar_status=pronta' class='btn btn-success'>Marcar como Pronta</a>";
                        } elseif ($status == 'pronta') {
                            echo "<a href='encomendas.php?id={$id}&mudar_status=entregue' class='btn btn-secondary'>Marcar como Entregue</a>";
                        }

                        echo "<a href='encomendas.php?excluir={$id}' class='btn btn-danger' onclick='return confirmarExclusao()'>Excluir</a>";
                        echo "</div>";

                        echo "</div>";
                    }
                } else {
                    echo "<div class='card'>";
                    echo "<p>Nenhuma encomenda encontrada.</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>