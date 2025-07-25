<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <meta charset="UTF-8">
    <title>Mentions légales</title>
    <style>
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
        .credits {
            font-size: 1.3em;
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
        .body {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="cadre">
        <div class="body">
            <h1><u>Mentions légales</u></h1>
            <button onclick="window.location.href='index.php'">Retour à l'accueil</button>

            <p style="text-align: center;" class="credits"><b><u>Crédits :</u></b></p>

            <p style="text-align: center;"><i><b>
                Merci aux IA ChatGPT (chatgpt.com) et Perplexity (perplexity.ai) de m'avoir<br> 
                beaucoup aidé dans la création de ce petit site internet. C'est elles qui ont<br>
                donné vie à toutes mes idées et qui m'ont donné de solides programmes pour ce site. 
            </b></i></p><br>

            <p style="text-align: center;"><i><b>
                Merci aussi à Ecosia Chat qui m'a bien débloqué aussi !
            </b></i></p><br>

            <p style="text-align: center;"><i><b>
                Grâce à vous trois, j'ai pu découvrir l'univers d'HTML et j'ai appris de solides<br>
                connaissances en HTML, tout comme en Python (avec Flask, même si ce site est codé en PHP).<br> 
                Maintenant, la prochaine fois, je saurai faire moi-même mon propre site Internet !
            </b></i></p><br>

            <p style="text-align: center;"><i><b>
                Enfin, grâce à ce site, je vais pouvoir mettre en valeur mes projets Python (et autres)<br>
                que j'ai codés. Ce site permettra aussi à des développeurs en herbe de trouver des images,<br>   
                sons et petits programmes pour leurs jeux vidéo ! N'hésitez pas aussi à mettre des petites<br>
                explications sur comment démarrer un projet ou comment coder en Python, Java, etc...
            </b></i></p><br>

            <p style="text-align: center;"><i><b>
                Une seule chose à dire : amusez-vous bien !
            </b></i></p>

            <h6 class="copyright">©2025 - Alban DOINEL</h6>
        </div>
    </div>
</body>
</html>
