
@echo off
setlocal
cd /d "%~dp0"

echo Status dos containers do CodeShowcase:
echo.
docker compose -f "codeshowcase-docker\compose.yaml" ps

echo.
pause