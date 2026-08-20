@echo off
chcp 65001

set "project_name=Projeto PHP Aulas 2026 - %date% %time%"
set "author=Josimar Ribeiro"
set "filename=README.md"
set "date_time=%DATE% %TIME%"
set "logo_url=https://github.com/Prof-Josimar/crud_php_poo_2026/blob/main/public/imagens/logo.png"

REM === Cria o README.md ===
echo # %project_name% > %filename%
echo. >> %filename%


echo Menu → link para /saldo-resumido.php.>> %filename%
echo. >> %filename%
echo saldo-resumido.php → chama $dao->getSaldosResumidos() e lista todas as pessoas com seus saldos.>> %filename%
echo. >> %filename%
echo Cada linha tem um botão Ver Extrato, que envia idPessoa e nome para movimentacao-detalhe.php.>> %filename%
echo. >> %filename%
echo Assim você tem:>> %filename%
echo. >> %filename%
echo Visão geral: todos os saldos resumidos.>> %filename%
echo. >> %filename%
echo Visão detalhada: extrato completo da pessoa selecionada.>> %filename%
echo. >> %filename%
echo Estrutura final>> %filename%
echo. >> %filename%
echo movimentacao-create.php → pesquisa pessoa e permite depositar, sacar, transferir.>> %filename%
echo. >> %filename%
echo transferir.php → pesquisa destinatário e envia origem/destino para movimentar.php.>> %filename%
echo. >> %filename%
echo movimentar.php → grava operação (depósito, saque ou transferência).>> %filename%
echo. >> %filename%
echo movimentacao-list.php → lista todas as movimentações (detalhes por pessoa via botão).>> %filename%
echo. >> %filename%
echo movimentacao-detalhe.php → extrato detalhado + saldo da pessoa.>> %filename%
echo. >> %filename%
echo saldo-resumido.php → mostra saldo atual de todas as pessoas, sem parâmetro.>> %filename%
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

start "" "https://github.com/Prof-Josimar/crud_php_poo_2026"

