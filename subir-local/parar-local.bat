
@echo off
setlocal
cd /d "%~dp0"

echo Parando o CodeShowcase...
docker compose -f "codeshowcase-docker\compose.yaml" stop

if errorlevel 1 (
    echo.
    echo Erro ao parar os containers.
    pause
    exit /b 1
)

echo.
echo Containers parados.
echo Os dados do banco foram preservados.

pause