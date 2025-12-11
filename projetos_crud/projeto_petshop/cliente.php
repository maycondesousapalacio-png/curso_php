<?php
class Cliente
{
    private $conn;
    private $table_name = "clientes";

    public $id;
    public $nome;
    public $cep;
    public $email;
    public $telefone;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar cliente
    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET nome=:nome, cep=:cep, email=:email, telefone=:telefone";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cep = htmlspecialchars(strip_tags($this->cep));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));

        // Vincular valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cep", $this->cep);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler clientes
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ler um cliente específico
    public function lerUm()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome = $row['nome'];
            $this->cep = $row['cep'];
            $this->email = $row['email'];
            $this->telefone = $row['telefone'];
            return true;
        }
        return false;
    }

    // Atualizar cliente
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                 SET nome=:nome, cep=:cep, email=:email, telefone=:telefone 
                 WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cep = htmlspecialchars(strip_tags($this->cep));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cep", $this->cep);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Excluir cliente
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
}
