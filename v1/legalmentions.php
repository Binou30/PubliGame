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
    <style>
@import url("static/site.css");
        body {
            margin: 0;
            min-height: var(--viewport-height);
            overflow-x: hidden;
            overflow-y: auto;
            color: var(--text);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: transparent;
        }

        button {
            padding: clamp(0.5rem, 1.2vw, 0.65rem) clamp(0.9rem, 2vw, 1rem);
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, #ff8a3c, #ff4f81);
            color: #ffffff;
            font-weight: 600;
            font-family: 'Poppins', inherit;
            font-size: clamp(0.72rem, 2vw, 0.85rem);
            letter-spacing: 0.02em;
            cursor: pointer;
            box-shadow: 0 clamp(0.375rem, 1.5vw, 0.5rem) clamp(0.875rem, 2.5vw, 1.125rem) rgba(0, 0, 0, 0.25);
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

        p {
            font-size: clamp(0.82rem, 2vw, 1rem);
            font-weight: 500;
            color: #8f3333;
            line-height: 1.7;
            text-shadow: 0.0625rem 0.0625rem 0.1875rem rgba(0, 0, 0, 0.2);
            margin: clamp(0.75rem, 2vw, 0.9375rem) 0;
        }

        p b, p i b {
            font-weight: 600;
            text-shadow: 0.0625rem 0.0625rem 0.25rem rgba(0, 0, 0, 0.25);
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
        .credits {
            font-size: clamp(1rem, 3vw, 1.3rem);
        }
        .cadre {
            background-color: transparent;
            border: clamp(0.25rem, 1vw, 0.3125rem) solid #727272;
            box-sizing: border-box;
            position: relative;
        }
        .return-home {
            margin-top: clamp(0.1rem, 0.3vw, 0.1rem);
        }
        .body {
            margin-left: clamp(0.25rem, 1vw, 0.3125rem);
            padding: clamp(0.5rem, 2vw, 0.9rem);
            padding-bottom: clamp(10rem, 14vw, 12rem);
            min-height: calc(var(--viewport-height) + 12rem);
            display: flex;
            flex-direction: column;
            background: rgba(7, 16, 34, 0.72) !important;
            border-radius: 12px !important;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            button {
                width: 100%;
                max-width: 300px;
                margin: 0.5rem 0;
            }

            h1 {
                font-size: clamp(1.5rem, 6vw, 2rem);
            }

            p {
                font-size: clamp(0.85rem, 3vw, 1rem);
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
</head>
<body>
    <div class="cadre">
        <div class="body">
            <h1><u>Mentions légales</u></h1>
            <button class="return-home" onclick="window.location.href='index.php'">Retour à l'accueil</button>

            <p style="text-align: center;" class="credits"><b><u>Crédits :</u></b></p>

            <p style="text-align: center;"><i><b>
                Merci aux IA ChatGPT (chatgpt.com), Perplexity AI (perplexity.ai) et Copilot de m'avoir<br>
                beaucoup aidé dans la création de ce site. C'est elles qui ont donné vie à mes idées et<br>
                m'ont aidé à produire des programmes solides pour ce site. 
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

            <?php include_once dirname(__FILE__) . '/footer.php'; ?>
            <script>
                (function(){
                    var footer = document.querySelector('.site-footer');
                    if(!footer) return;
                    footer.classList.add('hide-until-bottom');

                    function updateViewportHeight() {
                        var height = window.innerHeight || document.documentElement.clientHeight || 1;
                        document.documentElement.style.setProperty('--viewport-height', height + 'px');
                    }

                    function checkFooter(){
                        var atBottom = (window.innerHeight + window.pageYOffset) >= (document.documentElement.scrollHeight - 10);
                        footer.classList.toggle('visible', atBottom);
                    }

                    function syncFooter() {
                        updateViewportHeight();
                        checkFooter();
                    }

                    window.addEventListener('scroll', checkFooter, { passive: true });
                    window.addEventListener('resize', syncFooter, { passive: true });
                    window.addEventListener('orientationchange', syncFooter, { passive: true });
                    window.addEventListener('pageshow', syncFooter);
                    document.addEventListener('DOMContentLoaded', function() {
                        requestAnimationFrame(syncFooter);
                    });
                    window.addEventListener('load', syncFooter);
                    window.setTimeout(syncFooter, 0);
                    window.setTimeout(syncFooter, 150);
                })();
            </script>
        </div>
    </div>
</body>
</html>
