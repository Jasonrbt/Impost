<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/themes.php';

// Must have a game_id to set up a profile.
if (empty($_SESSION['game_id'])) {
    header('Location: home.php');
    exit;
}

// Handle all POST actions in one block.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'go_back') {
        // Clear game state and return home.
        unset($_SESSION['game_id'], $_SESSION['player']);
        header('Location: home.php');
        exit;
    }

    // Profile creation form submission.
    $pseudo = trim($_POST['pseudo'] ?? '');
    $avatar = trim($_POST['avatar'] ?? '');

    if ($pseudo !== '' && $avatar !== '') {
        $pseudo = htmlspecialchars($pseudo, ENT_QUOTES, 'UTF-8');
        $avatar = htmlspecialchars($avatar, ENT_QUOTES, 'UTF-8');

        $_SESSION['player'] = [
            'pseudo' => $pseudo,
            'avatar' => $avatar,
            'id'     => uniqid('player_'),
        ];
        header('Location: create-game.php');
        exit;
    }

    // Validation failed — fall through to show the form with an error.
    $profile_error = 'Veuillez choisir un pseudo et un avatar.';
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
            <?php if (!empty($profile_error)): ?>
                <p style="color:#ff6b6b;font-weight:600;text-align:center;margin-bottom:15px;"><?php echo htmlspecialchars($profile_error); ?></p>
            <?php endif; ?>
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
