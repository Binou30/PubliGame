<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$echanges_dir = 'echanges';
$echanges_file = $echanges_dir . '/echanges.txt';

if (!file_exists($echanges_dir)) {
    mkdir($echanges_dir, 0777);
}

function lire_messages($fichier) {
    $messages = array();
    if (file_exists($fichier)) {
        $lignes = file($fichier);
        foreach ($lignes as $ligne) {
            $ligne = trim($ligne);
            if ($ligne != '') {
                $parts = explode('|||', $ligne);
                if (count($parts) == 3) {
                    $messages[] = array(
                        'auteur' => $parts[0],
                        'date' => $parts[1],
                        'texte' => $parts[2]
                    );
                }
            }
        }
    }
    return $messages;
}

function ecrire_messages($fichier, $messages) {
    $fp = fopen($fichier, 'w');
    if ($fp) {
        foreach ($messages as $msg) {
            $texte_sans_conflict = str_replace('|||', ' ', $msg['texte']);
            fwrite($fp, $msg['auteur'] . '|||' . $msg['date'] . '|||' . $texte_sans_conflict . "\n");
        }
        fclose($fp);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $texte = trim($_POST['message']);
    if ($texte != '') {
        $messages = lire_messages($echanges_file);
        $nouveau = array(
            'auteur' => $_SESSION['username'],
            'date' => date('d/m/Y H:i'),
            'texte' => $texte
        );
        $messages[] = $nouveau;
        ecrire_messages($echanges_file, $messages);
        header('Location: echanges.php');
        exit;
    }
}

$messages = array_reverse(lire_messages($echanges_file));
?>

<?php if (isset($_GET['deleted'])): ?>
	<script>
	alert("Message supprimé avec succès !");
	</script>
	<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Échanges</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
<div class="cadre">
    <div class="body">
        <h1><u>Échanges</u></h1>
        <h3>Ici, vous pourrez discuter avec les autres membres de PubliGame!</h3>
        <form action="echanges.php" method="post" class="exchange-form">
            <textarea name="message" placeholder="Écrivez votre message ici..." required rows="4" class="textarea"></textarea><br>
            <button type="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
            <button type="submit">Publier</button>
        </form>
        <hr class="separator">
        <div>
            <?php if (count($messages) > 0): ?>
                <?php foreach ($messages as $index => $msg): ?>
                    <div class="message">
                        <strong><u><?php echo htmlspecialchars($msg['auteur']); ?></u></strong>
                        <em><b>le <?php echo htmlspecialchars($msg['date']); ?></b></em>
                        <?php if ($_SESSION['username'] == $msg['auteur']): ?>
                            <form class="inline" method="post" action="supprimer_message.php" onsubmit="return confirm('Voulez-vous vraiment supprimer ce message ?');">
                                <input type="hidden" name="index" value="<?php echo count($messages) - $index - 1; ?>">
                                <button type="submit" class="delete-btn">✖</button>
                            </form>
                        <?php endif; ?>
                        <br>
                        <i><?php echo nl2br(htmlspecialchars($msg['texte'])); ?></i>
                    </div><br>
                <?php endforeach; ?>
            <?php else: ?>
                <p><b>Aucun message publié pour le moment.</b></p>
            <?php endif; ?>
        </div>
        <?php include_once dirname(__FILE__) . '/footer.php'; ?>
    </div>
</div>
</body>
</html>
