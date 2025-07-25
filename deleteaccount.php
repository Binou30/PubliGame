<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];
$user_file = 'users.txt';
$found = false;

if (file_exists($user_file)) {
    $lines = file($user_file);
    $new_lines = array();

    foreach ($lines as $line) {
        $line = trim($line);
        $parts = explode(':', $line);
        if (count($parts) >= 2) {
            if ($parts[0] != $username) {
                $new_lines[] = $line;
            } else {
                $found = true;
            }
        }
    }

    $fp = fopen($user_file, 'w');
    if ($fp) {
        foreach ($new_lines as $newline) {
            fwrite($fp, $newline . "\n");
        }
        fclose($fp);
    }
}

session_destroy();

if ($found) {
    header('Location: index.php?msg=compte_supprime');
} else {
    header('Location: index.php?msg=compte_introuvable');
}
exit;
?>
