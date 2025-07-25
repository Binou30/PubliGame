<?php
session_start();

$vote_dir = 'votes';

if (!isset($_POST['fichier']) || !isset($_POST['vote']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$fichier = basename($_POST['fichier']);
$type_vote = ($_POST['vote'] === 'like') ? 'like' : 'dislike';
$username_original = $_SESSION['username'];          // Garder l'original
$username = trim(strtolower($username_original));     // Utilisé uniquement pour le fichier de votes
$vote_file = $vote_dir . '/' . $fichier . '.txt';

// Initialiser
$likes = 0;
$dislikes = 0;
$user_votes = array();

// Lire fichier si existe
if (file_exists($vote_file)) {
    $lines = file($vote_file);
    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, 'likes=') === 0) {
            $likes = intval(substr($line, 6));
        } elseif (strpos($line, 'dislikes=') === 0) {
            $dislikes = intval(substr($line, 9));
        } elseif (strpos($line, '=') !== false) {
            list($user, $vote) = explode('=', $line, 2);
            $user_votes[strtolower(trim($user))] = trim($vote);
        }
    }
}

// Traitement du vote
$ancien_vote = isset($user_votes[$username]) ? $user_votes[$username] : null;

if ($ancien_vote === $type_vote) {
    if ($type_vote === 'like') $likes--;
    else $dislikes--;
    unset($user_votes[$username]);
} else {
    if ($ancien_vote === 'like') $likes--;
    if ($ancien_vote === 'dislike') $dislikes--;

    if ($type_vote === 'like') $likes++;
    if ($type_vote === 'dislike') $dislikes++;

    $user_votes[$username] = $type_vote;
}

// Sauvegarde
$fp = fopen($vote_file, 'w');
if ($fp) {
    fwrite($fp, "likes=$likes\n");
    fwrite($fp, "dislikes=$dislikes\n");
    foreach ($user_votes as $user => $vote) {
        fwrite($fp, "$user=$vote\n");
    }
    fclose($fp);
} else {
    die("Erreur d’écriture.");
}

// Redirection
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;

?>
