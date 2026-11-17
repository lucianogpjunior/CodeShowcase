# CodeShowcase

A aplicação usa roteamento manual em `public/index.php`, templates em `src/Views/` e acesso a banco MySQL via PDO.

## Executando com Docker

Requer Docker Engine com o plugin Docker Compose. O script Linux cria
`codeshowcase-docker/.env` a partir do exemplo na primeira execução. Revise as
senhas desse arquivo antes de usar fora do ambiente local.

```bash
./subir-local/iniciar-local.sh
```

Ou suba manualmente a aplicação e o MySQL a partir da raiz:

```bash
docker compose -f codeshowcase-docker/compose.yaml up -d --build
```

A aplicação estará disponível em `http://localhost:8080`. O Compose configura a
conexão da aplicação para o serviço `db`, aguarda o MySQL ficar saudável e
aplica `codeshowcase/database/schema_local.sql` antes de iniciar a aplicação.
Assim, o esquema também é aplicado quando já existe um volume de banco criado.
Os scripts para iniciar, parar e consultar o ambiente Linux ficam em
`subir-local/`. Os volumes usam a opção `:Z` para permitir o acesso dos
containers em sistemas Fedora com SELinux habilitado.

A tabela `pedidos` registra o usuário, o projeto, o valor do pedido e o status
(`pendente`, `confirmado` ou `cancelado`); novos pedidos começam como
`pendente`.

## Pré-requisitos

- PHP 8.0 ou superior
- Extensão PHP `pdo` e `pdo_mysql`
- MySQL / MariaDB
- Composer
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
