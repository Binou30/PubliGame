<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

if (get_magic_quotes_gpc()) {
    function nettoyer_array(&$array) {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                nettoyer_array($array[$key]);
            } else {
                $array[$key] = stripslashes($val);
            }
        }
    }
    nettoyer_array($_POST);
}

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$echanges_dir = 'echanges';
$echanges_file = $echanges_dir . '/echanges.txt';

// Création dossier si inexistant
if (!file_exists($echanges_dir)) {
    mkdir($echanges_dir, 0777);
}

// Lire les messages
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

// Écrire les messages
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

// Traitement POST pour ajouter un message
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

// Lire messages pour affichage
$messages = array_reverse(lire_messages($echanges_file));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Échanges</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <style>
        textarea {
            width: 40%; 
            height: 70px;
            resize: vertical;
            padding: 8px;
            font-size: 0.85rem;
        }
        body {
            margin: 0;
            height: 100vh;
            background-image: url("static/fd.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #8f3333;
        }
        .copyright {
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            width: 100%;
            font-size: 14px;
            color: #8f3333;
        }
        .cadre {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: transparent;
            border: 5px solid #727272;
            box-sizing: border-box;
        }
        .body {
            margin-left: 5px;
        }
        .message {
            background: rgba(255,255,255,0.7);
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        form.inline { display: inline; }
        button.delete-btn {
            color: #8f3333;
            background: none;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="cadre">
    <div class="body">
        <h1><u>Échanges</u></h1>
        <h3>Ici, vous pourrez discuter avec les autres membres de PubliGame!</h3>
        <form action="echanges.php" method="post">
            <textarea name="message" placeholder="Écrivez votre message ici..." required rows="4" class="textarea"></textarea><br>
            <button type="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
            <button type="submit">Publier</button>
        </form>
        <hr style="border: none; height: 2px; background-color: black; margin: 20px 0;">
        <div>
            <?php if (count($messages) > 0): ?>
                <?php foreach ($messages as $index => $msg): ?>
                    <div class="message">
                        <strong><u><?php echo htmlspecialchars($msg['auteur']); ?></u></strong> 
                        <em><b>le <?php echo htmlspecialchars($msg['date']); ?></b></em>
                        <?php if ($_SESSION['username'] == $msg['auteur']): ?>
                            <form class="inline" method="post" action="supprimer_message.php" onsubmit="return confirm('Supprimer ce message ?');">
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
        <h6 class="copyright">©2025-Alban DOINEL</h6>
    </div>
</div>
</body>
</html>
