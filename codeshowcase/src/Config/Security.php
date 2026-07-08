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

    public static function requireLogin(): void
    {
        if (empty($_SESSION['user']['id'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['user']['id']);
    }

    public static function getUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
}
?>