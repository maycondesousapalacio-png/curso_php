<?php
class Encomenda
{
    private $conn;
    private $table_name = "encomendas";

    public $id;
    public $id_cliente;
    public $data_entrega;
    public $hora_entrega;
    public $endereco_entrega;
    public $observacoes;
    public $status;
    public $total;
    public $data_pedido;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar encomenda
    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET id_cliente=:id_cliente, data_entrega=:data_entrega, 
                     hora_entrega=:hora_entrega, endereco_entrega=:endereco_entrega,
                     observacoes=:observacoes, status=:status, total=:total";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
        $this->data_entrega = htmlspecialchars(strip_tags($this->data_entrega));
        $this->hora_entrega = htmlspecialchars(strip_tags($this->hora_entrega));
        $this->endereco_entrega = htmlspecialchars(strip_tags($this->endereco_entrega));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->total = htmlspecialchars(strip_tags($this->total));

        // Vincular valores
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":data_entrega", $this->data_entrega);
        $stmt->bindParam(":hora_entrega", $this->hora_entrega);
        $stmt->bindParam(":endereco_entrega", $this->endereco_entrega);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":total", $this->total);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Ler encomendas
    public function ler()
    {
        $query = "SELECT e.*, c.nome as cliente_nome, c.telefone as cliente_telefone
                  FROM " . $this->table_name . " e
                  LEFT JOIN clientes c ON e.id_cliente = c.id
                  ORDER BY e.data_entrega DESC, e.hora_entrega DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ler uma encomenda específica
    public function lerUm()
    {
        $query = "SELECT e.*, c.nome as cliente_nome, c.telefone as cliente_telefone, c.email as cliente_email
                  FROM " . $this->table_name . " e
                  LEFT JOIN clientes c ON e.id_cliente = c.id
                  WHERE e.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id_cliente = $row['id_cliente'];
            $this->data_entrega = $row['data_entrega'];
            $this->hora_entrega = $row['hora_entrega'];
            $this->endereco_entrega = $row['endereco_entrega'];
            $this->observacoes = $row['observacoes'];
            $this->status = $row['status'];
            $this->total = $row['total'];
            $this->data_pedido = $row['data_pedido'];
            return $row;
        }
        return false;
    }

    // Atualizar encomenda
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                 SET id_cliente=:id_cliente, data_entrega=:data_entrega, 
                     hora_entrega=:hora_entrega, endereco_entrega=:endereco_entrega,
                     observacoes=:observacoes, status=:status, total=:total
                 WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
        $this->data_entrega = htmlspecialchars(strip_tags($this->data_entrega));
        $this->hora_entrega = htmlspecialchars(strip_tags($this->hora_entrega));
        $this->endereco_entrega = htmlspecialchars(strip_tags($this->endereco_entrega));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":data_entrega", $this->data_entrega);
        $stmt->bindParam(":hora_entrega", $this->hora_entrega);
        $stmt->bindParam(":endereco_entrega", $this->endereco_entrega);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":total", $this->total);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Excluir encomenda
    public function excluir()
    {
        // Primeiro excluir os itens da encomenda
        $query_itens = "DELETE FROM itens_encomenda WHERE id_encomenda = ?";
        $stmt_itens = $this->conn->prepare($query_itens);
        $stmt_itens->bindParam(1, $this->id);
        $stmt_itens->execute();

        // Depois excluir a encomenda
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Atualizar status
    public function atualizarStatus($status)
    {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler encomendas por status
    public function lerPorStatus($status)
    {
        $query = "SELECT e.*, c.nome as cliente_nome, c.telefone as cliente_telefone
                  FROM " . $this->table_name . " e
                  LEFT JOIN clientes c ON e.id_cliente = c.id
                  WHERE e.status = ?
                  ORDER BY e.data_entrega ASC, e.hora_entrega ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->execute();
        return $stmt;
    }

    // Calcular total da encomenda
    public function calcularTotal($id_encomenda)
    {
        $query = "SELECT SUM(subtotal) as total FROM itens_encomenda WHERE id_encomenda = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_encomenda);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ? $row['total'] : 0;
    }

    // Atualizar total da encomenda
    public function atualizarTotal($id_encomenda)
    {
        $total = $this->calcularTotal($id_encomenda);

        $query = "UPDATE " . $this->table_name . " SET total = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $total);
        $stmt->bindParam(2, $id_encomenda);

        return $stmt->execute();
    }
}
