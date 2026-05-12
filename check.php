<?php
/**
 * Fichier de vérification de l'application
 * Ouvrez ceci pour vérifier que tout fonctionne
 */

// Vérifications du système
$php_version = phpversion();
$is_php_ok = version_compare($php_version, '7.4', '>=');
$sessions_ok = ini_get('session.save_handler');
$max_upload = ini_get('upload_max_filesize');
$memory_limit = ini_get('memory_limit');

// Vérification des fichiers
$required_files = [
    'index.php',
    'profile.php',
    'game.php',
    'config.php',
    'styles.css',
    'README.md'
];

$all_files_ok = true;
$missing_files = [];

foreach ($required_files as $file) {
    if (!file_exists($file)) {
        $all_files_ok = false;
        $missing_files[] = $file;
    }
}

// Vérification des extensions
$gd_ok = extension_loaded('gd');
$mysqli_ok = extension_loaded('mysqli');
$pdo_ok = extension_loaded('pdo');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Système - Qui est l'Imposteur?</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        h1 {
            color: #667eea;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            color: #999;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .status-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        
        .status-section h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        
        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .status-item:last-child {
            border-bottom: none;
        }
        
        .status-label {
            font-weight: 600;
            color: #333;
        }
        
        .status-value {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }
        
        .badge-ok {
            background: #e7f5e7;
            color: #51cf66;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #ffb300;
        }
        
        .badge-error {
            background: #ffe0e0;
            color: #ff6b6b;
        }
        
        .status-icon {
            font-size: 1.5em;
        }
        
        .summary {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            font-size: 1.1em;
        }
        
        .summary.ok {
            background: #e7f5e7;
            color: #51cf66;
        }
        
        .summary.error {
            background: #ffe0e0;
            color: #ff6b6b;
        }
        
        .next-steps {
            margin-top: 30px;
            padding: 20px;
            background: #e3f2fd;
            border-radius: 10px;
            border-left: 4px solid #2196F3;
        }
        
        .next-steps h3 {
            color: #2196F3;
            margin-bottom: 15px;
        }
        
        .next-steps ol {
            margin-left: 20px;
            line-height: 1.8;
        }
        
        .next-steps li {
            margin-bottom: 10px;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            border: none;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Vérification Système</h1>
        <p class="subtitle">Qui est l'Imposteur? - État de l'application</p>

        <!-- PHP & Système -->
        <div class="status-section">
            <h2>✓ Système & PHP</h2>
            
            <div class="status-item">
                <span class="status-label">Version PHP</span>
                <span class="status-value">
                    <span><?php echo $php_version; ?></span>
                    <span class="status-badge <?php echo $is_php_ok ? 'badge-ok' : 'badge-error'; ?>">
                        <?php echo $is_php_ok ? '✓ OK' : '✗ TROP ANCIEN'; ?>
                    </span>
                </span>
            </div>
            
            <div class="status-item">
                <span class="status-label">Sessions</span>
                <span class="status-value">
                    <span><?php echo $sessions_ok ?: 'Défaut'; ?></span>
                    <span class="status-badge badge-ok">✓ OK</span>
                </span>
            </div>
            
            <div class="status-item">
                <span class="status-label">Memory Limit</span>
                <span class="status-value">
                    <span><?php echo $memory_limit; ?></span>
                    <span class="status-badge badge-ok">✓ OK</span>
                </span>
            </div>
        </div>

        <!-- Fichiers -->
        <div class="status-section">
            <h2>📁 Fichiers Requis</h2>
            
            <?php if ($all_files_ok): ?>
                <div class="status-item">
                    <span class="status-label">Tous les fichiers</span>
                    <span class="status-value">
                        <span class="status-badge badge-ok">✓ PRÉSENTS</span>
                    </span>
                </div>
            <?php else: ?>
                <div class="status-item">
                    <span class="status-label">Fichiers manquants</span>
                    <span class="status-value">
                        <span class="status-badge badge-error">✗ ERREUR</span>
                    </span>
                </div>
                <?php foreach ($missing_files as $file): ?>
                    <div class="status-item" style="margin-top: 10px; padding-left: 20px;">
                        <span style="color: #ff6b6b;">❌ <?php echo $file; ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Extensions PHP (optionnel) -->
        <div class="status-section">
            <h2>📦 Extensions PHP</h2>
            
            <div class="status-item">
                <span class="status-label">GD (Graphiques)</span>
                <span class="status-value">
                    <span class="status-badge <?php echo $gd_ok ? 'badge-ok' : 'badge-warning'; ?>">
                        <?php echo $gd_ok ? '✓ Présente' : '⚠ Absente'; ?>
                    </span>
                </span>
            </div>
            
            <div class="status-item">
                <span class="status-label">MySQLi (BD)</span>
                <span class="status-value">
                    <span class="status-badge <?php echo $mysqli_ok ? 'badge-ok' : 'badge-warning'; ?>">
                        <?php echo $mysqli_ok ? '✓ Présente' : '⚠ Absente'; ?>
                    </span>
                </span>
            </div>
            
            <div class="status-item">
                <span class="status-label">PDO (BD)</span>
                <span class="status-value">
                    <span class="status-badge <?php echo $pdo_ok ? 'badge-ok' : 'badge-warning'; ?>">
                        <?php echo $pdo_ok ? '✓ Présente' : '⚠ Absente'; ?>
                    </span>
                </span>
            </div>
        </div>

        <!-- Résumé -->
        <?php if ($is_php_ok && $all_files_ok): ?>
            <div class="summary ok">
                <span class="status-icon">✅</span>
                <p><strong>Tout est prêt!</strong> Votre système est configuré correctement.</p>
            </div>
            
            <div class="next-steps">
                <h3>🚀 Prochaines étapes</h3>
                <ol>
                    <li>Consultez <strong>QUICKSTART.html</strong> pour le guide rapide</li>
                    <li>Double-cliquez sur <strong>start.bat</strong> (Windows) ou exécutez <strong>./start.sh</strong> (Mac/Linux)</li>
                    <li>Ouvrez <strong>http://localhost:8000</strong> dans votre navigateur</li>
                    <li>Créez une partie et commencez à jouer! 🎮</li>
                </ol>
            </div>
            
            <center>
                <a href="index.php" class="btn" style="font-size: 1.1em; padding: 15px 40px;">
                    Aller au jeu →
                </a>
            </center>
        <?php else: ?>
            <div class="summary error">
                <span class="status-icon">❌</span>
                <p><strong>Problème détecté.</strong> Veuillez corriger les erreurs ci-dessus avant de continuer.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
