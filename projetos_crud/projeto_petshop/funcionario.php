<?php
class Funcionario
{
    private $conn;
    private $table_name = "funcionarios";

    public $id;
    public $nome;
    public $funcao;
    public $data_cadastro;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar funcionário
    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET nome=:nome, funcao=:funcao";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->funcao = htmlspecialchars(strip_tags($this->funcao));

        // Vincular valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":funcao", $this->funcao);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler funcionários
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ler um funcionário específico
    public function lerUm()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome = $row['nome'];
            $this->funcao = $row['funcao'];
            $this->data_cadastro = $row['data_cadastro'];
            return true;
        }
        return false;
    }

    // Atualizar funcionário
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                 SET nome=:nome, funcao=:funcao 
                 WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->funcao = htmlspecialchars(strip_tags($this->funcao));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":funcao", $this->funcao);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Excluir funcionário
    public function excluir()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler funcionários por função
    public function lerPorFuncao($funcao)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE funcao = ? ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $funcao);
        $stmt->execute();
        return $stmt;
    }
}
