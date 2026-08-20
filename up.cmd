@echo off
chcp 65001

set "project_name=Projeto Clinica 2026 - %date% %time%"
set "author=Josimar Ribeiro"
set "filename=README.md"
set "date_time=%DATE% %TIME%"
set "logo_url=https://github.com/Prof-Josimar/crud_php_poo_2026/blob/main/public/imagens/logo.png"

REM === Cria o README.md ===
echo # %project_name% > %filename%
echo. >> %filename%


echo. >> %filename%
echo. >> %filename%



echo ## Informações do sistema >> %filename%
echo - Data e hora: %date_time% >> %filename%
echo - Usuário: %USERNAME% >> %filename%
echo - Computador: %COMPUTERNAME% >> %filename%
echo - Diretório atual: %CD% >> %filename%
for /f "tokens=* delims=" %%g in ('git --version') do echo - %%g >> %filename%
echo. >> %filename%

echo ^<img src="%logo_url%" width="300"^> >> %filename%
echo. >> %filename%

REM === Bloco para git status ===
git status --porcelain >> %filename%

REM === Bloco de Download ===
echo. >> %filename%




echo. >> %filename%

echo ## Autor >> %filename%
echo %author% >> %filename%
echo. >> %filename%

set "logo_url=https://raw.githubusercontent.com/juanferreira-x/juanferreira-x/output/github-contribution-grid-snake.svg"


echo ^<img src="%logo_url%" width="600"^> >> %filename%

:::git init
git add . -v
git commit -m "first commit"
git branch -M main
git push -u origin main

start "" "https://github.com/Prof-Josimar/clinica"

