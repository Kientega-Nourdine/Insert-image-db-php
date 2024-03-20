<?php
    // Verification du serveur si la methode post est appelee
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verification si un element de type image n'est pas charger
        if(empty($_FILES['image_file']['tmp_name'])) {
            header('location:index.php?message=er');
        }

        // Si une image est charger on recupere le nom de l'image et de son extension
        $file_basename = pathinfo($_FILES["image_file"]['name'], PATHINFO_FILENAME);
        $file_extension = pathinfo($_FILES["image_file"]['name'], PATHINFO_EXTENSION);
        // Creation de l'image avec un nouveau nom associer
        $new_image_name = $file_basename . "_" . date('Ymd_His') . '.' . $file_extension;

        // inclusion du fichier de connexion
        include_once './connexion.php';

        // Protection contre les attaques sql du fichier
        $new_image_name = $connect_db->real_escape_string($new_image_name);

        //Insertion de l'image dans la base de donnee
        $sql = "INSERT INTO images (libelle) VALUES ('$new_image_name')";

        // Verification si l'image est inserer dans la db
        if($connect_db->query($sql)) {
            // on creer un repertoire pour stocker l'image en local
            $target_directory = 'images/';
            // creation du chemin d'enregistrement du fichier
            $target_path = $target_directory . $new_image_name;

            // on passe a la sauvegarde du fichier en local en verifiant si cela a bien reussi
            if(!move_uploaded_file($_FILES['image_file']['tmp_name'], $target_path)) {
                header('location:index.php?message=er');
            } 
            header('location:index.php?message=ok');
        } else {
            header('location:index.php?message=er');
        }

        // Fermeture de la connexion a la bd
        $connect_db->close();

    }
?>
<?php include_once './connexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inserer image db php</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="alert sucess">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            L'insertion de l'image dans la bdd  a réussi !
        </div>
        <div class="alert fail">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            L'insertion de l'image dans la bdd a échoué !
        </div>
        <label for="images" class="drop-container" id="dropcontainer">
            <span class="drop-title">Déposez les fichiers ici</span>
            ou
            <input type="file" name="image_file" id="images" accept="image/*" required>
        </label>
        <button type="submit" id="submitBtn">Enregister l'image</button>
    </form>
    <script src="script.js"></script>
</body>
</html>
