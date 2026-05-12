<?php
session_start();
require_once 'themes.php';

if (!isset($_SESSION['player'])) {
    header('Location: home.php');
    exit;
}

$player = $_SESSION['player'];
$game_id = $_SESSION['game_id'];

if (!isset($_SESSION['games'][$game_id])) {
    header('Location: create-game.php');
    exit;
}

$game = &$_SESSION['games'][$game_id];

// Traiter les actions du jeu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    
    if ($action === 'leave_game') {
        session_destroy();
        header('Location: home.php');
        exit;
    }
    
    if ($action === 'submit_guess' && $game['game_phase'] === 'playing') {
        $guess = htmlspecialchars($_POST['guess'] ?? '', ENT_QUOTES, 'UTF-8');
        $current_player_id = $game['turn_order'][$game['current_player_index']];
        
        // Enregistrer le mot deviné
        if (!isset($game['guesses'])) {
            $game['guesses'] = [];
        }
        $game['guesses'][$current_player_id][] = $guess;
        
        // Mettre à jour les tours joués
        $game['turns_played'][$current_player_id]++;
        
        // Passer au joueur suivant
        $game['current_player_index']++;
        $game['phase_start_time'] = time();
        
        // Vérifier si le tour est terminé
        $max_turns = 2;
        $all_done = true;
        foreach ($game['turns_played'] as $turns) {
            if ($turns < $max_turns) {
                $all_done = false;
                break;
            }
        }
        
        if ($all_done) {
            $game['game_phase'] = 'voting';
        }
    }
    
    if ($action === 'vote' && $game['game_phase'] === 'voting') {
        $voted_for = $_POST['voted_for'] ?? null;
        $voter_id = $_POST['voter_id'] ?? null;
        
        if ($voted_for && $voter_id) {
            if (!isset($game['votes'])) {
                $game['votes'] = [];
            }
            $game['votes'][] = [
                'voter' => $voter_id,
                'voted_for' => $voted_for
            ];
            
            // Vérifier si tous les votes sont en
            if (count($game['votes']) >= count($game['players'])) {
                // Compter les votes
                $vote_count = [];
                foreach ($game['votes'] as $vote) {
                    $voted_for = $vote['voted_for'];
                    $vote_count[$voted_for] = ($vote_count[$voted_for] ?? 0) + 1;
                }
                
                $eliminated_player = array_key_first($vote_count);
                $game['players'][$eliminated_player]['eliminated'] = true;
                $game['game_phase'] = 'round_end';
                $game['last_eliminated'] = $eliminated_player;
            }
        }
    }
    
    if ($action === 'next_round') {
        $game['current_round']++;
        $game['game_phase'] = 'playing';
        $game['current_player_index'] = 0;
        $game['votes'] = [];
        $game['phase_start_time'] = time();
        
        // Vérifier si le jeu est terminé
        $check_game_end = check_game_end($game);
        if ($check_game_end) {
            $game['game_phase'] = 'game_end';
            $game['winner'] = $check_game_end;
        }
    }
}

function check_game_end($game) {
    $impostor = $game['players'][$game['impostor_id']];
    $alive_players = array_filter($game['players'], fn($p) => !$p['eliminated']);
    
    if ($impostor['eliminated']) {
        return 'citizens'; // Les citoyens ont gagné
    }
    
    if (count($alive_players) <= 1) {
        return 'impostor'; // L'imposteur a gagné
    }
    
    return null;
}

// Récupérer les données du jeu
$current_player_id = null;
if (isset($game['turn_order'][$game['current_player_index'] ?? 0])) {
    $current_player_id = $game['turn_order'][$game['current_player_index']];
}
$is_current_player = ($current_player_id === $player['id']);
$is_impostor = (($game['impostor_id'] ?? null) === $player['id']);
$game_code = substr($game_id, 5);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu - Qui est l'Imposteur</title>
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
            <?php if ($game['game_phase'] === 'playing'): ?>
                <section class="game-playing">
                    <div class="game-status">
                        <div class="round-info">Manche <?php echo $game['current_round']; ?> / 2</div>
                        <div class="word-display">
                            <div class="theme-tag">Thème: <strong><?php echo $game['theme'] ?? ''; ?></strong></div>
                            <?php if ($is_impostor): ?>
                                <span class="word decoy"><?php echo $game['decoy_word'] ?? ''; ?></span>
                                <span class="word-hint">⚠️ Vous êtes l'imposteur! Devinez le vrai mot!</span>
                            <?php else: ?>
                                <span class="word secret"><?php echo $game['word'] ?? ''; ?></span>
                                <span class="word-hint">✓ Donnez des indices sur ce mot</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="current-player-section">
                        <h3>Tour actuel:</h3>
                        <div class="current-player-card">
                            <?php if ($current_player_id && isset($game['players'][$current_player_id])): ?>
                                <span class="avatar-large"><?php echo $game['players'][$current_player_id]['avatar']; ?></span>
                                <span class="pseudo-large"><?php echo $game['players'][$current_player_id]['pseudo']; ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ($is_current_player): ?>
                            <div class="timer" id="timer">
                                <span id="timer-value">30</span>s
                            </div>

                            <form method="POST" class="guess-form" id="guessForm">
                                <input type="hidden" name="action" value="submit_guess">
                                <input 
                                    type="text" 
                                    name="guess"
                                    class="input-field"
                                    placeholder="Dites 1 mot..."
                                    maxlength="1"
                                    required
                                >
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </form>
                        <?php else: ?>
                            <p>Écoutez le mot du joueur actuel...</p>
                            <div class="timer" id="timer">
                                <span id="timer-value">30</span>s
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="guesses-history">
                        <h3>Mots dits:</h3>
                        <ul class="guesses-list">
                            <?php 
                            if (isset($game['guesses'])):
                                foreach ($game['guesses'] as $player_id => $guesses):
                                    foreach ($guesses as $guess):
                            ?>
                                <li>
                                    <span class="avatar-small"><?php echo $game['players'][$player_id]['avatar']; ?></span>
                                    <strong><?php echo $game['players'][$player_id]['pseudo']; ?>:</strong>
                                    <span><?php echo $guess; ?></span>
                                </li>
                            <?php 
                                    endforeach;
                                endforeach;
                            endif; 
                            ?>
                        </ul>
                    </div>

                    <form method="POST" class="leave-game-form">
                        <input type="hidden" name="action" value="leave_game">
                        <button type="submit" class="btn btn-secondary">
                            ← Retour
                        </button>
                    </form>
                </section>

            <?php elseif ($game['game_phase'] === 'voting'): ?>
                <section class="game-voting">
                    <h2>⚖️ Vote</h2>
                    <p>Qui est l'imposteur? Votez!</p>

                    <div class="voting-section">
                        <h3>Candidats:</h3>
                        <form method="POST" class="voting-form">
                            <input type="hidden" name="action" value="vote">
                            <input type="hidden" name="voter_id" value="<?php echo $player['id']; ?>">
                            
                            <div class="candidates-grid">
                                <?php foreach ($game['players'] as $p): ?>
                                    <?php if (!$p['eliminated']): ?>
                                        <label class="vote-option">
                                            <input 
                                                type="radio" 
                                                name="voted_for" 
                                                value="<?php echo $p['id']; ?>"
                                                required
                                            >
                                            <div class="vote-card">
                                                <span class="avatar-large"><?php echo $p['avatar']; ?></span>
                                                <span><?php echo $p['pseudo']; ?></span>
                                            </div>
                                        </label>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <button type="submit" class="btn btn-primary btn-large">Voter</button>
                        </form>
                    </div>

                    <form method="POST" class="leave-game-form">
                        <input type="hidden" name="action" value="leave_game">
                        <button type="submit" class="btn btn-secondary">
                            ← Retour
                        </button>
                    </form>
                </section>

            <?php elseif ($game['game_phase'] === 'round_end'): ?>
                <section class="game-round-end">
                    <h2>Résultat du vote</h2>
                    
                    <div class="eliminated-player">
                        <p>Le joueur éliminé est:</p>
                        <div class="big-card">
                            <span class="avatar-huge"><?php echo $game['players'][$game['last_eliminated'] ?? null]['avatar'] ?? ''; ?></span>
                            <span class="pseudo-huge"><?php echo $game['players'][$game['last_eliminated'] ?? null]['pseudo'] ?? ''; ?></span>
                            <?php if (($game['last_eliminated'] ?? null) === $game['impostor_id']): ?>
                                <span class="impostor-tag">C'était l'IMPOSTEUR!</span>
                            <?php else: ?>
                                <span class="not-impostor-tag">N'était pas l'imposteur</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <form method="POST">
                        <input type="hidden" name="action" value="next_round">
                        <button type="submit" class="btn btn-primary btn-large">Manche suivante</button>
                    </form>

                    <form method="POST" class="leave-game-form">
                        <input type="hidden" name="action" value="leave_game">
                        <button type="submit" class="btn btn-secondary">
                            ← Retour
                        </button>
                    </form>
                </section>

            <?php elseif ($game['game_phase'] === 'game_end'): ?>
                <section class="game-end">
                    <h2>Fin du jeu!</h2>
                    
                    <div class="winner-announcement">
                        <?php if ($game['winner'] === 'impostor'): ?>
                            <h3 class="impostor-wins">L'IMPOSTEUR A GAGNÉ! 🕵️</h3>
                            <div class="big-card">
                                <span class="avatar-huge"><?php echo $game['players'][$game['impostor_id']]['avatar']; ?></span>
                                <span class="pseudo-huge"><?php echo $game['players'][$game['impostor_id']]['pseudo']; ?></span>
                            </div>
                        <?php else: ?>
                            <h3 class="citizens-win">LES CITOYENS ONT GAGNÉ! 🎉</h3>
                            <p>L'imposteur a été découvert!</p>
                            <div class="big-card">
                                <span class="avatar-huge"><?php echo $game['players'][$game['impostor_id']]['avatar']; ?></span>
                                <span class="pseudo-huge"><?php echo $game['players'][$game['impostor_id']]['pseudo']; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <a href="home.php" class="btn btn-primary btn-large">Retour à l'accueil</a>
                </section>
            <?php endif; ?>
        </main>
    </div>

    <script>
        let timeLeft = 30;
        
        function updateTimer() {
            const timerElement = document.getElementById('timer-value');
            if (timerElement) {
                timerElement.textContent = timeLeft;
                timeLeft--;
                
                if (timeLeft < 0) {
                    const form = document.getElementById('guessForm');
                    if (form && form.querySelector('input[name="guess"]').value) {
                        form.submit();
                    }
                }
            }
        }

        if (document.getElementById('timer')) {
            setInterval(updateTimer, 1000);
        }
    </script>
</body>
</html>
