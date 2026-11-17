#!/usr/bin/env bash

SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
COMPOSE_FILE="$SCRIPT_DIR/../codeshowcase-docker/compose.yaml"

echo "Parando o CodeShowcase..."
if ! docker compose -f "$COMPOSE_FILE" stop; then
    echo
    echo "Erro ao parar os containers." >&2
    read -r -p "Pressione Enter para continuar..."
    exit 1
fi

echo
echo "Containers parados."
echo "Os dados do banco foram preservados."

read -r -p "Pressione Enter para continuar..."
