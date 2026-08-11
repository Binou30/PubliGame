<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
unset($_SESSION['messages']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PubliGame</title>
    <script id="messages-data" type="application/json">
        []
    </script>
    <script>
        window.onload = function () {
            const raw = document.getElementById("messages-data").textContent;
            const messages = JSON.parse(raw);
            if (messages.length > 0) {
                alert(messages[0]);
            }
        };
    </script>
    <link rel="stylesheet" href="static/style.css">
</head>
<body class="body <?php echo isset($_SESSION['username']) ? 'logged-in' : ''; ?>">
    <div class="cadre">
        <div class="body">
            <h1><u>Hello, bienvenue sur PubliGame !</u></h1>

            <?php if (isset($_SESSION['username'])): ?>
                <div class="user-menu">
                    <h2><u>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?> !</u></h2>
                    <form method="POST" action="logout.php">
                        <button type="submit">Se déconnecter</button>
                    </form>
                    <form method="POST" action="deleteaccount.php" onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte ?');">
                        <button type="submit" class="danger">Supprimer le compte</button>
                    </form>
                    <div class="ligne"></div>
                </div>
            <?php else: ?>
                <div class="top-auth-buttons">
                    <button id="boutoncréercompte" onclick="window.location.href='register.php'">Créer un compte</button>
                    <button id="boutonconnexion" onclick="window.location.href='login.php'">Connexion</button>
                </div>
            <?php endif; ?>

            <p><b>C'est un site que j'ai créé ! Vous y trouverez mes projets publiés ainsi que des commentaires et plein d'autres choses ! Bonne exploration !</b></p>
            <div class="main-menu-buttons">
                <button onclick="window.location.href='publish.php'">Publier un projet</button>
                <button onclick="window.location.href='publies.php'">Projets publiés</button>
                <button onclick="window.location.href='echanges.php'">Échanges</button>
                <button onclick="window.location.href='legalmentions.php'">Mentions légales</button>
            </div>
            <?php include_once dirname(__FILE__) . '/footer.php'; ?>
        </div>
    </div>
    <?php
    if (isset($_GET['flash']) && $_GET['flash'] == 1) {
        echo '<script>alert("Projet publié avec succès!");</script>';
    }
    ?>
</body>
</html>
