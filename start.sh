#!/bin/bash

# Script de démarrage de l'application "Qui est l'Imposteur?"
# Usage: ./start.sh

echo "🎭 Qui est l'Imposteur? - Démarrage du serveur"
echo "=============================================="
echo ""

# Vérifier si PHP est installé
if ! command -v php &> /dev/null; then
    echo "❌ PHP n'est pas installé ou n'est pas dans le PATH"
    echo "Veuillez installer PHP 7.4 ou supérieur"
    exit 1
fi

# Afficher la version PHP
echo "✓ PHP trouvé:"
php -v | head -n 1

echo ""
echo "🚀 Démarrage du serveur Web..."
echo "📍 URL: http://localhost:8000"
echo "⏹️  Appuyez sur Ctrl+C pour arrêter le serveur"
echo ""

# Démarrer le serveur PHP
php -S localhost:8000

exit 0
