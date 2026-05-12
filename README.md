# 🎭 Qui est l'Imposteur?

Une application web interactive pour jouer au jeu classique "Qui est l'Imposteur?" en ligne avec vos amis.

## 🎮 Caractéristiques

- ✅ **Jusqu'à 8 joueurs** par partie
- ✅ **Création rapide de profil** sans enregistrement
- ✅ **Avatars manga/animé personnalisables** 🐸🦊🐉
- ✅ **2 tours par joueur** 
- ✅ **1 mot par tour** par joueur
- ✅ **Minuteur de 30 secondes** par joueur
- ✅ **Système de vote** pour éliminer le suspect
- ✅ **Interface responsive** (mobile, tablet, desktop)
- ✅ **Code de partage** pour inviter vos amis

## 🚀 Installation

### Prérequis
- PHP 7.4 ou supérieur
- Un navigateur web moderne
- Un serveur web local (Apache, Nginx, etc.) OU utiliser le serveur intégré de PHP

### Démarrage rapide avec PHP intégré

1. Ouvrez un terminal dans le répertoire du projet
2. Exécutez:
   ```bash
   php -S localhost:8000
   ```
3. Ouvrez votre navigateur à `http://localhost:8000`

### Avec Apache/Nginx

1. Placez le dossier dans votre répertoire web
2. Accédez à l'application via votre domaine ou localhost

## 📝 Comment jouer

### 1️⃣ Créer/Rejoindre une partie
- Cliquez sur "Créer une nouvelle partie" pour démarrer une nouvelle partie
- Partagez le code avec vos amis pour qu'ils la rejoignent
- Ou rejoignez une partie existante avec un code

### 2️⃣ Créer votre profil
- Entrez un pseudo (3-15 caractères)
- Choisissez votre avatar parmi 16 options manga/animé
- Cliquez sur "Continuer vers le jeu"

### 3️⃣ Attendre les autres joueurs
- Attendez que vos amis rejoignent la partie
- Le créateur démarre le jeu quand il y a au moins 2 joueurs

### 4️⃣ Sélection du mot
- Le premier joueur sélectionne un mot secret
- Les autres joueurs voient ce mot, sauf l'imposteur!

### 5️⃣ Jouer
- Chaque joueur a 30 secondes pour dire UN mot
- L'imposteur doit deviner le mot secret en écoutant
- Les autres joueurs doivent déterminer qui est l'imposteur

### 6️⃣ Voter
- Après 2 tours, tous les joueurs votent
- Le joueur avec le plus de votes est éliminé
- Si c'est l'imposteur, les citoyens gagnent!
- Si ce n'est pas l'imposteur, le jeu continue

## 🎨 Avatars Disponibles

| Emoji | Nom |
|-------|------|
| 😺 | Chat noir |
| 🐸 | Grenouille |
| 🦊 | Renard |
| 🐰 | Lapin |
| 🦁 | Lion |
| 🐺 | Loup |
| 🦆 | Canard |
| 🐉 | Dragon |
| 👹 | Démon |
| 🧟 | Zombie |
| 🤖 | Robot |
| 👽 | Alien |
| ⛩️ | Temple |
| 🎌 | Drapeau |
| 🎎 | Poupées |
| 🗾 | Japon |

## 📁 Structure des fichiers

```
Impost/
├── index.php          # Page d'accueil
├── profile.php        # Création de profil
├── game.php           # Page principale du jeu
├── styles.css         # Styles et thème
└── README.md          # Ce fichier
```

## 🛠️ Technologie

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP (sessions côté serveur)
- **Stockage**: Sessions PHP (pas de base de données requise)

## 🎯 Règles du jeu

1. **L'imposteur** connaît la catégorie mais pas le mot secret
2. **Les citoyens** connaissent le mot secret
3. Chaque joueur doit dire UN mot qui se rapporte au mot secret
4. L'imposteur essaie de deviner le mot en écoutant
5. Les citoyens essaient d'identifier l'imposteur
6. Après 2 tours, vote pour éliminer le suspect
7. **Victoire citoyens**: L'imposteur est éliminé
8. **Victoire imposteur**: Il divine le mot OU tous les citoyens sont éliminés

## 💡 Conseils de jeu

- Donnez des indices évidentes mais pas trop directes!
- Observez qui dit des choses étranges
- L'imposteur peut deviner le mot dès qu'il le sait
- Utilisez des synonymes ou des mots liés au thème

## 🐛 Dépannage

**"Le jeu ne démarre pas"**
- Vérifiez que PHP est installé: `php -v`
- Vérifiez que le port 8000 est disponible
- Essayez un autre port: `php -S localhost:8001`

**"Je ne peux pas rejoindre une partie"**
- Vérifiez que le code de partie est correct
- Vérifiez que la partie n'a pas déjà 8 joueurs

**"Les cookies/sessions ne fonctionnent pas"**
- Acceptez les cookies de votre navigateur
- Essayez avec un onglet de navigation privée si le problème persiste

## 📞 Support

Pour tout problème ou suggestion, veuillez vérifier la configuration de votre serveur PHP et vos paramètres de navigateur.

## 📄 Licence

Projet libre d'utilisation. Amusez-vous! 🎉

---

Développé avec ❤️ | Version 1.0 | 2026
