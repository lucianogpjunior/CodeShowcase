<?php

namespace App\Models;

use InvalidArgumentException;

class UserEntity {
    private $id;
    private $nomeUsuario;
    private $nomeCompleto;
    private $email;
    private $senha;
    private $dataNascimento;
//    private $cpf;
    private $dataCadastro;
    private $status;
    private $role;

    public function __construct($id, $nomeUsuario, $nomeCompleto, $email, $senha, $dataNascimento, $dataCadastro = null, $status = true, $role = 'COMUM') {
        $this->setId($id);
        $this->setNomeUsuario($nomeUsuario);
        $this->setNomeCompleto($nomeCompleto);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setDataNascimento($dataNascimento);
//        $this->setCpf($cpf);
        $this->setDataCadastro($dataCadastro);
        $this->setStatus($status);
        $this->setRole($role);
    }

    public function getId() {
        return $this->id;
    }

    public function getNomeUsuario() {
        return $this->nomeUsuario;
    }

    public function getNomeCompleto() {
        return $this->nomeCompleto;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getRole() {
        return $this->role;
    }

    public function isDeveloper(): bool {
        return $this->role === 'DESENVOLVEDOR';
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNomeCompleto($nomeCompleto) {
        $nomeCompleto = trim($nomeCompleto);

        if (empty($nomeCompleto)) {
            throw new InvalidArgumentException("Nome completo não pode ser vazio.");
        }

        $this->nomeCompleto = $nomeCompleto;
    }

    public function setEmail($e) {
        if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido.");
        }
        $this->email = $e;
    }

    public function setNomeUsuario($nomeUsuario) {
        $nomeUsuario = trim($nomeUsuario);
        if (empty($nomeUsuario)) {
            throw new InvalidArgumentException("Nome de usuário não pode ser vazio.");
        }
        $this->nomeUsuario = $nomeUsuario;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

/*    public function setCpf($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) === 0) {
            $this->cpf = null;
            return;
        }

        if (strlen($cpf) !== 11) {
            throw new \InvalidArgumentException("CPF deve conter 11 dígitos.");
        }

        $this->cpf = $cpf;
    }
*/
    public function setSenha($senha) {
        $info = password_get_info($senha);

        if ($info['algo'] === null) {
            $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        } else {
            $this->senha = $senha;
        }
    }

    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    public function setStatus($status) {
        $this->status = (bool) $status;
    }

    public function setRole($role) {
        if (is_bool($role)) {
            $this->role = $role ? 'DESENVOLVEDOR' : 'COMUM';
            return;
        }

        $role = strtoupper(trim((string) $role));
        if (!in_array($role, ['COMUM', 'DESENVOLVEDOR'], true)) {
            $this->role = 'COMUM';
            return;
        }

        $this->role = $role;
    }
}

?>