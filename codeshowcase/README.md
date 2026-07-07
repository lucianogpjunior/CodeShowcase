# CodeShowcase

A aplicação usa roteamento manual em `public/index.php`, templates em `src/Views/` e acesso a banco MySQL via PDO.

## Pré-requisitos

- PHP 8.0 ou superior
- Extensão PHP `pdo` e `pdo_mysql`
- MySQL / MariaDB
- Composer (recomendado para gerar autoload)
- Permissão de escrita em `public/assets/uploads/` para upload de imagens

## Configuração do banco de dados

A configuração de conexão está em `src/Config/Conexao.php`.
.env.example <-- para variaveis de conexão

## Instalação

No diretório do projeto:

```bash
composer install
```

Se o `vendor/` já existir, este passo pode ser opcional, mas é recomendado para garantir o autoload.

## Executando localmente

Use o servidor embutido do PHP com `public` como diretório raiz:

```bash
php -S localhost:8000 -t public
```

Acesse a aplicação em:

- `http://localhost:8000/`
- `http://localhost:8000/home`

## Observações

- Upload de imagens é salvo em `public/assets/uploads/`.
- Se forem necessários outros dados ou credenciais, atualize `src/Config/Conexao.php`.
