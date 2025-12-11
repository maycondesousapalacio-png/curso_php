<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorveteria Doce Sabor</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <div class="container">
            <h1>Sorveteria Doce Sabor</h1>
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
        <div class="card">
            <h2>Bem-vindo ao Sistema da Sorveteria!</h2>
            <p>Gerencie sua sorveteria de forma prática e eficiente.</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 2rem;">
                <div class="sabor-card">
                    <h3>Clientes</h3>
                    <p>Cadastre e gerencie os clientes da sorveteria</p>
                    <a href="clientes.php" class="btn btn-primary">Gerenciar Clientes</a>
                </div>

                <div class="sabor-card">
                    <h3>Sabores</h3>
                    <p>Controle o cardápio e preços dos produtos</p>
                    <a href="sabores.php" class="btn btn-primary">Ver Cardápio</a>
                </div>

                <div class="sabor-card">
                    <h3>Encomendas</h3>
                    <p>Acompanhe e gerencie os pedidos</p>
                    <a href="encomendas.php" class="btn btn-primary">Ver Encomendas</a>
                </div>

                <div class="sabor-card">
                    <h3>Novo Pedido</h3>
                    <p>Registre uma nova encomenda</p>
                    <a href="nova_encomenda.php" class="btn btn-success">Fazer Encomenda</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>