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
$cliente = new Cliente($db);
$sabor = new Sabor($db);

$mensagem = "";

// Carregar clientes e sabores
$clientes = $cliente->ler();
$sabores = $sabor->lerDisponiveis();

// Processar formulário de encomenda
if ($_POST && isset($_POST['id_cliente'])) {
    try {
        $db->beginTransaction();

        // Criar encomenda
        $encomenda->id_cliente = $_POST['id_cliente'];
        $encomenda->data_entrega = $_POST['data_entrega'];
        $encomenda->hora_entrega = $_POST['hora_entrega'];
        $encomenda->endereco_entrega = $_POST['endereco_entrega'];
        $encomenda->observacoes = $_POST['observacoes'];
        $encomenda->status = 'pendente';
        $encomenda->total = 0;

        $id_encomenda = $encomenda->criar();

        if ($id_encomenda) {
            $total_geral = 0;

            // Processar itens do carrinho
            if (isset($_POST['itens']) && is_array($_POST['itens'])) {
                foreach ($_POST['itens'] as $item) {
                    if ($item['quantidade'] > 0) {
                        $item_encomenda->id_encomenda = $id_encomenda;
                        $item_encomenda->id_sabor = $item['id_sabor'];
                        $item_encomenda->quantidade = $item['quantidade'];
                        $item_encomenda->preco_unitario = $item['preco'];
                        $item_encomenda->subtotal = $item['quantidade'] * $item['preco'];

                        if ($item_encomenda->criar()) {
                            $total_geral += $item_encomenda->subtotal;
                        }
                    }
                }
            }

            // Atualizar total da encomenda
            $encomenda->id = $id_encomenda;
            $encomenda->total = $total_geral;
            $encomenda->atualizar();

            $db->commit();
            $mensagem = "<div class='alert alert-success'>Encomenda criada com sucesso! Número do pedido: #{$id_encomenda}</div>";

            // Limpar formulário
            $_POST = array();
        } else {
            $db->rollBack();
            $mensagem = "<div class='alert alert-danger'>Erro ao criar encomenda.</div>";
        }
    } catch (Exception $e) {
        $db->rollBack();
        $mensagem = "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Encomenda - Sorveteria</title>
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
            <h2 class="section-title">Nova Encomenda</h2>
            <form method="POST" id="form-encomenda" onsubmit="return validarEncomenda()">
                <div class="form-group">
                    <label>Cliente:</label>
                    <select name="id_cliente" id="id_cliente" class="form-control" required onchange="carregarEnderecoCliente()">
                        <option value="">Selecione o cliente</option>
                        <?php
                        if ($clientes->rowCount() > 0) {
                            while ($row = $clientes->fetch(PDO::FETCH_ASSOC)) {
                                $selected = (isset($_POST['id_cliente']) && $_POST['id_cliente'] == $row['id']) ? 'selected' : '';
                                echo "<option value='{$row['id']}' data-endereco='{$row['endereco']}' {$selected}>{$row['nome']} - {$row['telefone']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <small><a href="clientes.php" target="_blank">Cadastrar novo cliente</a></small>
                </div>

                <div class="form-group">
                    <label>Endereço de Entrega:</label>
                    <textarea name="endereco_entrega" id="endereco_entrega" class="form-control" rows="3" placeholder="Endereço para entrega ou 'Retirar no local'"><?php echo isset($_POST['endereco_entrega']) ? $_POST['endereco_entrega'] : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Data de Entrega:</label>
                    <input type="date" name="data_entrega" class="form-control"
                        value="<?php echo isset($_POST['data_entrega']) ? $_POST['data_entrega'] : date('Y-m-d'); ?>" required>
                </div>

                <div class="form-group">
                    <label>Hora de Entrega:</label>
                    <input type="time" name="hora_entrega" class="form-control"
                        value="<?php echo isset($_POST['hora_entrega']) ? $_POST['hora_entrega'] : '18:00'; ?>" required>
                </div>

                <div class="card">
                    <h3 class="section-title">Itens do Pedido</h3>
                    <div id="carrinho-itens">
                        <!-- Itens serão adicionados aqui via JavaScript -->
                    </div>

                    <div class="total-pedido">
                        Total: <span id="total-geral">R$ 0,00</span>
                    </div>
                </div>

                <div class="card">
                    <h3 class="section-title">Adicionar Itens</h3>
                    <div class="grid-sabores" id="lista-sabores">
                        <?php
                        if ($sabores->rowCount() > 0) {
                            while ($row = $sabores->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                $preco_formatado = number_format($preco, 2, ',', '.');
                                echo "<div class='sabor-card' data-sabor-id='{$id}'>";
                                echo "<span class='tipo'>{$tipo}</span>";
                                echo "<h4>{$nome}</h4>";
                                echo "<p>{$descricao}</p>";
                                echo "<div class='price'>R$ {$preco_formatado}</div>";
                                echo "<div class='quantity-control' data-preco='{$preco}'>";
                                echo "<button type='button' onclick='diminuirQuantidade(this)'>-</button>";
                                echo "<input type='number' value='0' min='0' readonly>";
                                echo "<button type='button' onclick='aumentarQuantidade(this)'>+</button>";
                                echo "<button type='button' class='btn btn-primary' onclick='adicionarAoCarrinho({$id}, \"{$nome}\", {$preco}, this)'>Adicionar</button>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Nenhum sabor disponível no momento.</p>";
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label>Observações:</label>
                    <textarea name="observacoes" class="form-control" rows="3" placeholder="Observações especiais, alergias, etc."><?php echo isset($_POST['observacoes']) ? $_POST['observacoes'] : ''; ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Finalizar Encomenda</button>
                <button type="button" class="btn btn-warning" onclick="limparCarrinho()">Limpar Carrinho</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        let carrinho = [];

        function carregarEnderecoCliente() {
            const select = document.getElementById('id_cliente');
            const selectedOption = select.options[select.selectedIndex];
            const endereco = selectedOption.getAttribute('data-endereco');

            if (endereco) {
                document.getElementById('endereco_entrega').value = endereco;
            }
        }

        function aumentarQuantidade(button) {
            const container = button.parentElement;
            const input = container.querySelector('input');
            input.value = parseInt(input.value) + 1;
        }

        function diminuirQuantidade(button) {
            const container = button.parentElement;
            const input = container.querySelector('input');
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function adicionarAoCarrinho(saborId, saborNome, preco, button) {
            const container = button.parentElement;
            const quantidade = parseInt(container.querySelector('input').value);

            if (quantidade > 0) {
                // Verificar se já existe no carrinho
                const index = carrinho.findIndex(item => item.id_sabor === saborId);

                if (index > -1) {
                    // Atualizar quantidade
                    carrinho[index].quantidade += quantidade;
                } else {
                    // Adicionar novo item
                    carrinho.push({
                        id_sabor: saborId,
                        nome: saborNome,
                        preco: preco,
                        quantidade: quantidade
                    });
                }

                // Limpar quantidade
                container.querySelector('input').value = 0;

                // Atualizar exibição do carrinho
                atualizarCarrinho();
            } else {
                alert('Selecione uma quantidade maior que zero.');
            }
        }

        function atualizarCarrinho() {
            const container = document.getElementById('carrinho-itens');
            const totalGeral = document.getElementById('total-geral');
            let html = '';
            let total = 0;

            if (carrinho.length === 0) {
                html = '<p>Nenhum item adicionado ao carrinho.</p>';
            } else {
                html = '<table class="table"><thead><tr><th>Item</th><th>Quantidade</th><th>Preço Unit.</th><th>Subtotal</th><th>Ação</th></tr></thead><tbody>';

                carrinho.forEach((item, index) => {
                    const subtotal = item.quantidade * item.preco;
                    total += subtotal;

                    html += `
                        <tr>
                            <td>${item.nome}</td>
                            <td>${item.quantidade}</td>
                            <td>R$ ${item.preco.toFixed(2).replace('.', ',')}</td>
                            <td>R$ ${subtotal.toFixed(2).replace('.', ',')}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removerDoCarrinho(${index})">Remover</button>
                                <input type="hidden" name="itens[${index}][id_sabor]" value="${item.id_sabor}">
                                <input type="hidden" name="itens[${index}][quantidade]" value="${item.quantidade}">
                                <input type="hidden" name="itens[${index}][preco]" value="${item.preco}">
                            </td>
                        </tr>
                    `;
                });

                html += '</tbody></table>';
            }

            container.innerHTML = html;
            totalGeral.textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
        }

        function removerDoCarrinho(index) {
            carrinho.splice(index, 1);
            atualizarCarrinho();
        }

        function limparCarrinho() {
            if (confirm('Tem certeza que deseja limpar o carrinho?')) {
                carrinho = [];
                atualizarCarrinho();
            }
        }

        function validarEncomenda() {
            if (carrinho.length === 0) {
                alert('Adicione pelo menos um item ao carrinho.');
                return false;
            }

            if (!document.getElementById('id_cliente').value) {
                alert('Selecione um cliente.');
                return false;
            }

            return true;
        }

        // Carregar endereço se já houver cliente selecionado
        document.addEventListener('DOMContentLoaded', function() {
            carregarEnderecoCliente();
        });
    </script>
</body>

</html>