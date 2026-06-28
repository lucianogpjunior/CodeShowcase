<?php

namespace App\Config;

use PDO;
use PDOException;

class Conexao {
    private static $instancia = null;

    public static function getConexao() {
      if (self::$instancia === null) {
        try {
          self::$instancia = new PDO(
            "mysql:host=127.0.0.1;dbname=code_showcase_db;charset=utf8",
            "root",
            ""
          );
          self::$instancia->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
          );
        } catch (PDOException $e) {
          die("Erro: " . $e->getMessage());
        }
      }
      return self::$instancia;
    }
}
?>