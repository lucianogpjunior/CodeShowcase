#!/usr/bin/env bash

SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
COMPOSE_FILE="$SCRIPT_DIR/../codeshowcase-docker/compose.yaml"
ENV_FILE="$SCRIPT_DIR/../codeshowcase-docker/.env"
ENV_EXAMPLE="$SCRIPT_DIR/../codeshowcase-docker/.env.example"

echo "Iniciando o CodeShowcase..."
if ! command -v docker >/dev/null 2>&1 || ! docker compose version >/dev/null 2>&1; then
    echo "Docker e o plugin Docker Compose precisam estar instalados." >&2
    exit 1
fi

if [[ ! -f "$ENV_FILE" ]]; then
    cp -- "$ENV_EXAMPLE" "$ENV_FILE"
    echo "Arquivo .env criado em codeshowcase-docker/.env."
    echo "Revise as senhas desse arquivo antes de usar o projeto fora do ambiente local."
fi

if ! docker compose -f "$COMPOSE_FILE" up -d --build; then
    echo
    echo "Erro ao iniciar o Docker." >&2
    read -r -p "Pressione Enter para continuar..."
    exit 1
fi

echo
echo "Projeto iniciado!"
echo "URL: http://localhost:8080"
xdg-open "http://localhost:8080" >/dev/null 2>&1 &

read -r -p "Pressione Enter para continuar..."
