<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
$uploads_dir = 'uploads';
$desc_dir = 'descriptions';
$votes_dir = 'votes';

function load_comments($filename) {
    $comments = array();
    if (file_exists($filename)) {
        $lines = file($filename);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line == '') continue;
            $parts = explode('|', $line, 3);
            if (count($parts) == 3) {
                $comments[] = array('date' => $parts[0], 'user' => $parts[1], 'texte' => $parts[2]);
            }
        }
    }
    return $comments;
}

$projets = array();

$dh = opendir($uploads_dir);
if ($dh) {
    while (($file = readdir($dh)) !== false) {
        if ($file != "." && $file != "..") {
            $nom_affiche = basename($file);
            $nom_fichier = $file;
            $fichier_path = $uploads_dir . '/' . $file;
            $date_modif = date("d/m/Y H:i", filemtime($fichier_path));

            $desc_path = $desc_dir . '/' . $file . '.txt';
            $description = '';
            $auteur = 'Anonyme';

            if (file_exists($desc_path)) {
                $contenu = file_get_contents($desc_path);

                if (preg_match('/Auteur\s*:\s*(.+)/i', $contenu, $matches)) {
                    $auteur = trim($matches[1]);
                }

                $lines = explode("\n", $contenu);
                if (count($lines) > 1) {
                    $description = trim(implode("\n", array_slice($lines, 1)));
                }
            }

            $vote_file = $votes_dir . '/' . $nom_fichier . '.txt';
            $likes = 0;
            $dislikes = 0;
            if (file_exists($vote_file)) {
                $lines = file($vote_file);
                foreach ($lines as $line) {
                    if (strpos($line, 'likes=') === 0) {
                        $likes = intval(substr($line, 6));
                    }
                    if (strpos($line, 'dislikes=') === 0) {
                        $dislikes = intval(substr($line, 9));
                    }
                }
            }

            $projets[] = array(
                'nom_affiche' => $nom_affiche,
                'nom_fichier' => $nom_fichier,
                'date_modif' => $date_modif,
                'description' => $description,
                'auteur' => $auteur,
                'likes' => $likes,
                'dislikes' => $dislikes
            );
        }
    }
    closedir($dh);

    foreach ($projets as $key => $projet) {
        $projets[$key]['commentaires'] = load_comments('comments/' . $projet['nom_fichier'] . '.txt');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets publiés</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php if (isset($_GET['flash']) && $_GET['flash'] == 1): ?>
    <script>
        alert("Projet supprimé avec succès!");
    </script>
    <?php endif; ?>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <div class="cadre">
        <div class="body">
            <h1><u>Projets publiés</u></h1>
            <h2>Vous voici dans les projets publiés par les autres utilisateurs !</h2>
            <?php if (count($projets) > 0): ?>
                <ul>
                <?php foreach ($projets as $p): ?>
                    <li>
                        <span class="nom-fichier"><?php echo htmlspecialchars($p['nom_affiche']); ?></span>
                        <div class="project-meta">
                            <span class="date">(<?php echo $p['date_modif']; ?>)</span>
                            <a href="download.php?f=<?php echo urlencode($p['nom_fichier']); ?>" class="download-link">Télécharger</a>
                            <?php if (isset($_SESSION['username']) && strcasecmp($_SESSION['username'], $p['auteur']) === 0): ?>
                            <form method="POST" action="deleteproject.php" class="delete-project-form" onsubmit="return confirm('Voulez-vous vraiment supprimer ce projet ?');">
                                    <input type="hidden" name="fichier" value="<?php echo htmlspecialchars($p['nom_fichier']); ?>">
                                    <button type="submit" class="delete-project-btn" aria-label="Supprimer ce projet">✖</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <form method="POST" action="vote.php" class="inline-form">
                            <input type="hidden" name="fichier" value="<?php echo htmlspecialchars($p['nom_fichier']); ?>">
                            <input type="hidden" name="vote" value="like">
                            <button type="submit" class="vote-button">👍</button>
                            <b><?php echo $p['likes']; ?></b>
                        </form>

                        <form method="POST" action="vote.php" class="inline-form">
                            <input type="hidden" name="fichier" value="<?php echo htmlspecialchars($p['nom_fichier']); ?>">
                            <input type="hidden" name="vote" value="dislike">
                            <button type="submit" class="vote-button">👎</button>
                            <b><?php echo $p['dislikes']; ?></b>
                        </form>
                        <br><br>
                        <?php if (!empty($p['description'])): ?>
                            <?php
                                $desc = nl2br(htmlspecialchars($p['description']));
                                $desc = preg_replace('/^(Auteur|Nom du projet|Description)\s*:/mi', '<strong>$1 :</strong>', $desc);
                                echo $desc;
                            ?><br>
                        <?php else: ?>
                            <strong><em>Pas de description</em></strong><br>
                        <?php endif; ?>
                        <span class="author-meta"><strong>Auteur :</strong> <?php echo htmlspecialchars($p['auteur']); ?></span>
                        <?php
                            if (!empty($p['commentaires'])) {
                                echo "<h3>Commentaires :</h3><ul>";
                                foreach ($p['commentaires'] as $index => $c) {
                                    echo "<li><em><b>" . htmlspecialchars($c['date']) . "</b></em> - <strong><u>" . htmlspecialchars($c['user']) . "</u></strong> : " . htmlspecialchars($c['texte']);
                                    if (isset($_SESSION['username']) && strcasecmp($_SESSION['username'], $c['user']) === 0) {
                                        echo '<form method="POST" action="comments.php" class="inline-form" onsubmit="return confirm(\'Voulez-vous vraiment supprimer ce commentaire ?\');">
                                                <input type="hidden" name="nom_fichier" value="' . htmlspecialchars($p['nom_fichier']) . '">
                                                <input type="hidden" name="action" value="supprimer">
                                                <input type="hidden" name="commentaire_id" value="' . $index . '">
                                                <button type="submit" class="comment-delete-btn">✖</button>
                                            </form>';
                                    }
                                    echo "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<p><em><strong>Aucun commentaire pour ce projet</strong></em></p>";
                            }

                            if (isset($_SESSION['username'])) {
                                echo '<form method="POST" action="comments.php">
                                        <input type="hidden" name="nom_fichier" value="' . htmlspecialchars($p['nom_fichier']) . '">
                                        <input type="hidden" name="action" value="ajouter">
                                        <label for="commentaire-' . htmlspecialchars($p['nom_fichier']) . '"><b>Ajouter un commentaire :</b></label><br>
                                        <textarea id="commentaire-' . htmlspecialchars($p['nom_fichier']) . '" name="commentaire" rows="2" cols="50" required></textarea><br>
                                        <button type="submit">Envoyer</button>
                                    </form>';
                            } else {
                                echo '<p><em>Connectez-vous pour ajouter un commentaire.</em></p>';
                            }
                            ?>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><b>Aucun projet publié pour le moment.</b></p>
            <?php endif; ?>
            <button onclick="window.location.href='index.php'">Retour à l'accueil</button>
            <?php include_once dirname(__FILE__) . '/footer.php'; ?>
        </div>
    </div>
</body>
</html>
