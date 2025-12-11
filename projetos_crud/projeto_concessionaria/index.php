<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Concessionária</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #0d6efd !important;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .table th {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-car-front-fill"></i> x9Car
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-house"></i> Home
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-people"></i> Funcionários
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=cadastrar-funcionario">Cadastrar</a></li>
                            <li><a class="dropdown-item" href="?page=listar-funcionario">Listar</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i> Clientes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=cadastrar-cliente">Cadastrar</a></li>
                            <li><a class="dropdown-item" href="?page=listar-cliente">Listar</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-tags"></i> Marcas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=cadastrar-marca">Cadastrar</a></li>
                            <li><a class="dropdown-item" href="?page=listar-marca">Listar</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-car-front"></i> Modelos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=cadastrar-modelo">Cadastrar</a></li>
                            <li><a class="dropdown-item" href="?page=listar-modelo">Listar</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-cash-coin"></i> Vendas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?page=cadastrar-venda">Cadastrar</a></li>
                            <li><a class="dropdown-item" href="?page=listar-venda">Listar</a></li>
                        </ul>
                    </li>
                </ul>

                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Pesquisar..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <?php
                switch (@$_REQUEST['page']) {
                    // funcionário
                    case 'cadastrar-funcionario':
                        include('cadastrar-funcionario.php');
                        break;
                    case 'listar-funcionario':
                        include('listar-funcionario.php');
                        break;
                    case 'editar-funcionario':
                        include('editar-funcionario.php');
                        break;
                    case 'salvar-funcionario':
                        include('salvar-funcionario.php');
                        break;

                    // cliente
                    case 'cadastrar-cliente':
                        include('cadastrar-cliente.php');
                        break;
                    case 'listar-cliente':
                        include('listar-cliente.php');
                        break;
                    case 'editar-cliente':
                        include('editar-cliente.php');
                        break;
                    case 'salvar-cliente':
                        include('salvar-cliente.php');
                        break;

                    // marca
                    case 'cadastrar-marca':
                        include('cadastrar-marca.php');
                        break;
                    case 'listar-marca':
                        include('listar-marca.php');
                        break;
                    case 'editar-marca':
                        include('editar-marca.php');
                        break;
                    case 'salvar-marca':
                        include('salvar-marca.php');
                        break;

                    // modelo
                    case 'cadastrar-modelo':
                        include('cadastrar-modelo.php');
                        break;
                    case 'listar-modelo':
                        include('listar-modelo.php');
                        break;
                    case 'editar-modelo':
                        include('editar-modelo.php');
                        break;
                    case 'salvar-modelo':
                        include('salvar-modelo.php');
                        break;

                    // venda
                    case 'cadastrar-venda':
                        include('cadastrar-venda.php');
                        break;
                    case 'listar-venda':
                        include('listar-venda.php');
                        break;
                    case 'editar-venda':
                        include('editar-venda.php');
                        break;
                    case 'salvar-venda':
                        include('salvar-venda.php');
                        break;

                    // exclusão
                    case 'excluir':
                        include('excluir.php');
                        break;

                    default:
                        echo '
        <div class="jumbotron bg-light p-5 rounded">
            <h1 class="display-4">Bem-vindo ao x9Car!</h1>
            <p class="lead">Sistema de gerenciamento para concessionária.</p>
            <hr class="my-4">
            <p>Gerencie funcionários, clientes, veículos e vendas de forma eficiente.</p>
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-people display-4 text-primary"></i>
                            <h5>Funcionários</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-person display-4 text-success"></i>
                            <h5>Clientes</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-car-front display-4 text-warning"></i>
                            <h5>Veículos</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-cash-coin display-4 text-info"></i>
                            <h5>Vendas</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>