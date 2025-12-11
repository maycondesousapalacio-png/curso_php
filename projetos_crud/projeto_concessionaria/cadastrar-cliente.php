<?php include('conexao.php'); ?>
<div class="card">
    <div class="card-header">
        <h2>Cadastrar Cliente</h2>
    </div>
    <div class="card-body">
        <form action="?page=salvar-cliente" method="POST">
            <input type="hidden" name="acao" value="cadastrar">
            <div class="mb-3">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" name="cpf">
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" name="telefone">
            </div>
            <div class="mb-3">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" name="endereco">
            </div>
            <div class="mb-3">
                <label for="dt_nasc">Data de Nascimento:</label>
                <input type="date" class="form-control" name="dt_nasc">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>
</div>