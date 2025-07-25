<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_FILES['mon_fichier']) || $_FILES['mon_fichier']['error'] != 0) {
        $message = "Erreur lors de l'envoi du fichier.";
    } else {
        $filename = $_FILES['mon_fichier']['name'];
        $ext = strtolower(substr(strrchr($filename, '.'), 1));

        $ext_interdites = array('php', 'phtml', 'exe', 'sh', 'pl', 'cgi', 'js');
        if (in_array($ext, $ext_interdites)) {
            $message = "Extension interdite pour des raisons de sécurité.";
        } else {
            $filename_clean = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

            $upload_dir = 'uploads/';
            $desc_dir = 'descriptions/';

            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755);
            if (!is_dir($desc_dir)) mkdir($desc_dir, 0755);

            $upload_path = $upload_dir . $filename_clean;

            if (move_uploaded_file($_FILES['mon_fichier']['tmp_name'], $upload_path)) {
                $nom_projet = isset($_POST['nom_projet']) ? strip_tags($_POST['nom_projet']) : '';
                $description = isset($_POST['description']) ? strip_tags($_POST['description']) : '';

                $description_file = $desc_dir . $filename_clean . '.txt';
                $contenu = "Auteur : " . $_SESSION['username'] . "\nNom du projet : " . $nom_projet . "\nDescription : " . $description;

                $fp = fopen($description_file, 'w');
                if ($fp) {
                    fwrite($fp, $contenu);
                    fclose($fp);
                    $message = "Projet publié avec succès !";
                } else {
                    $message = "Fichier enregistré, mais erreur lors de l'enregistrement de la description.";
                }
            } else {
                $message = "Erreur lors de la sauvegarde du fichier.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Publier un projet</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
</head>
<body>
  <div class="cadre">
    <div class="body">
      <h1><u>Publiez votre projet ici !</u></h1>
      <h3>Importez votre projet en cliquant sur le bouton ci-dessous et ajoutez un commentaire si nécessaire.</h3>

      <?php if ($message != '') { ?>
        <p><strong><?php echo $message; ?></strong></p>
      <?php } ?>

      <form action="publish.php" method="post" enctype="multipart/form-data">
        <input id="fichier" type="file" name="mon_fichier" style="display: none;" required>
        <button type="button" id="btn-choisir">Choisir un fichier</button>
        <span id="nom-fichier" class="custom"><b>Aucun fichier choisi</b></span>
        <br><br>
        <input type="text" name="nom_projet" placeholder="Nom du projet" required><br><br>
        <input type="text" name="description" placeholder="Description (optionnelle)"><br><br>
        <button type="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
        <button type="submit">Valider</button>
      </form>

      <h6 class="copyright">©2025-Alban DOINEL</h6>
    </div>
  </div>

<script>
  var input = document.getElementById('fichier');
  var nomFichier = document.getElementById('nom-fichier');
  var btn = document.getElementById('btn-choisir');

  btn.onclick = function() {
    input.click();
  };
  input.onchange = function() {
    if (input.files.length > 0) {
      nomFichier.textContent = input.files[0].name;
      nomFichier.className = 'fichier-choisi';
    } else {
      nomFichier.textContent = "Aucun fichier choisi";
      nomFichier.className = 'custom';
    }
  };
</script>

<style>
  .copyright {
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    width: 100%;
    font-size: 14px;
    color:#8f3333;
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
  .custom {
    color: #8f3333;
  }
  #nom-fichier.fichier-choisi {
    color: #8f3333;
    font-weight: bold;
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
</body>
</html>