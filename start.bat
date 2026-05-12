@echo off
REM Script de démarrage de l'application "Qui est l'Imposteur?" pour Windows
REM Usage: double-cliquez sur start.bat

echo.
echo 🎭 Qui est l'Imposteur? - Demarrage du serveur
echo =============================================
echo.

REM Vérifier si PHP est installé
php -v >nul 2>&1
if errorlevel 1 (
    echo ❌ PHP n'est pas installe ou n'est pas dans le PATH
    echo Veuillez installer PHP 7.4 ou superieur
    pause
    exit /b 1
)

REM Afficher la version PHP
echo ✓ PHP trouve:
php -v | find /V "" | findstr /R "^"

echo.
echo 🚀 Demarrage du serveur Web...
echo 📍 URL: http://localhost:8000
echo ⏹️  Appuyez sur Ctrl+C pour arreter le serveur
echo.

REM Démarrer le serveur PHP
php -S localhost:8000

pause
exit /b 0
