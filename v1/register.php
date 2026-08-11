<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$username = '';
$password = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username'])) {
        $username = trim($_POST['username']);
    }
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
    }

    if ($username == '' || $password == '') {
        $message = 'Veuillez remplir tous les champs.';
    } else {
        $filepath = 'users.txt';
        $found = false;

        if (file_exists($filepath)) {
            $lines = file($filepath);
            foreach ($lines as $line) {
                $parts = explode(':', trim($line));
                if (strtolower($parts[0]) == strtolower($username)) {
                    $found = true;
                    break;
                }
            }
        }

        if ($found) {
            $message = 'Nom d’utilisateur déjà pris.';
        } else {
            $entry = $username . ':' . $password . "\n";
            $fp = fopen($filepath, 'a');
            fwrite($fp, $entry);
            fclose($fp);

            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <div class="cadre">
        <div class="body">
            <h1><u>Créer un compte</u></h1>
            <form method="POST" action="register.php">
                <label><b>Nom d'utilisateur :</b></label><br />
                <input type="text" name="username" required /><br /><br />
                <label><b>Mot de passe :</b></label><br />
                <input type="password" name="password" required /><br /><br />
                <?php if ($message != ''): ?>
                    <p class="form-message"><b><?php echo htmlspecialchars($message); ?></b></p>
                <?php endif; ?>
                <button type="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
                <button type="submit">Créer le compte</button>
            </form>
            <?php include_once dirname(__FILE__) . '/footer.php'; ?>
        </div>
    </div>
</body>
</html>
