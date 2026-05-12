<?php
/**
 * Configuration de l'application "Qui est l'Imposteur?"
 */

// Paramètres du jeu
define('GAME_MAX_PLAYERS', 8);
define('GAME_MIN_PLAYERS', 2);
define('GAME_TIMER_SECONDS', 30);
define('GAME_ROUNDS_PER_PLAYER', 2);
define('GAME_WORDS_MAX_LENGTH', 50);

// Paramètres de profil
define('PROFILE_PSEUDO_MIN', 3);
define('PROFILE_PSEUDO_MAX', 15);

// Avatars disponibles (emoji + nom)
$AVATARS = [
    '😺' => 'Chat noir',
    '🐸' => 'Grenouille',
    '🦊' => 'Renard',
    '🐰' => 'Lapin',
    '🦁' => 'Lion',
    '🐺' => 'Loup',
    '🦆' => 'Canard',
    '🐉' => 'Dragon',
    '👹' => 'Démon',
    '🧟' => 'Zombie',
    '🤖' => 'Robot',
    '👽' => 'Alien',
    '⛩️' => 'Temple',
    '🎌' => 'Drapeau',
    '🎎' => 'Poupées',
    '🗾' => 'Japon'
];

// Thèmes et mots pour le jeu
$GAME_THEMES = [
    'Animaux' => [
        'Chat', 'Chien', 'Lion', 'Tigre', 'Renard', 'Loup', 'Ours', 'Éléphant',
        'Girafe', 'Zèbre', 'Lapin', 'Souris', 'Cerf', 'Canard', 'Aigle', 'Serpent'
    ],
    'Fruits' => [
        'Pomme', 'Banane', 'Orange', 'Fraise', 'Raisin', 'Mangue', 'Ananas', 'Pêche',
        'Poire', 'Cerise', 'Citron', 'Pastèque', 'Kiwi', 'Abricot', 'Noix de coco', 'Figue'
    ],
    'Légumes' => [
        'Carotte', 'Tomate', 'Concombre', 'Poivron', 'Oignon', 'Ail', 'Champignon', 'Patate',
        'Brocoli', 'Chou', 'Épinard', 'Salade', 'Poireau', 'Courgette', 'Betterave', 'Aubergine'
    ],
    'Objets' => [
        'Chaise', 'Table', 'Porte', 'Fenêtre', 'Lit', 'Armoire', 'Miroir', 'Lampe',
        'Livre', 'Stylo', 'Crayon', 'Montre', 'Téléphone', 'Ordinateur', 'Clé', 'Bouteille'
    ],
    'Sports' => [
        'Football', 'Basketball', 'Tennis', 'Natation', 'Cyclisme', 'Boxe', 'Golf', 'Skateboard',
        'Équitation', 'Handball', 'Volleyball', 'Badminton', 'Ping-pong', 'Ski', 'Surf', 'Patinage'
    ],
    'Métiers' => [
        'Docteur', 'Infirmier', 'Pompier', 'Policier', 'Professeur', 'Cuisinier', 'Astronaute', 'Pilot',
        'Musicien', 'Acteur', 'Peintre', 'Architecte', 'Mécanicien', 'Fermier', 'Plombier', 'Électricien'
    ],
    'Pays' => [
        'France', 'Japon', 'Italie', 'Espagne', 'Allemagne', 'Brésil', 'Mexique', 'Australie',
        'Canada', 'Suisse', 'Suède', 'Norvège', 'Égypte', 'Thaïlande', 'Inde', 'Afrique du Sud'
    ],
    'Émojis' => [
        'Panda', 'Pingouin', 'Dauphin', 'Baleine', 'Flamant', 'Koala', 'Paresseux', 'Biche',
        'Chèvre', 'Vache', 'Cochon', 'Oie', 'Poule', 'Papillon', 'Abeille', 'Scarabée'
    ],
    'Aliments' => [
        'Pizza', 'Burger', 'Tacos', 'Sushi', 'Pâtes', 'Riz', 'Pain', 'Fromage',
        'Chocolat', 'Glace', 'Gâteau', 'Cookie', 'Sandwich', 'Poulet', 'Steak', 'Poisson'
    ],
    'Couleurs' => [
        'Rouge', 'Bleu', 'Vert', 'Jaune', 'Orange', 'Violet', 'Rose', 'Noir',
        'Blanc', 'Gris', 'Marron', 'Turquoise', 'Indigo', 'Or', 'Argent', 'Bronze'
    ],
    'Vêtements' => [
        'Chemise', 'Pantalon', 'Robe', 'Veste', 'Chaussettes', 'Chaussures', 'Chapeau', 'Ceinture',
        'Cravate', 'Manteau', 'T-shirt', 'Short', 'Costume', 'Uniforme', 'Cape', 'Foulard'
    ],
    'Instruments' => [
        'Guitare', 'Piano', 'Violon', 'Trompette', 'Flûte', 'Tambour', 'Harmonica', 'Saxophone',
        'Clarinette', 'Cornet', 'Mandoline', 'Ukulélé', 'Harpe', 'Lyre', 'Trombone', 'Tuba'
    ]
];

// Mots décoy (utilisés pour l'imposteur)
$DECOY_WORDS = [
    'Fantôme', 'Vampire', 'Sorcière', 'Robot', 'Extraterrestre', 'Dinosaure', 'Monstre', 'Créature',
    'Mystère', 'Secret', 'Énigme', 'Piège', 'Ombre', 'Néant', 'Vide', 'Chaos'
];

// Configuration des sessions
define('SESSION_TIMEOUT', 3600); // 1 heure
define('SESSION_NAME', 'impost_session');

// Messages du jeu
$GAME_MESSAGES = [
    'welcome' => 'Bienvenue dans Qui est l\'Imposteur?',
    'impostor_role' => 'Vous êtes l\'IMPOSTEUR!',
    'citizen_role' => 'Vous êtes un CITOYEN',
    'guess_prompt' => 'À vous de jouer! Dites un mot...',
    'voting_time' => 'C\'est l\'heure du vote!',
    'game_end_citizens' => 'Les citoyens ont gagné! L\'imposteur a été découvert!',
    'game_end_impostor' => 'L\'imposteur a gagné!'
];

// Configuration du serveur
define('APP_NAME', 'Qui est l\'Imposteur?');
define('APP_VERSION', '1.0');
define('APP_AUTHOR', '');
define('DEBUG_MODE', false); // Mettez à true pour les logs de débogage

// Fonctions utilitaires
function generate_game_code() {
    return strtoupper(substr(uniqid(), -6));
}

function validate_pseudo($pseudo) {
    $length = strlen($pseudo);
    return $length >= PROFILE_PSEUDO_MIN && $length <= PROFILE_PSEUDO_MAX && 
           ctype_alnum(str_replace('_', '', $pseudo));
}

function validate_word($word) {
    $length = strlen(trim($word));
    return $length > 0 && $length <= GAME_WORDS_MAX_LENGTH;
}

function validate_avatar($avatar) {
    global $AVATARS;
    return isset($AVATARS[$avatar]);
}

function log_debug($message) {
    if (DEBUG_MODE) {
        error_log('[' . date('Y-m-d H:i:s') . '] ' . $message);
    }
}

// Configuration timezone
date_default_timezone_set('UTC');

// Démarrage des sessions automatiques
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Initialiser les données de session si nécessaire
if (!isset($_SESSION['games'])) {
    $_SESSION['games'] = [];
}
