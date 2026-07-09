<?php

namespace App\Models;

use InvalidArgumentException;

class ProjectEntity {
    private $id;
    private $url;
    private $image;
    private $nome;
    private $titulo;
    private $descricao;
    private $preco;
    private $categoriaId;
    private $devId;
    private $status;
    public string $nomeCategoria = '';

    public function __construct($id, $url, $image, $nome, $titulo, $descricao, $preco, $categoriaId, $status, $devId) {
        $this->setId($id);
        $this->setUrl($url);
        $this->setImage($image);
        $this->setNome($nome);
        $this->setTitulo($titulo);
        $this->setDescricao($descricao);
        $this->setPreco($preco);
        $this->setCategoriaId($categoriaId);
        $this->setStatus($status);
        $this->setDevId($devId);
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUrl() { return $this->url; }
    public function getImage() { return $this->image; }
    public function getNome() { return $this->nome; }
    public function getTitulo() { return $this->titulo; }
    public function getDescricao() { return $this->descricao; }
    public function getPreco() { return $this->preco; }
    public function getCategoriaId() { return $this->categoriaId; }
    public function getDevId() { return $this->devId; }
    public function getStatus() { return $this->status; }

    // Backwards compatibility
    public function getNomeProjeto() { return $this->getNome(); }
    public function getPrecoProjeto() { return $this->getPreco(); }
    public function getAtivo() { return $this->getStatus(); }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUrl($url) {
        $this->url = trim($url);
    }

    public function setImage($image) {
        $this->image = trim($image);
    }

    public function setNome($nome) {
        $nome = trim($nome);
        if (empty($nome)) {
            throw new InvalidArgumentException("Nome do projeto não pode ser vazio.");
        }
        $this->nome = $nome;
    }

    public function setNomeProjeto($nomeProjeto) {
        $this->setNome($nomeProjeto);
    }

    public function setPrecoProjeto($precoProjeto) {
        $this->setPreco($precoProjeto);
    }

    public function setTitulo($titulo) {
        $titulo = trim($titulo);
        if (empty($titulo)) {
            throw new InvalidArgumentException("Título do projeto não pode ser vazio.");
        }
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao) {
        $descricao = trim($descricao);
        if (empty($descricao)) {
            throw new InvalidArgumentException("Descrição do projeto não pode ser vazia.");
        }
        $this->descricao = $descricao;
    }

    public function setPreco($preco) {
        if ($preco < 0) {
            throw new InvalidArgumentException("Preço do projeto não pode ser menor que R\$0.");
        }
        $this->preco = $preco;
    }

    public function setCategoriaId($categoriaId) {
        if ($categoriaId < 0) {
            throw new InvalidArgumentException("O id da categoria é inválido.");
        }
        $this->categoriaId = $categoriaId;
    }

    public function setDevId($devId) {
        $this->devId = (int) $devId;
    }

    public function setStatus($status) {
        $this->status = (bool) $status;
    }

    public function setAtivo($ativo) {
        $this->setStatus($ativo);
    }
}
?>