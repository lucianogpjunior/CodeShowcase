#!/usr/bin/env bash

SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
COMPOSE_FILE="$SCRIPT_DIR/../codeshowcase-docker/compose.yaml"

echo "Status dos containers do CodeShowcase:"
echo
docker compose -f "$COMPOSE_FILE" ps

echo
read -r -p "Pressione Enter para continuar..."
