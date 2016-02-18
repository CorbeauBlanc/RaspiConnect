<?php
    if ($_SERVER['REQUEST_METHOD']!='POST') header('location:/RaspiConnect/index.php');
    
    if (isset($_POST['url'])) {
        $test = "SELECT id FROM media WHERE statut = 'lecture' OR statut = 'stop'";
        $request = $db->prepare($test);
        $request->execute();

        if ($result = $request->fetch(PDO::FETCH_ASSOC))
            $ajout = "INSERT INTO `media` (`id`, `url`, `titre`, `utilisateur`) VALUES (NULL, '$_POST[url]', '$_POST[titre]', '$_SESSION[user]')";
        else 
            $ajout = "INSERT INTO `media` (`id`, `statut`, `url`, `titre`, `utilisateur`) VALUES (NULL, 'lecture', '$_POST[url]', '$_POST[titre]', '$_SESSION[user]')";
        $request = $db->prepare($ajout);
        $request->execute();
    } elseif (isset ($_POST['file'])) {
        $directory = 'uploads/';
        $full_path = $directory . basename($_FILES["fileToUpload"]["name"]);
        if (!file_exists($full_path) && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $full_path))
            header('location:/RaspiConnect/index.php');
        else echo "Erreur lors de l'ajout du fichier. Cliquez sur ce lien pour revenir à l'accueil : <a href='index.php'>Acceuil</a>";
    }
?>
