<?php

class UserEntity {
    private  $id;
    private  $nomeCompleto;
    private  $email;
    private  $dataNascimento;
    private  $cpf;
    private  $senha;
    private  $dataCadastro;

    public function __construct($id, $nomeCompleto, $email, $dataNascimento, $cpf, $senha, $dataCadastro) {
        $this->setId($id);
        $this->setNomeCompleto($nomeCompleto);
        $this->setEmail($email);
        $this->setDataNascimento($dataNascimento);
        $this->setCpf($cpf);
        $this->setSenha($senha);
        $this->setDataCadastro($dataCadastro);
    }
    //getters
    public function getId() {
        return $this->id;
    }

    public function getNomeCompleto() {
        return $this->nomeCompleto;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    //setters
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
        if(!filter_var($e, FILTER_VALIDATE_EMAIL))
            throw new InvalidArgumentException("Email inválido.");
        $this->email = $e;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    public function setCpf($cpf) {
        $this->cpf = preg_replace('/[^0-9]/', '', $cpf);

        if(strlen($cpf) !== 11){
            throw new InvalidArgumentException("CPF deve conter 11 dígitos.");
        }

        $this->cpf = $cpf;
    }

    public function setSenha($senha) {
        if (password_get_info($senha)['a'] === 0) {
            $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        } else {
            $this->senha = $senha;
        }
    }

    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }
}

?>