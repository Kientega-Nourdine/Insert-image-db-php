<?php
    // Configuration de la connexion a la db
    $servername = '127.0.0.1';
    $username = 'root';
    $password = '';
    $dbname = 'insert_images';

    // Execution de la connextion a la db
    $connect_db = new mysqli($servername, $username, $password, $dbname);

    // Verification de la connexion
    if($connect_db->connect_error) {
        die('La connexion a la db a echouer : '. $connect_db->connect_error);
    }

    // echo "la connexion a la db a reussie";
?>