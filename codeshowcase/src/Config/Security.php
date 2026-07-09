<?php

namespace App\Config;

class Security
{
    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $cookieParams = [
                'lifetime' => 0,
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true,
                'samesite' => 'Lax'
            ];

            if (!empty($_SERVER['HTTP_HOST'])) {
                $host = explode(':', $_SERVER['HTTP_HOST'])[0];
                if (filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) || $host === 'localhost') {
                    $cookieParams['domain'] = $host;
                }
            }

            session_set_cookie_params($cookieParams);
            session_start();
        }
    }

    public static function generateCsrfToken(): string
    {
        self::initSession();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken(?string $token): bool
    {
        self::initSession();

        return is_string($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function normalizeRole(mixed $role): string
    {
        if (is_bool($role)) {
            return $role ? 'DESENVOLVEDOR' : 'COMUM';
        }

        $role = strtoupper(trim((string) $role));

        return in_array($role, ['COMUM', 'DESENVOLVEDOR'], true) ? $role : 'COMUM';
    }

    public static function requireLogin(): void
    {
        self::initSession();

        if (empty($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireRole(array $roles): void
    {
        self::requireLogin();

        $currentRole = self::getUserRole();
        $allowedRoles = array_map([self::class, 'normalizeRole'], $roles);

        if (!in_array($currentRole, $allowedRoles, true)) {
            header('Location: /projetos');
            exit;
        }
    }

    public static function isLoggedIn(): bool
    {
        self::initSession();
        return !empty($_SESSION['user']['id']);
    }

    public static function isDeveloper(): bool
    {
        return self::getUserRole() === 'DESENVOLVEDOR';
    }

    public static function getUserRole(): string
    {
        self::initSession();

        $user = $_SESSION['user'] ?? [];
        $role = $user['role'] ?? null;

        if (isset($user['is_dev']) && $user['is_dev'] && empty($role)) {
            $role = 'DESENVOLVEDOR';
        }

        return self::normalizeRole($role);
    }

    public static function getUser(): ?array
    {
        self::initSession();
        return $_SESSION['user'] ?? null;
    }
}
?>