<?php

namespace App\Models;

use InvalidArgumentException;

class UsuarioDevEntity {
    private $id;
    private $usuarioId;
    private $dtCadastro;

    public function __construct($id, $usuarioId, $dtCadastro) {
        $this->setId($id);
        $this->setUsuarioId($usuarioId);
        $this->setDtCadastro($dtCadastro);
    }

    public function getId() {
        return $this->id;
    }

    public function getUsuarioId() {
        return $this->usuarioId;
    }

    public function getDtCadastro() {
        return $this->dtCadastro;
    }

    public function setId($id) {
        $this->id = (int) $id;
    }

    public function setUsuarioId($usuarioId) {
        $usuarioId = (int) $usuarioId;
        if ($usuarioId <= 0) {
            throw new InvalidArgumentException("usuario_id inválido.");
        }
        $this->usuarioId = $usuarioId;
    }

    public function setDtCadastro($dtCadastro) {
        $this->dtCadastro = $dtCadastro;
    }
}
?>