<?php

namespace App\Controller;

use App\Models\UserEntity;
use App\DAO\UserDAO;
use App\DAO\UsuarioDevDAO;
use App\Config\Security;
use App\Models\UsuarioDevEntity;

require_once __DIR__ . '/../../vendor/autoload.php';

class UserController {

    // Métodos de view
    public function cadastroView() {
        Security::initSession();
        require __DIR__ . '/../Views/CadastroUserView.php';
    }

    public function loginView() {
        Security::initSession();
        require __DIR__ . '/../Views/LoginView.php';
    }

    public function devCadastroView() {
        Security::requireLogin();
        require __DIR__ . '/../Views/CadastroDevView.php';
    }

    // Métodos de usuário
    public function createUser() {
        Security::initSession();

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? null)) {
            die('Token CSRF inválido.');
        }

        $nomeUsuario  = trim($_POST['nome_usuario'] ?? '');
        $nome         = trim($_POST['nome'] ?? '');
        $email        = trim($_POST['email'] ?? '');
        $dtNascimento = $_POST['dtNascimento'] ?? '';
        $senha        = $_POST['senha'] ?? '';

        if (
            empty($nomeUsuario) ||
            empty($nome) ||
            empty($email) ||
            empty($dtNascimento) ||
            empty($senha)
        ) {
            die("Todos os campos são obrigatórios.");
        }

        $user = new UserEntity(
            null,
            $nomeUsuario,
            $nome,
            $email,
            $senha,
            $dtNascimento,
            date('Y-m-d H:i:s'),
            true,
            'COMUM'
        );

        $userDAO = new UserDAO();
        $userDAO->create($user);

        header('Location: /login');
        exit;
    }

    public function login() {
        Security::initSession();

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? null)) {
            die('Token CSRF inválido.');
        }

        $login = trim($_POST['login'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (empty($login) || empty($senha)) {
            die('Login e senha são obrigatórios.');
        }

        $userDAO = new UserDAO();
        $user = $userDAO->findByLogin($login);

        if (!$user || !password_verify($senha, $user->getSenha())) {
            die('Usuário ou senha inválidos.');
        }

        if (!$user->getStatus()) {
            die('Esta conta está desativada.');
        }

        session_regenerate_id(true);

        $devDAO = new UsuarioDevDAO();
        $usuarioDev = $devDAO->readByUsuarioId($user->getId());

        $role = $user->getRole();
        if ($usuarioDev !== null) {
            $role = 'DESENVOLVEDOR';
            if ($user->getRole() !== $role) {
                $userDAO->updateRole($user->getId(), $role);
            }
        }

        $_SESSION['user'] = [
            'id' => $user->getId(),
            'nome' => $user->getNomeCompleto(),
            'nome_usuario' => $user->getNomeUsuario(),
            'email' => $user->getEmail(),
            'role' => $role,
            'is_dev' => $usuarioDev !== null,
            'dev_id' => $usuarioDev ? $usuarioDev->getId() : null
        ];

        header('Location: /home');
        exit;
    }

    public function logout() {
        Security::initSession();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: /login');
        exit;
    }

    public function createDev() {
        Security::requireLogin();

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? null)) {
            die('Token CSRF inválido.');
        }

        $userId = (int) ($_SESSION['user']['id'] ?? 0);
        $githubUrl = trim($_POST['github_url_perfil'] ?? '');
        $linkedinUrl = trim($_POST['linkedin_url'] ?? '');

        if ($githubUrl === '' && isset($_POST['github_url_perfil'])) {
            $githubUrl = trim((string) $_POST['github_url_perfil']);
        }

        if ($linkedinUrl === '' && isset($_POST['linkedin_url'])) {
            $linkedinUrl = trim((string) $_POST['linkedin_url']);
        }

        if ($userId <= 0) {
            die('Sessão inválida.');
        }

        if (empty($githubUrl) || empty($linkedinUrl)) {
            die('Preencha os dados do perfil do desenvolvedor.');
        }

        $devDAO = new UsuarioDevDAO();
        $userDAO = new UserDAO();

        if ($devDAO->readByUsuarioId($userId)) {
            die('Você já é um desenvolvedor.');
        }

        $usuarioDev = new UsuarioDevEntity(null, $userId, date('Y-m-d H:i:s'));
        $usuarioDev->setGithubUrlPerfil($githubUrl);
        $usuarioDev->setLinkedinUrl($linkedinUrl);

        $devDAO->create($usuarioDev);

        $userDAO->updateRole($userId, 'DESENVOLVEDOR');

        $_SESSION['user']['is_dev'] = true;
        $_SESSION['user']['role'] = 'DESENVOLVEDOR';
        $_SESSION['user']['dev_id'] = $usuarioDev->getId();

        header('Location: /home');
        exit;
    }

    public function deleteUser() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: ../index.php');
            exit;
        }

        $id  = (int) $_GET['id'];
        $dao = new UserDAO();
        $dao->delete($id);

        header('Location: ../index.php');
        exit;
    }

    public function updateUser() {
        // CORRIGIDO: era is_numeric(['id']) — array literal em vez de $_POST['id']
        // isso fazia a validação nunca funcionar corretamente
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            header('Location: ../index.php');
            exit;
        }

        $dao  = new UserDAO();
        $user = $dao->read((int) $_POST['id']);

        if (!$user) {
            header('Location: ../index.php');
            exit;
        }

        $user->setNomeCompleto($_POST['nome']);
        $user->setEmail($_POST['email']);
        $user->setDataNascimento($_POST['dtNascimento']);
        //$user->setCpf($_POST['cpf']);
        $user->setSenha($_POST['senha']);

        $dao->update($user);

        header('Location: ../index.php');
        exit;
    }
}
?>