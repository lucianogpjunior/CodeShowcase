<?php

namespace App\Config;

use PDO;
use PDOException;

class Conexao {
    private static $instancia = null;
    private static $env = null;


    public static function getConexao() {
        if (self::$instancia === null) {
            $modo = self::getEnvValue('DB_MODE', 'online');

            if (!in_array($modo, ['local', 'online'], true)) {
                throw new \RuntimeException(
                    'DB_MODE deve ser local ou online.'
                );
            }

            $prefixo = $modo === 'local' ? 'DB_LOCAL_' : 'DB_ONLINE_';

            $host = self::getEnvValue($prefixo . 'HOST');
            $name = self::getEnvValue($prefixo . 'NAME');
            $user = self::getEnvValue($prefixo . 'USER');
            $pass = self::getEnvValue($prefixo . 'PASSWORD');

            if (!$host || !$name || !$user || $pass === null) {
                throw new \RuntimeException(
                    "Configuração incompleta para o banco {$modo}."
                );
            }

            try {
                self::$instancia = new PDO(
                    "mysql:host={$host};dbname={$name};charset=utf8mb4",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    ]
                );
            } catch (PDOException $e) {
                error_log('Falha ao conectar ao banco de dados.');
                throw new \RuntimeException(
                    'Não foi possível conectar ao banco de dados.'
                );
            }
        }

        return self::$instancia;
    }


    private static function getEnvValue(string $key, $default = null) {
        if (self::$env === null) {
            self::loadEnv();
        }

        // Prioriza variáveis fornecidas pelo ambiente, como o Docker.
        $value = getenv($key);

        if ($value === false || $value === '') {
            $value = self::$env[$key] ?? null;
        }

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