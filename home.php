<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle POST actions.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create_game') {
        // Reset any previous game/player state and create a fresh game.
        $game_id = uniqid('game_');
        $_SESSION['game_id'] = $game_id;
        $_SESSION['player']  = null;
        if (!isset($_SESSION['games'])) {
            $_SESSION['games'] = [];
        }
        $_SESSION['games'][$game_id] = [
            'players'               => [],
            'status'                => 'waiting',
            'game_phase'            => 'lobby',
            'current_round'         => 0,
            'impostor_id'           => null,
            'word'                  => null,
            'decoy_word'            => null,
            'theme'                 => null,
            'turn_order'            => [],
            'current_player_index'  => 0,
            'turns_played'          => [],
            'votes'                 => [],
        ];
        header('Location: profile.php');
        exit;
    }

    if ($action === 'join_game') {
        $game_id = trim($_POST['game_id'] ?? '');
        if ($game_id !== '') {
            $_SESSION['game_id'] = $game_id;
            $_SESSION['player']  = null;
            header('Location: profile.php');
            exit;
        }
        // Fall through to show the form again with an error.
        $join_error = 'Veuillez entrer un code de partie valide.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qui est l'Imposteur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="welcome-page">
    <div class="container">
        <header>
            <h1>🎭 Qui est l'Imposteur?</h1>
            <p class="subtitle">Le jeu de déduction ultime</p>
        </header>

        <main>
            <div class="welcome-content">
                <section class="game-info">
                    <h2>Comment ça marche?</h2>
                    <ul>
                        <li>🎮 Chaque joueur possède 1 mot en commun, sauf un qui est l'imposteur. Le but des citoyen trouver l'imposteur, le but de l'imposteur ne pas se faire remarquer</li>
                        <li>👥 Maximum 8 joueurs</li>
                        <li>💬 1 mot par tour par joueur</li>
                        <li>⏱️ 30 secondes par tour</li>
                        <li>🔄 2 tours par joueur</li>
                        <li>🕵️ Trouvez l'imposteur!</li>
                    </ul>
                </section>

                <div class="actions">
                    <form method="POST" class="form-action">
                        <input type="hidden" name="action" value="create_game">
                        <button type="submit" class="btn btn-primary">
                            Créer une nouvelle partie
                        </button>
                    </form>

                    <div class="divider">OU</div>

                    <form method="POST" class="form-action">
                        <input type="hidden" name="action" value="join_game">
                        <?php if (!empty($join_error)): ?>
                            <p style="color:#ff6b6b;font-weight:600;"><?php echo htmlspecialchars($join_error); ?></p>
                        <?php endif; ?>
                        <input 
                            type="text" 
                            name="game_id" 
                            placeholder="Entrez le code de la partie"
                            class="input-field"
                            required
                        >
                        <button type="submit" class="btn btn-secondary">
                            Rejoindre une partie
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
