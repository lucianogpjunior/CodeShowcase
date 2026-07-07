<?php

namespace App\Models;

use InvalidArgumentException;

class UserEntity {
    private  $id;
    private  $nomeUsuario;
    private  $nomeCompleto;
    private  $email;
    private  $senha;
    private  $dataNascimento;
    private  $cpf;
    private  $dataCadastro;
    private  $status;

    public function __construct($id, $nomeUsuario, $nomeCompleto, $email, $senha, $dataNascimento, $cpf, $dataCadastro, $status = true) {
        $this->setId($id);
        $this->setNomeUsuario($nomeUsuario);
        $this->setNomeCompleto($nomeCompleto);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setDataNascimento($dataNascimento);
        $this->setCpf($cpf);
        $this->setDataCadastro($dataCadastro);
        $this->setStatus($status);
    }

    // Getters
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

    // Setters
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
        if (!filter_var($e, FILTER_VALIDATE_EMAIL))
            throw new InvalidArgumentException("Email inválido.");
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

    public function setCpf($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) !== 11) {
            throw new \InvalidArgumentException("CPF deve conter 11 dígitos.");
        }
        
        $this->cpf = $cpf;
    }

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
}

?>