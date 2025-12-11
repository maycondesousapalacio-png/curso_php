<?php
class Sabor
{
    private $conn;
    private $table_name = "sabores";

    public $id;
    public $nome;
    public $descricao;
    public $preco;
    public $tipo;
    public $disponivel;
    public $data_cadastro;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar sabor
    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET nome=:nome, descricao=:descricao, preco=:preco, tipo=:tipo, disponivel=:disponivel";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->disponivel = htmlspecialchars(strip_tags($this->disponivel));

        // Vincular valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":disponivel", $this->disponivel);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler sabores
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY tipo, nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ler sabores disponíveis
    public function lerDisponiveis()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE disponivel = 1 ORDER BY tipo, nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ler sabores por tipo
    public function lerPorTipo($tipo)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE tipo = ? AND disponivel = 1 ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $tipo);
        $stmt->execute();
        return $stmt;
    }

    // Ler um sabor específico
    public function lerUm()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->preco = $row['preco'];
            $this->tipo = $row['tipo'];
            $this->disponivel = $row['disponivel'];
            $this->data_cadastro = $row['data_cadastro'];
            return true;
        }
        return false;
    }

    // Atualizar sabor
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                 SET nome=:nome, descricao=:descricao, preco=:preco, tipo=:tipo, disponivel=:disponivel 
                 WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->disponivel = htmlspecialchars(strip_tags($this->disponivel));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":disponivel", $this->disponivel);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Excluir sabor
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
