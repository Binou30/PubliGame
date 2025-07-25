<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_POST['nom_fichier'])) {
    die('Projet non spécifié.');
}

$nom_fichier = basename($_POST['nom_fichier']);
$comments_dir = 'comments';
$comment_file = $comments_dir . '/' . $nom_fichier . '.txt';

// Création dossier comments si inexistant
if (!is_dir($comments_dir)) {
    mkdir($comments_dir, 0755);
}

// Fonction simple pour charger les commentaires
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

$comments = load_comments($comment_file);

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'ajouter') {
    $texte = trim($_POST['commentaire']);
    if ($texte == '') {
        die('Le commentaire ne peut pas être vide.');
    }
    $date = date('Y-m-d H:i');
    $user = $_SESSION['username'];

    // On enlève les pipes et sauts de ligne pour éviter la casse
    $texte = str_replace(array("\r", "\n", "|"), ' ', $texte);

    $ligne = $date . '|' . $user . '|' . $texte . "\n";

    // Ajouter le commentaire à la fin du fichier
    $fp = fopen($comment_file, 'a');
    if ($fp) {
        fwrite($fp, $ligne);
        fclose($fp);
    } else {
        die('Impossible d\'écrire dans le fichier des commentaires.');
    }

    // Retour à la page précédente
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

if ($action == 'supprimer' && isset($_POST['commentaire_id'])) {
    $id = intval($_POST['commentaire_id']);
    if (!isset($comments[$id])) {
        die('Commentaire introuvable.');
    }
    if ($comments[$id]['user'] !== $_SESSION['username']) {
        die('Suppression non autorisée.');
    }
    // Supprimer le commentaire demandé
    unset($comments[$id]);

    // Réécrire le fichier sans ce commentaire
    $fp = fopen($comment_file, 'w');
    if ($fp) {
        foreach ($comments as $c) {
            $line = $c['date'] . '|' . $c['user'] . '|' . $c['texte'] . "\n";
            fwrite($fp, $line);
        }
        fclose($fp);
    } else {
        die('Impossible d\'écrire dans le fichier des commentaires.');
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

die('Action inconnue.');
?>
