<?php
session_start();
require_once 'themes.php';

if (!isset($_SESSION['game_id'])) {
    header('Location: home.php');
    exit;
}

// Traiter l'action retour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    
    if ($action === 'go_back') {
        session_destroy();
        header('Location: home.php');
        exit;
    }
}

// Traiter la création du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = htmlspecialchars($_POST['pseudo'] ?? '', ENT_QUOTES, 'UTF-8');
    $avatar = htmlspecialchars($_POST['avatar'] ?? '', ENT_QUOTES, 'UTF-8');
    
    if (!empty($pseudo) && !empty($avatar)) {
        $_SESSION['player'] = [
            'pseudo' => $pseudo,
            'avatar' => $avatar,
            'id' => uniqid('player_')
        ];
        header('Location: create-game.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer votre profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="profile-page">
    <div class="container">
        <header>
            <h1>🎨 Créer votre profil</h1>
            <p class="subtitle">Choisissez votre pseudo et votre avatar</p>
        </header>

        <main>
            <form method="POST" class="profile-form">
                <div class="form-group">
                    <label for="pseudo">Votre pseudo:</label>
                    <input 
                        type="text" 
                        id="pseudo" 
                        name="pseudo"
                        class="input-field"
                        placeholder="Entrez un pseudo (3-15 caractères)"
                        minlength="3"
                        maxlength="15"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Choisissez votre avatar:</label>
                    <div class="avatar-grid">
                        <?php foreach ($AVATARS as $emoji => $name): ?>
                            <label class="avatar-option">
                                <input 
                                    type="radio" 
                                    name="avatar" 
                                    value="<?php echo $emoji; ?>"
                                    required
                                >
                                <span class="avatar-emoji"><?php echo $emoji; ?></span>
                                <span class="avatar-name"><?php echo $name; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="preview">
                    <h3>Aperçu:</h3>
                    <div class="preview-card">
                        <div class="preview-avatar" id="preview-avatar">😺</div>
                        <div class="preview-pseudo" id="preview-pseudo">Votre pseudo</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-large">
                    Continuer vers le jeu
                </button>
            </form>

            <form method="POST" class="back-button-form">
                <input type="hidden" name="action" value="go_back">
                <button type="submit" class="btn btn-secondary">
                    ← Retour
                </button>
            </form>
        </main>
    </div>

    <script>
        const pseudoInput = document.getElementById('pseudo');
        const avatarInputs = document.querySelectorAll('input[name="avatar"]');
        const previewAvatar = document.getElementById('preview-avatar');
        const previewPseudo = document.getElementById('preview-pseudo');

        pseudoInput.addEventListener('input', () => {
            previewPseudo.textContent = pseudoInput.value || 'Votre pseudo';
        });

        avatarInputs.forEach(input => {
            input.addEventListener('change', () => {
                previewAvatar.textContent = input.value;
            });
        });
    </script>
</body>
</html>
