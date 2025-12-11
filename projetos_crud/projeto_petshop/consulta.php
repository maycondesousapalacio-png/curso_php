<?php
class Consulta
{
    private $conn;
    private $table_name = "consultas";

    public $id;
    public $id_cliente;
    public $id_funcionario;
    public $tipo;
    public $data_consulta;
    public $observacoes;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar consulta
    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET id_cliente=:id_cliente, id_funcionario=:id_funcionario, 
                     tipo=:tipo, data_consulta=:data_consulta, observacoes=:observacoes, status=:status";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
        $this->id_funcionario = htmlspecialchars(strip_tags($this->id_funcionario));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->data_consulta = htmlspecialchars(strip_tags($this->data_consulta));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Vincular valores
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":id_funcionario", $this->id_funcionario);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":data_consulta", $this->data_consulta);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler consultas
    public function ler()
    {
        $query = "SELECT c.*, cli.nome as cliente_nome, func.nome as funcionario_nome 
                  FROM " . $this->table_name . " c
                  LEFT JOIN clientes cli ON c.id_cliente = cli.id
                  LEFT JOIN funcionarios func ON c.id_funcionario = func.id
                  ORDER BY c.data_consulta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ler uma consulta específica
    public function lerUm()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id_cliente = $row['id_cliente'];
            $this->id_funcionario = $row['id_funcionario'];
            $this->tipo = $row['tipo'];
            $this->data_consulta = $row['data_consulta'];
            $this->observacoes = $row['observacoes'];
            $this->status = $row['status'];
            return true;
        }
        return false;
    }

    // Atualizar consulta
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . " 
                 SET id_cliente=:id_cliente, id_funcionario=:id_funcionario, 
                     tipo=:tipo, data_consulta=:data_consulta, observacoes=:observacoes, status=:status
                 WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Limpar dados
        $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
        $this->id_funcionario = htmlspecialchars(strip_tags($this->id_funcionario));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->data_consulta = htmlspecialchars(strip_tags($this->data_consulta));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":id_funcionario", $this->id_funcionario);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":data_consulta", $this->data_consulta);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Excluir consulta
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

    // Ler consultas por status
    public function lerPorStatus($status)
    {
        $query = "SELECT c.*, cli.nome as cliente_nome, func.nome as funcionario_nome 
                  FROM " . $this->table_name . " c
                  LEFT JOIN clientes cli ON c.id_cliente = cli.id
                  LEFT JOIN funcionarios func ON c.id_funcionario = func.id
                  WHERE c.status = ?
                  ORDER BY c.data_consulta ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->execute();
        return $stmt;
    }

    // Atualizar status da consulta
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
}
