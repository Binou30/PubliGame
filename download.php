<?php
$dossier = 'uploads/';

if (!isset($_GET['f'])) {
    die('Fichier non spécifié.');
}

$nom = basename($_GET['f']);
$chemin = $dossier . $nom;

if (!file_exists($chemin)) {
    die('Fichier introuvable.');
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $nom . '"');
header('Content-Length: ' . filesize($chemin));
readfile($chemin);
exit;
?>