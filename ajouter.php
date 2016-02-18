<?php

    if ($_SERVER['REQUEST_METHOD']!='POST') header('location:/RaspiConnect/index.php');
    
    $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
    if (isset($_POST['url']))
        $media = $_POST['url'];
    
    else {
        $directory = 'uploads/';
        $full_path = $directory . basename($_FILES["uploadFile"]["name"]);
        if (!file_exists($full_path) && move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $full_path))
            $media = $full_path;
        else {
            echo "Erreur lors de l'ajout du fichier. Cliquez sur ce lien pour revenir à l'accueil : <a href='index.php'>Acceuil</a>";
            $media = null;
        }
    }
    if ($media!=null) {
        $test = "SELECT id FROM media WHERE statut = 'lecture' OR statut = 'stop'";
        $request1 = $db->prepare($test);
        $request1->execute();

        if ($result = $request1->fetch(PDO::FETCH_ASSOC))
            $ajout = "INSERT INTO `media` (`id`, `url`, `titre`, `utilisateur`) VALUES (NULL, '$media', '$_POST[titre]', '$_SESSION[user]')";
        else 
            $ajout = "INSERT INTO `media` (`id`, `statut`, `url`, `titre`, `utilisateur`) VALUES (NULL, 'lecture', '$media', '$_POST[titre]', '$_SESSION[user]')";
        $request2 = $db->prepare($ajout);
        $request2->execute();
        
        header('location:/RaspiConnect/index.php');
    }
?>
