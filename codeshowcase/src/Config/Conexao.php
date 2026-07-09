<?php

namespace App\Config;

use PDO;
use PDOException;

class Conexao {
    private static $instancia = null;
    private static $env = null;

    public static function getConexao() {
        if (self::$instancia === null) {
            $host    = self::getEnvValue('DB_HOST');
            $name    = self::getEnvValue('DB_NAME');
            $user    = self::getEnvValue('DB_USER');
            $pass    = self::getEnvValue('DB_PASSWORD');

            try {
                self::$instancia = new PDO(
                    "mysql:host={$host};dbname={$name}",
                    $user,
                    $pass
                );
                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro: " . $e->getMessage());
            }
        }

        return self::$instancia;
    }

    private static function getEnvValue(string $key, $default = null) {
        if (self::$env === null) {
            self::loadEnv();
        }

        $value = self::$env[$key] ?? null;
        if ($value === null || $value === '') {
            return $default;
        }

        return $value;
    }

    private static function loadEnv(): void {
        self::$env = [];
        $envPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($envPath)) {
            return;
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);

            if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
                $value = substr($value, 1, -1);
            } elseif (str_starts_with($value, "'") && str_ends_with($value, "'")) {
                $value = substr($value, 1, -1);
            }

            self::$env[$key] = $value;
        }
    }
}
?>