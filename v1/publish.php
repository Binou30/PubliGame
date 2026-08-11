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

        $ext_interdites = array('phtml', 'sh', 'pl', 'cgi');
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
                    header("Location: index.php?flash=1");
                    exit();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier un projet</title>
    <link rel="icon" href="static/favicon.png" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
  <div class="cadre">
    <div class="body">
      <h1><u>Publiez votre projet ici !</u></h1>
      <h3>Importez votre projet en cliquant sur le bouton ci-dessous et ajoutez un commentaire si nécessaire.</h3>
      <form action="publish.php" method="post" enctype="multipart/form-data" class="publish-form" onsubmit="return confirm('Voulez-vous vraiment publier ce projet ?');">
        <input id="fichier" type="file" name="mon_fichier" class="file-input-hidden" required>
        <button type="button" id="btn-choisir">Choisir un fichier</button>
        <span id="nom-fichier" class="custom"><b>Aucun fichier choisi</b></span>
        <br><br>
        <input type="text" name="nom_projet" placeholder="Nom du projet" required class="form-input"><br><br>
        <input type="text" name="description" placeholder="Description (optionnelle)" class="form-input"><br><br>
        <div class="button-group">
          <button type="button" onclick="window.location.href='index.php'">Retour à l'accueil</button>
          <button type="submit">Valider</button>
        </div>
      </form>

      <?php include_once dirname(__FILE__) . '/footer.php'; ?>
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
</body>
</html>
