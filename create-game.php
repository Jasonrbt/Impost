<?php
session_start();
require_once 'themes.php';

if (!isset($_SESSION['player'])) {
    header('Location: home.php');
    exit;
}

$player = $_SESSION['player'];
$game_id = $_SESSION['game_id'];

// Initialiser ou récupérer la partie
if (!isset($_SESSION['games'][$game_id])) {
    $_SESSION['games'][$game_id] = [
        'players' => [],
        'status' => 'waiting',
        'current_round' => 0,
        'impostor_id' => null,
        'word' => null,
        'decoy_word' => null,
        'theme' => null,
        'turn_order' => [],
        'current_player_index' => 0,
        'turns_played' => [],
        'votes' => [],
        'game_phase' => 'lobby'
    ];
}

$game = &$_SESSION['games'][$game_id];

// Ajouter le joueur à la partie
if (!isset($game['players'][$player['id']])) {
    if (count($game['players']) >= 8) {
        header('Location: home.php');
        exit;
    }
    $game['players'][$player['id']] = [
        'pseudo' => $player['pseudo'],
        'avatar' => $player['avatar'],
        'id' => $player['id'],
        'eliminated' => false,
        'is_impostor' => false
    ];
}

// Traiter les actions du jeu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    
    if ($action === 'leave_game') {
        session_destroy();
        header('Location: home.php');
        exit;
    }
    
    if ($action === 'start_game' && $game['status'] === 'waiting') {
        if (count($game['players']) >= 2) {
            $game['status'] = 'playing';
            $game['game_phase'] = 'theme_selection';
            
            // Sélectionner l'imposteur aléatoirement
            $player_ids = array_keys($game['players']);
            $game['impostor_id'] = $player_ids[array_rand($player_ids)];
            
            // Initialiser les tours
            $game['turns_played'] = array_fill_keys($player_ids, 0);
            shuffle($player_ids);
            $game['turn_order'] = $player_ids;
            $game['current_player_index'] = 0;
            $game['current_round'] = 1;
        }
    }
    
    if ($action === 'select_theme' && ($game['game_phase'] ?? 'lobby') === 'theme_selection') {
        $theme = htmlspecialchars($_POST['theme'] ?? '', ENT_QUOTES, 'UTF-8');
        if (isset($GAME_THEMES[$theme])) {
            $game['theme'] = $theme;
            $words = $GAME_THEMES[$theme];
            
            // Choisir un mot secret aléatoire
            $game['word'] = $words[array_rand($words)];
            
            // Choisir un mot décoy aléatoire (différent du mot secret)
            $game['decoy_word'] = $DECOY_WORDS[array_rand($DECOY_WORDS)];
            
            $game['game_phase'] = 'playing';
            $game['current_round'] = 1;
            $game['current_player_index'] = 0;
            $game['phase_start_time'] = time();
        }
    }
}

// Récupérer les données du jeu
$game_code = substr($game_id, 5);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle d'attente - Qui est l'Imposteur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="game-page">
    <div class="container">
        <header class="game-header">
            <div class="game-info-top">
                <h1>🎭 Qui est l'Imposteur?</h1>
                <div class="game-code">Code: <strong><?php echo $game_code; ?></strong></div>
            </div>
            <div class="player-info">
                <div class="player-card">
                    <span class="avatar-large"><?php echo $player['avatar']; ?></span>
                    <span class="pseudo-large"><?php echo $player['pseudo']; ?></span>
                </div>
            </div>
        </header>

        <main class="game-main">
            <?php if (($game['game_phase'] ?? 'lobby') === 'lobby'): ?>
                <section class="lobby">
                    <h2>Salle d'attente</h2>
                    <p>Partagez ce code avec vos amis: <strong><?php echo $game_code; ?></strong></p>
                    
                    <div class="players-list">
                        <h3>Joueurs (<?php echo count($game['players']); ?>/8):</h3>
                        <ul class="players-grid">
                            <?php foreach ($game['players'] as $p): ?>
                                <li class="player-item">
                                    <span class="avatar-small"><?php echo $p['avatar']; ?></span>
                                    <span><?php echo $p['pseudo']; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <?php if (count($game['players']) >= 2): ?>
                        <form method="POST" class="start-game-form">
                            <input type="hidden" name="action" value="start_game">
                            <button type="submit" class="btn btn-primary btn-large">
                                Démarrer le jeu (<?php echo count($game['players']); ?> joueurs)
                            </button>
                        </form>
                    <?php else: ?>
                        <p class="warning">Attendez au moins 2 joueurs pour commencer</p>
                    <?php endif; ?>

                    <form method="POST" class="leave-game-form">
                        <input type="hidden" name="action" value="leave_game">
                        <button type="submit" class="btn btn-secondary">
                            ← Quitter la partie
                        </button>
                    </form>
                </section>

            <?php elseif (($game['game_phase'] ?? 'lobby') === 'theme_selection'): ?>
                <section class="theme-selection">
                    <h2>🎯 Sélection du thème</h2>
                    <p>Le créateur doit choisir un thème. Un mot secret sera tiré aléatoirement dans la catégorie!</p>
                    
                    <?php if ($player['id'] === reset(array_keys($game['players']))): ?>
                        <form method="POST" class="theme-form">
                            <input type="hidden" name="action" value="select_theme">
                            
                            <div class="themes-grid">
                                <?php foreach (array_keys($GAME_THEMES) as $theme_name): ?>
                                    <label class="theme-option">
                                        <input 
                                            type="radio" 
                                            name="theme" 
                                            value="<?php echo $theme_name; ?>"
                                            required
                                        >
                                        <span class="theme-name"><?php echo $theme_name; ?></span>
                                        <span class="theme-count"><?php echo count($GAME_THEMES[$theme_name]); ?> mots</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-large">
                                Valider le thème
                            </button>
                        </form>
                    <?php else: ?>
                        <p class="info-message">⏳ Attendez que le créateur sélectionne un thème...</p>
                    <?php endif; ?>

                    <div class="impostor-info">
                        <?php 
                        $is_impostor = (($game['impostor_id'] ?? null) === $player['id']);
                        if ($is_impostor): 
                        ?>
                            <p class="warning">🕵️ Vous êtes l'IMPOSTEUR! Vous recevrez un mot différent. Essayez de deviner le vrai mot en écoutant les indices.</p>
                        <?php else: ?>
                            <p class="success">✓ Vous êtes un CITOYEN! Vous recevrez le vrai mot et devrez donner des indices.</p>
                        <?php endif; ?>
                    </div>

                    <form method="POST" class="leave-game-form">
                        <input type="hidden" name="action" value="leave_game">
                        <button type="submit" class="btn btn-secondary">
                            ← Retour
                        </button>
                    </form>
                </section>

            <?php elseif (($game['game_phase'] ?? 'lobby') === 'playing'): ?>
                <!-- Redirection vers le fichier de jeu -->
                <?php 
                    header('Location: game.php');
                    exit;
                ?>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
