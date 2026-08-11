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
                if (strtolower($username) == strtolower($stored_user) && $password == $stored_pass) {
                    $valid = true;
                    $username = $stored_user;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/style.css">
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
                    <ul class="form-messages">
                        <?php foreach ($messages as $msg): ?>
                            <li><b><?php echo htmlspecialchars($msg); ?></b></li>
                        <?php endforeach; ?>
                    </ul><br />
                <?php endif; ?>
                <div class="button-group">
                    <button type="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
                    <button type="submit">Se connecter</button>
                </div>
            </form>
            <?php include_once dirname(__FILE__) . '/footer.php'; ?>
        </div>
    </div>
</body>
</html>
