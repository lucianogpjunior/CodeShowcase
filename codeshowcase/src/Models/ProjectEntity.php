<?php

namespace App\Models;

use InvalidArgumentException;

class ProjectEntity {
    private $id;
    private $uuid;
    private $url;
    private $nomeProjeto;
    private $precoProjeto;
    private $categoriaId;
    private $ativo;
    // CORRIGIDO: declarada explicitamente para compatibilidade com PHP 8.2+
    public string $nomeCategoria = '';

    public function __construct($id, $uuid, $url, $nomeProjeto, $precoProjeto, $categoriaId, $ativo) {
        $this->setId($id);
        $this->setUuid($uuid);
        $this->setUrl($url);
        $this->setNomeProjeto($nomeProjeto);
        $this->setPrecoProjeto($precoProjeto);
        $this->setCategoriaId($categoriaId);
        $this->setAtivo($ativo);
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUuid() { return $this->uuid; }
    public function getUrl() { return $this->url; }
    public function getNomeProjeto() { return $this->nomeProjeto; }
    public function getPrecoProjeto() { return $this->precoProjeto; }
    public function getCategoriaId() { return $this->categoriaId; }
    public function getAtivo() { return $this->ativo; }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUuid($uuid) {
        $this->uuid = $uuid;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setNomeProjeto($nomeProjeto) {
        $nomeProjeto = trim($nomeProjeto);
        if (empty($nomeProjeto)) {
            throw new InvalidArgumentException("Nome do projeto não pode ser vazio.");
        }
        $this->nomeProjeto = $nomeProjeto;
    }

    public function setPrecoProjeto($precoProjeto) {
        if ($precoProjeto < 0) {
            throw new InvalidArgumentException("Preço do projeto não pode ser menor que R\$0.");
        }
        $this->precoProjeto = $precoProjeto;
    }

    public function setCategoriaId($categoriaId) {
        if ($categoriaId < 0) {
            throw new InvalidArgumentException("O id da categoria é inválido.");
        }
        $this->categoriaId = $categoriaId;
    }

    public function setAtivo($ativo) {
        $this->ativo = (bool) $ativo;
    }
}
?>