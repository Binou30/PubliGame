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
                if ($parts[0] == $username) {
                    $found = true;
                    break;
                }
            }
        }

        if ($found) {
            $message = 'Nom d’utilisateur déjà pris.';
        } else {
            // On enregistre le mot de passe en clair (à ne pas faire en production)
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
    <title>Créer un compte</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <style type="text/css">
        body {
            background-image: url("static/fd.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #8f3333;
            margin: 0;
            height: 100vh;
        }
        .cadre {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            border: 5px solid #727272;
            box-sizing: border-box;
        }
        .body {
            margin-left: 5px;
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
    </style>
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
                    <p style="color: #8f3333;"><b><?php echo $message; ?></b></p>
                <?php endif; ?>
                <button type="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
                <button type="submit">Créer le compte</button>
            </form>
            <h6 class="copyright">©2025-Alban DOINEL</h6>
        </div>
    </div>
</body>
</html>
