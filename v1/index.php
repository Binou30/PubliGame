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
@import url("static/site.css");
        button {
            padding: clamp(0.5rem, 1.2vw, 0.65rem) clamp(0.85rem, 2vw, 1rem);
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, #ff8a3c, #ff4f81);
            color: #ffffff;
            font-weight: 600;
            font-family: 'Poppins', inherit;
            font-size: clamp(0.72rem, 2vw, 0.85rem);
            letter-spacing: 0.02em;
            cursor: pointer;
            box-shadow: 0 clamp(0.25rem, 1vw, 0.35rem) clamp(0.65rem, 1.5vw, 0.8rem) rgba(0, 0, 0, 0.18);
            transition:
                transform 0.15s ease,
                box-shadow 0.15s ease,
                filter 0.15s ease,
                background-position 0.2s ease;
            background-size: 150% 150%;
            background-position: 0% 50%;
        }

        button:hover {
            transform: translateY(-0.125rem);
            box-shadow: 0 clamp(0.625rem, 2vw, 0.75rem) clamp(1.25rem, 3vw, 1.5rem) rgba(0, 0, 0, 0.35);
            filter: brightness(1.05);
            background-position: 100% 50%;
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 clamp(0.375rem, 1.5vw, 0.5rem) clamp(0.625rem, 2vw, 0.75rem) rgba(0, 0, 0, 0.3);
            filter: brightness(0.97);
        }

        button.danger {
            background: linear-gradient(135deg, #ff5959, #b80028);
        }

        button.danger:hover {
            filter: brightness(1.05);
        }

        button.danger:active {
            filter: brightness(0.95);
        }

        .ligne {
            width: 0.25rem;
            background-color: #000000;
            position: absolute;
            top: 0;
            right: calc(100% + clamp(1rem, 2vw, 1.5rem));
            height: 100vh;
        }

        @media (max-width: 768px) {
            .ligne {
                display: none;
            }
        }
        html {
            overflow-x: hidden;
        }
        body {
            margin: 0;
            min-height: var(--viewport-height);
            height: auto;
            overflow-x: hidden;
            overflow-y: auto;
            color: var(--text);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: transparent;
        }

        h1 {
            font-size: clamp(1.6rem, 4vw, 2.3rem);
            font-weight: 800;
            color: #8f3333;
            text-shadow: 0.1875rem 0.1875rem 0.5rem rgba(0, 0, 0, 0.3),
                         0 0 1.25rem rgba(143, 51, 51, 0.2);
            letter-spacing: -0.02em;
            margin-bottom: clamp(1rem, 3vw, 1.25rem);
            transition: text-shadow 0.3s ease;
        }

        h1:hover {
            text-shadow: 0.25rem 0.25rem 0.75rem rgba(0, 0, 0, 0.4),
                         0 0 1.875rem rgba(143, 51, 51, 0.3);
        }

        h2 {
            font-size: clamp(1rem, 3vw, 1.6rem);
            font-weight: 700;
            color: #8f3333;
            text-shadow: 0.125rem 0.125rem 0.375rem rgba(0, 0, 0, 0.25),
                         0 0 0.9375rem rgba(143, 51, 51, 0.15);
            letter-spacing: -0.01em;
            margin-bottom: clamp(0.75rem, 2vw, 0.9375rem);
        }

        p {
            font-size: clamp(0.82rem, 2vw, 0.98rem);
            font-weight: 500;
            color: #8f3333;
            line-height: 1.7;
            text-shadow: 0.0625rem 0.0625rem 0.1875rem rgba(0, 0, 0, 0.2);
            margin: clamp(0.75rem, 2vw, 0.9375rem) 0;
        }

        p b {
            font-weight: 600;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
        }
    </style>
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
<style>
@import url("static/site.css");
    .body {
        margin-left: clamp(0.25rem, 1vw, 0.3125rem);
        padding: clamp(0.5rem, 2vw, 1rem);
        min-height: calc(var(--viewport-height) - clamp(2rem, 4vw, 3rem));
        display: flex;
        flex-direction: column;
        text-align: left;
    }
    body.logged-in .body {
        max-width: calc(100% - clamp(20rem, 28vw, 22rem));
    }
    body.logged-in p {
        max-width: calc(100% - clamp(20rem, 28vw, 22rem));
        word-wrap: break-word;
    }
    body.logged-in h1,
    body.logged-in p,
    body.logged-in button {
        text-align: left;
    }
    .top-auth-buttons {
            position: static;
            display: flex;
            justify-content: center;
            gap: clamp(0.5rem, 2vw, 1rem);
            align-items: center;
            flex-wrap: wrap;
            margin: clamp(1rem, 2vw, 1.25rem) 0 clamp(1.5rem, 3vw, 1.75rem);
    }

    .main-menu-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: flex-start;
            gap: clamp(0.75rem, 2vw, 1rem);
            margin-bottom: clamp(1rem, 2vw, 1.25rem);
            width: 100%;
    }

    .main-menu-buttons button {
            width: auto;
            padding: clamp(0.5rem, 1.2vw, 0.65rem) clamp(0.85rem, 2vw, 1rem);
            white-space: normal;
    }

    #boutoncréercompte,
    #boutonconnexion {
        position: static;
    }
    .copyright {
        text-align: center;
        width: 100%;
        font-size: clamp(0.7rem, 2vw, 0.8125rem);
        font-weight: 500;
        color: #8f3333;
        text-shadow: 0.0625rem 0.0625rem 0.25rem rgba(0, 0, 0, 0.3);
        letter-spacing: 0.05em;
        opacity: 0.9;
        transition: opacity 0.3s ease;
        margin-top: clamp(2rem, 5vw, 3rem);
        padding-bottom: clamp(1rem, 3vw, 2rem);
    }

    .copyright:hover {
        opacity: 1;
    }
    .user-menu {
        position: absolute;
        top: clamp(1rem, 3vw, 1.25rem);
        right: clamp(1.5rem, 5vw, 3.125rem);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: clamp(0.5rem, 2vw, 1rem);
        text-align: center;
        max-width: clamp(16rem, 22vw, 24rem);
        white-space: normal;
        word-break: break-word;
    }

    .user-menu h2 {
        max-width: 100%;
        white-space: normal;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .user-menu form {
        margin: 0;
    }

    .cadre {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;  
        bottom: 0;
        background-color: transparent;
        border: clamp(0.25rem, 1vw, 0.3125rem) solid #727272;
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .user-menu {
            position: relative;
            top: auto;
            right: auto;
            margin-bottom: 1.5rem;
        }
        
        .top-auth-buttons {
            position: static;
            margin: 0 0 1rem 0;
            justify-content: flex-start;
        }

        .top-auth-buttons button,
        .main-menu-buttons button {
            width: auto;
            max-width: 18rem;
            margin: 0.5rem 0;
        }

        h1 {
            font-size: clamp(1.5rem, 6vw, 2rem);
        }

        h2 {
            font-size: clamp(1rem, 4vw, 1.4rem);
        }
    }

    @media (max-width: 480px) {
        .body {
            margin-left: 0.5rem;
            padding: 0.5rem;
        }

        h1 {
            font-size: 1.5rem;
        }

        h2 {
            font-size: 1.1rem;
        }

        button {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
        }

        .cadre {
            border-width: 0.25rem;
        }
    }

    @media (min-width: 1200px) {
        .body {
            max-width: 1200px;
            margin: 0 auto;
        }
    }
</style>
</html>
