<?php
session_start();

$echanges_file = 'echanges/echanges.txt';

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
    exit;
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

// Réécrire tous les messages sauf celui à supprimer
function ecrire_messages($fichier, $messages) {
    $fp = fopen($fichier, 'w');
    if ($fp) {
        foreach ($messages as $msg) {
            $ligne = str_replace('|||', ' ', $msg['texte']);
            fwrite($fp, $msg['auteur'] . '|||' . $msg['date'] . '|||' . $ligne . "\n");
        }
        fclose($fp);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['index'])) {
    $index = intval($_POST['index']);
    $messages = lire_messages($echanges_file);

    if (isset($messages[$index]) && $messages[$index]['auteur'] == $_SESSION['username']) {
        unset($messages[$index]);
        $messages = array_values($messages); // Réindexer
        ecrire_messages($echanges_file, $messages);
    }
}

header('Location: echanges.php');
exit;
