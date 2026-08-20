
@echo off
REM Script para backup do banco chamada1 usando mysqldump

REM Configurações de conexão
set MYSQL_USER=root
set MYSQL_PASSWORD=
set MYSQL_DB=aulapdo


:: %MYSQL_DB%_%date:~6,4%-%date:~3,2%-%date:~0,2%_%time:~0,2%-%time:~3,2%
REM Nome do arquivo de backup (com data/hora)

set BACKUP_FILE=.\src\banco.sql

REM Executar mysqldump
::mysqldump -p -u %MYSQL_USER% -p%MYSQL_PASSWORD% %MYSQL_DB% > "%BACKUP_FILE%"
c:\xampp\mysql\bin\mysqldump -u %MYSQL_USER% %MYSQL_DB% > "%BACKUP_FILE%"
