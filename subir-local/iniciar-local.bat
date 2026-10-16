
@echo off
setlocal
cd /d "%~dp0"

echo Iniciando o CodeShowcase...
docker compose -f "codeshowcase-docker\compose.yaml" up -d

if errorlevel 1 (
    echo.
    echo Erro ao iniciar o Docker.
    pause
    exit /b 1
)

echo.
echo Projeto iniciado!
echo URL: http://localhost:8080
start "" "http://localhost:8080"

pause