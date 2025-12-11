<?php
class Cliente
{
    private $conn;
    private $table_name = "clientes";

    public $id;
    public $nome;
    public $telefone;
    public $email;
    public $endereco;
    public $data_cadastro;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar cliente
    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET nome=:nome, telefone=:telefone, email=:email, endereco=:endereco";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));

        // Vincular valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":endereco", $this->endereco);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler clientes
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome ASC";
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
            $this->telefone = $row['telefone'];
            $this->email = $row['email'];
            $this->endereco = $row['endereco'];
            $this->data_cadastro = $row['data_cadastro'];
            return true;
        }
        return false;
    }

    // Atualizar cliente
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                 SET nome=:nome, telefone=:telefone, email=:email, endereco=:endereco 
                 WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":endereco", $this->endereco);
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
