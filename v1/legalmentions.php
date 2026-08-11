<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
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
    <title>Mentions légales</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <div class="cadre">
        <div class="body">
            <h1><u>Mentions légales</u></h1>
            <button class="return-home" onclick="window.location.href='index.php'">Retour à l'accueil</button>

            <p class="credits text-center"><b><u>Crédits :</u></b></p>

            <p class="text-center"><i><b>
                Merci aux IA ChatGPT (chatgpt.com), Perplexity AI (perplexity.ai) et Copilot de m'avoir<br>
                beaucoup aidé dans la création de ce site. C'est elles qui ont donné vie à mes idées et<br>
                m'ont aidé à produire des programmes solides pour ce site.
            </b></i></p><br>

            <p class="text-center"><i><b>
                Merci aussi à Ecosia Chat qui m'a bien débloqué aussi !
            </b></i></p><br>

            <p class="text-center"><i><b>
                Grâce à vous trois, j'ai pu découvrir l'univers d'HTML et j'ai appris de solides<br>
                connaissances en HTML, tout comme en Python (avec Flask, même si ce site est codé en PHP).<br>
                Maintenant, la prochaine fois, je saurai faire moi-même mon propre site Internet !
            </b></i></p><br>

            <p class="text-center"><i><b>
                Enfin, grâce à ce site, je vais pouvoir mettre en valeur mes projets Python (et autres)<br>
                que j'ai codés. Ce site permettra aussi à des développeurs en herbe de trouver des images,<br>
                sons et petits programmes pour leurs jeux vidéo ! N'hésitez pas aussi à mettre des petites<br>
                explications sur comment démarrer un projet ou comment coder en Python, Java, etc...
            </b></i></p><br>

            <p class="text-center"><i><b>
                Une seule chose à dire : amusez-vous bien !
            </b></i></p>

            <?php include_once dirname(__FILE__) . '/footer.php'; ?>
        </div>
    </div>
</body>
</html>
