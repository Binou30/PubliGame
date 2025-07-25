<?php
session_start();

if (!isset($_SESSION['username'])) {
    die("Accès refusé. Vous devez être connecté.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fichier'])) {
    $nom_fichier = basename($_POST['fichier']);
    $nom_sans_extension = pathinfo($nom_fichier, PATHINFO_FILENAME);

    $chemin_upload = dirname(__FILE__) . '/uploads/' . $nom_fichier;
    $chemin_description = dirname(__FILE__) . '/descriptions/' . $nom_fichier . '.txt';
    $chemin_commentaires = dirname(__FILE__) . '/comments/' . $nom_sans_extension . '.txt';
    $chemin_votes = dirname(__FILE__) . '/votes/' . $nom_sans_extension . '.txt';

    if (!file_exists($chemin_description)) {
        die("Fichier description introuvable. Chemin testé : " . htmlspecialchars($chemin_description));
    }

    $contenu = file_get_contents($chemin_description);
    preg_match('/Auteur\s*:\s*(.+)/i', $contenu, $matches);
    $auteur_du_fichier = isset($matches[1]) ? trim($matches[1]) : '';

    if ($auteur_du_fichier !== $_SESSION['username']) {
        die("Vous n'avez pas le droit de supprimer ce fichier.");
    }

    $ok1 = file_exists($chemin_upload) ? unlink($chemin_upload) : true;
    $ok2 = file_exists($chemin_description) ? unlink($chemin_description) : true;
    $ok3 = file_exists($chemin_commentaires) ? unlink($chemin_commentaires) : true;
    $ok4 = file_exists($chemin_votes) ? unlink($chemin_votes) : true;

    if ($ok1 && $ok2 && $ok3 && $ok4) {
        header('Location: publies.php?message=Fichier supprimé avec succès');
        exit();
    } else {
        die("Erreur lors de la suppression.");
    }
} else {
    die("Requête invalide.");
}
