<?php
    if ($_SERVER['REQUEST_METHOD']!='POST') header('location:/RaspiConnect/');
    
    $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
    switch ($_POST['event']) {
        case 'prec':
            $prec1 = "UPDATE media SET statut = '' WHERE statut = 'lecture'";
            $request1 = $db->prepare($prec1);
            $request1->execute();
            $prec2 = "UPDATE media SET statut = 'lecture' WHERE statut = 'précédent'";
            $request2 = $db->prepare($prec2);
            $request2->execute();
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
            $suiv1 = "SELECT id FROM media WHERE id IN ( SELECT MIN(id) FROM media WHERE id > ( SELECT id FROM media WHERE statut = 'lecture'))";
            $request1 = $db->prepare($suiv1);
            $request1->execute();
            if ($result = $request1->fetch(PDO::FETCH_ASSOC)) {
                $id = $result['id'];
                
                $suiv2 = "SELECT url FROM media WHERE statut = 'précédent'";
                $request2 = $db->prepare($suiv2);
                $request2->execute();
                if ($result = $request2->fetch(PDO::FETCH_ASSOC)) {
                    if (file_exists($result['url'])) unlink ($result['url']);
                    $suiv3 = "DELETE FROM media WHERE statut = 'précédent'";
                    $request3 = $db->prepare($suiv3);
                    $request3->execute();
                }
                $suiv4 = "UPDATE media SET statut = 'précédent' WHERE statut = 'lecture'";
                $request4 = $db->prepare($suiv4);
                $request4->execute();
                
                $suiv5 = "UPDATE media SET statut = 'lecture' WHERE id = $id";
                $request5 = $db->prepare($suiv5);
                $request5->execute();
            }
    }
    header('location:/RaspiConnect/index.php');
?>
