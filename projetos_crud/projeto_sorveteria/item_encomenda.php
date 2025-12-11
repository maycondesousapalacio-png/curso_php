<?php
class ItemEncomenda
{
    private $conn;
    private $table_name = "itens_encomenda";

    public $id;
    public $id_encomenda;
    public $id_sabor;
    public $quantidade;
    public $preco_unitario;
    public $subtotal;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Adicionar item à encomenda
    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET id_encomenda=:id_encomenda, id_sabor=:id_sabor, 
                     quantidade=:quantidade, preco_unitario=:preco_unitario,
                     subtotal=:subtotal";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->id_encomenda = htmlspecialchars(strip_tags($this->id_encomenda));
        $this->id_sabor = htmlspecialchars(strip_tags($this->id_sabor));
        $this->quantidade = htmlspecialchars(strip_tags($this->quantidade));
        $this->preco_unitario = htmlspecialchars(strip_tags($this->preco_unitario));
        $this->subtotal = htmlspecialchars(strip_tags($this->subtotal));

        // Vincular valores
        $stmt->bindParam(":id_encomenda", $this->id_encomenda);
        $stmt->bindParam(":id_sabor", $this->id_sabor);
        $stmt->bindParam(":quantidade", $this->quantidade);
        $stmt->bindParam(":preco_unitario", $this->preco_unitario);
        $stmt->bindParam(":subtotal", $this->subtotal);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler itens de uma encomenda
    public function lerPorEncomenda($id_encomenda)
    {
        $query = "SELECT i.*, s.nome as sabor_nome, s.tipo as sabor_tipo
                  FROM " . $this->table_name . " i
                  LEFT JOIN sabores s ON i.id_sabor = s.id
                  WHERE i.id_encomenda = ?
                  ORDER BY s.tipo, s.nome";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_encomenda);
        $stmt->execute();
        return $stmt;
    }

    // Atualizar item
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                 SET quantidade=:quantidade, preco_unitario=:preco_unitario, subtotal=:subtotal
                 WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->quantidade = htmlspecialchars(strip_tags($this->quantidade));
        $this->preco_unitario = htmlspecialchars(strip_tags($this->preco_unitario));
        $this->subtotal = htmlspecialchars(strip_tags($this->subtotal));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":quantidade", $this->quantidade);
        $stmt->bindParam(":preco_unitario", $this->preco_unitario);
        $stmt->bindParam(":subtotal", $this->subtotal);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Excluir item
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

    // Excluir todos os itens de uma encomenda
    public function excluirPorEncomenda($id_encomenda)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_encomenda = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_encomenda);

        return $stmt->execute();
    }

    // Verificar se item já existe na encomenda
    public function itemExiste($id_encomenda, $id_sabor)
    {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE id_encomenda = ? AND id_sabor = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_encomenda);
        $stmt->bindParam(2, $id_sabor);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
