<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

$messages = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    $valid = false;

    if (file_exists('users.txt')) {
        $lines = file('users.txt');
        foreach ($lines as $line) {
            $parts = explode(':', trim($line));
            if (count($parts) == 2) {
                $stored_user = $parts[0];
                $stored_pass = $parts[1];
                if ($username == $stored_user && $password == $stored_pass) {
                    $valid = true;
                    break;
                }
            }
        }
    }

    if ($valid) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $messages[] = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
</head>
<body>
    <div class="cadre">
        <div class="body">
            <h1><u>Connexion</u></h1>
            <form method="POST" action="login.php">
                <label><b>Nom d'utilisateur :</b></label><br />
                <input type="text" name="username" required /><br /><br />
                <label><b>Mot de passe :</b></label><br />
                <input type="password" name="password" required /><br /><br />
                <?php if (!empty($messages)): ?>
                    <ul style="color: #8f3333;">
                        <?php foreach ($messages as $msg): ?>
                            <li><b><?php echo htmlspecialchars($msg); ?></b></li>
                        <?php endforeach; ?>
                    </ul><br />
                <?php endif; ?>
                <button type="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
                <button type="submit">Se connecter</button>
            </form>
            <h6 class="copyright">©2025-Alban DOINEL</h6>
        </div>
    </div>
</body>
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
</html>
