<?php

namespace App\DAO;

use App\Config\Conexao;
use App\Models\UsuarioDevEntity;

class UsuarioDevDAO {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConexao();
    }

    public function create(UsuarioDevEntity $usuarioDev): UsuarioDevEntity {
        $sql = "INSERT INTO usuario_dev (usuario_id) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $usuarioDev->getUsuarioId()
        ]);

        $usuarioDev->setId($this->conn->lastInsertId());
        return $usuarioDev;
    }

    public function read(int $id): ?UsuarioDevEntity {
        $sql = "SELECT * FROM usuario_dev WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) return null;

        return new UsuarioDevEntity(
            $dados['id'], 
            $dados['usuario_id'], 
            $dados['dt_cadastro']
        );
    }

    public function readByUsuarioId(int $usuarioId): ?UsuarioDevEntity {
        $sql = "SELECT * FROM usuario_dev WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuarioId]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) return null;

        return new UsuarioDevEntity(
            $dados['id'], 
            $dados['usuario_id'], 
            $dados['dt_cadastro']
        );
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM usuario_dev WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>