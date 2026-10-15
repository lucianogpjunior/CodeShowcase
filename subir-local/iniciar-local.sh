#!/usr/bin/env bash

SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
COMPOSE_FILE="$SCRIPT_DIR/../codeshowcase-docker/compose.yaml"

echo "Iniciando o CodeShowcase..."
if ! docker compose -f "$COMPOSE_FILE" up -d; then
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
