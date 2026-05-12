<?php
session_start();

// Initialiser les variables de session
if (!isset($_SESSION['game_id'])) {
    $_SESSION['game_id'] = null;
    $_SESSION['player'] = null;
}

// Traiter les actions PHP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    
    if ($action === 'create_game') {
        // Créer une nouvelle partie
        $_SESSION['game_id'] = uniqid('game_');
        $_SESSION['games'] = $_SESSION['games'] ?? [];
        $_SESSION['games'][$_SESSION['game_id']] = [
            'players' => [],
            'status' => 'waiting',
            'current_round' => 0,
            'impostor' => null,
            'word' => null,
            'turn_order' => [],
            'current_player_index' => 0,
            'votes' => []
        ];
        header('Location: profile.php');
        exit;
    }
    
    if ($action === 'join_game') {
        $game_id = $_POST['game_id'] ?? null;
        $_SESSION['game_id'] = $game_id;
        header('Location: profile.php');
        exit;
    }
}

// Vérifier si un profil est déjà créé
if (isset($_SESSION['player']) && $_SESSION['player']) {
    header('Location: create-game.php');
    exit;
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
