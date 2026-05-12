# Architecture Réorganisée

## Structure des fichiers

### Pages principales
- **index.php** - Point d'entrée (redirige vers home.php)
- **home.php** - Page d'accueil avec options "Créer" ou "Rejoindre" une partie
- **profile.php** - Création du profil (pseudo + avatar) avec bouton retour
- **create-game.php** - Salle d'attente + sélection du thème avec bouton retour
- **game.php** - Écran de jeu (phases playing, voting, round_end, game_end) avec bouton retour

### Fichiers de configuration
- **themes.php** - Tous les thèmes, mots, avatars et mots trompeurs
- **config.php** - Configuration générale (non utilisé actuellement)

## Flux de navigation

```
index.php (point d'entrée)
    ↓
home.php (créer ou rejoindre)
    ├─→ Créer partie
    │   ↓
    │   profile.php (créer profil) ← Retour
    │   ↓
    │   create-game.php (salle attente + thème) ← Retour
    │   ↓
    │   game.php (parties) ← Retour
    │
    └─→ Rejoindre partie
        ↓
        profile.php (créer profil) ← Retour
        ↓
        create-game.php (salle attente + thème) ← Retour
        ↓
        game.php (parties) ← Retour
```

## Boutons de retour disponibles

- **profile.php** → Retour à home.php
- **create-game.php** → Retour à home.php
- **game.php** (tous les écrans) → Retour à home.php

Chaque bouton de retour réinitialise la session et ramène l'utilisateur à la page d'accueil.
