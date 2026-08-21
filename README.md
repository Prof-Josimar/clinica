# Projeto PHP Aulas 2026 - 20/08/2026 22:01:06,51 
 
Menu → link para /saldo-resumido.php.
 
saldo-resumido.php → chama $dao- e lista todas as pessoas com seus saldos.
 
Cada linha tem um botão Ver Extrato, que envia idPessoa e nome para movimentacao-detalhe.php.
 
Assim você tem:
 
Visão geral: todos os saldos resumidos.
 
Visão detalhada: extrato completo da pessoa selecionada.
 
Estrutura final
 
movimentacao-create.php → pesquisa pessoa e permite depositar, sacar, transferir.
 
transferir.php → pesquisa destinatário e envia origem/destino para movimentar.php.
 
movimentar.php → grava operação (depósito, saque ou transferência).
 
movimentacao-list.php → lista todas as movimentações (detalhes por pessoa via botão).
 
movimentacao-detalhe.php → extrato detalhado + saldo da pessoa.
 
saldo-resumido.php → mostra saldo atual de todas as pessoas, sem parâmetro.
 
 
## Informações do sistema 
- Data e hora: 20/08/2026 22:01:06,51 
- Usuário: admin 
- Computador: FE16 
- Diretório atual: C:\dev\php\clinica 
- git version 2.55.0.windows.3 
 
<img src="https://github.com/Prof-Josimar/crud_php_poo_2026/blob/main/public/imagens/logo.png" width="300"> 
 
 M README.md
 M sql-banco/banco.sql
 
 
## Autor 
Josimar Ribeiro 
 
<img src="https://raw.githubusercontent.com/juanferreira-x/juanferreira-x/output/github-contribution-grid-snake.svg" width="600"> 
