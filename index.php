<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
echo '<!-- Début du script -->';
$messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
unset($_SESSION['messages']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <meta charset="UTF-8">
    <title>PubliGame</title>
    <script id="messages-data" type="application/json">
        <?php /* echo json_encode($messages); */ ?>
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
    <style>
        .ligne {
            width: 4px; 
            background-color: #000000; 
            height: 200vh; 
            position: fixed; 
            left: 77%; 
            margin-top: -300px;
        }
        body {
            margin: -1;
            height: 100vh;
            background-image: url("static/fd.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #8f3333;
        }
    </style>
</head> 
<body class="body">
    <div class="cadre">
        <div class="body">
            <h1><u>Hello, bienvenue sur PubliGame !</u></h1>

            <?php if (isset($_SESSION['username'])): ?>
                <div style="position: absolute; top: 20px; right: 50px; text-align: center;">
                    <h2><u>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?> !</u></h2>
                    <form method="POST" action="logout.php">
                        <button type="submit" style="margin-top: -20px;">Se déconnecter</button>
                    </form>
                    <form method="POST" action="deleteaccount.php" onsubmit="return confirm('Êtes-vous sûr de supprimer votre compte ?');">
                        <button type="submit" style="margin-top: 20px; color: #8f3333;">Supprimer le compte</button>
                    </form> 
                    <div class="ligne"></div>       
                </div>
            <?php else: ?>
                <p>
                    <button id="boutoncréercompte" onclick="window.location.href='register.php'">Créer un compte</button>
                    <button id="boutonconnexion" onclick="window.location.href='login.php'">Connexion</button>
                </p>
            <?php endif; ?>

            <p><b>C'est un site que j'ai créé ! Vous y trouverez mes projets publiés ainsi que des commentaires et plein d'autres choses ! Bonne exploration !</b></p>
            <button onclick="window.location.href='publish.php'">Publier un projet</button>
            <button onclick="window.location.href='publies.php'">Projets publiés</button>
            <button onclick="window.location.href='echanges.php'">Échanges</button>
            <button onclick="window.location.href='legalmentions.php'">Mentions légales</button>
            <h6 class="copyright">©2025-Alban DOINEL</h6>
        </div>
    </div>
</body>
<style>
    .body {
        margin-left: 5px;
    }
    #boutoncréercompte {
        position: fixed;
        top: 25px;   
        right: 95px;
    }
    #boutonconnexion {
        position: fixed;
        top: 25px;
        right: 10px;
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
    .cadre {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;  
        bottom: 0;
        background-color: transparent;
        border: 5px solid #727272;
        box-sizing: border-box;
    }
</style>
</html>