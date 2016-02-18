<?php
    if ($_SERVER['REQUEST_METHOD']!='POST') header('location:/RaspiConnect/');
    
    $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
    switch ($_POST['event']) {
        case 'prec':
            $prec = "UPDATE media SET statut = '' WHERE statut = 'lecture'";
            $request = $db->prepare($prec);
            $request->execute();
            $prec = "UPDATE media SET statut = 'lecture' WHERE statut = 'précédent'";
            $request = $db->prepare($prec);
            $request->execute();
            break;
        
        case 'stop':
            $test = "SELECT id FROM media WHERE statut = 'lecture'";
            $request = $db->prepare($test);
            $request->execute();
            if ($result = $request->fetch(PDO::FETCH_ASSOC)) {
                $stop = "UPDATE media SET statut = 'stop' WHERE statut = 'lecture'";
                $request = $db->prepare($stop);
                $request->execute();
            } else {
                $stop = "UPDATE media SET statut = 'lecture' WHERE statut = 'stop'";
                $request = $db->prepare($stop);
                $request->execute();
            }
            break;
        
        case 'suiv':
            $suiv = "SELECT id FROM media WHERE id IN ( SELECT MIN(id) FROM media WHERE id > ( SELECT id FROM media WHERE statut = 'lecture'))";
            $request = $db->prepare($suiv);
            $request->execute();
            if ($result = $request->fetch(PDO::FETCH_ASSOC)) {
                $id = $result['id'];
                
                $suiv = "SELECT id FROM media WHERE statut = 'précédent'";
                $request = $db->prepare($suiv);
                $request->execute();
                if ($result = $request->fetch(PDO::FETCH_ASSOC)) {
                    $suiv = "DELETE FROM media WHERE statut = 'précédent'";
                    $request = $db->prepare($suiv);
                    $request->execute();
                }
                $suiv = "UPDATE media SET statut = 'précédent' WHERE statut = 'lecture'";
                $request = $db->prepare($suiv);
                $request->execute();
                
                $suiv = "UPDATE media SET statut = 'lecture' WHERE id = $id";
                $request = $db->prepare($suiv);
                $request->execute();
            }
    }
    header('location:/RaspiConnect/index.php');
?>
