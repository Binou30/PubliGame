<?php
header('Content-Type: text/html; charset=utf-8');
$chemin = 'users.txt';

$contenu = file($chemin);
echo "<pre>";
foreach ($contenu as $ligne) {
    echo htmlspecialchars($ligne);
}
echo "</pre>";
?>
