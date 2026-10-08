<?php

namespace App\Models;

use InvalidArgumentException;

class UsuarioDevEntity {
    private $id;
    private $usuarioId;
    private $dtCadastro;
    private $githubUrlPerfil;
    private $linkedinUrl;
    private ?UserEntity $usuario = null;

    public function __construct($id, $usuarioId, $dtCadastro, $githubUrlPerfil = null, $linkedinUrl = null) {
        $this->setId($id);
        $this->setUsuarioId($usuarioId);
        $this->setDtCadastro($dtCadastro);
        $this->setGithubUrlPerfil($githubUrlPerfil);
        $this->setLinkedinUrl($linkedinUrl);
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

    public function getGithubUrlPerfil() {
        return $this->githubUrlPerfil;
    }

    public function getLinkedinUrl() {
        return $this->linkedinUrl;
    }

    public function getUsuario(): ?UserEntity {
        return $this->usuario;
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

    public function setGithubUrlPerfil($githubUrlPerfil) {
        $githubUrlPerfil = trim((string) ($githubUrlPerfil ?? ''));

        if ($githubUrlPerfil !== '' && !filter_var($githubUrlPerfil, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("URL do GitHub inválida.");
        }

        $this->githubUrlPerfil = $githubUrlPerfil;
    }

    public function setLinkedinUrl($linkedinUrl) {
        $linkedinUrl = trim((string) ($linkedinUrl ?? ''));

        if ($linkedinUrl !== '' && !filter_var($linkedinUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("URL do LinkedIn inválida.");
        }

        $this->linkedinUrl = $linkedinUrl;
    }

    public function setUsuario(?UserEntity $usuario): void {
        $this->usuario = $usuario;
    }
}
?>