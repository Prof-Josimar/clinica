@echo off
REM === Git ===
git branch -M main
git add . -v


set /p c=Digite o comentário: 

git commit -m "Atualizado em %date% %time% (%c%)"
git push origin main


git push -u origin main
