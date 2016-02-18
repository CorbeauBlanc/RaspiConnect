<!DOCTYPE html>
<html>

    <head><title>[Raspi Connect]</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/custom.css">
        <?php include_once 'session.php'; ?>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
    </head>
    <body>
    <?php
    $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
        if ($_SERVER['REQUEST_METHOD']=="POST")
        {
            if (isset($_POST['type'])) {
                if ($_POST['type']=='raspi' && $_POST['password']=='r@spberry') {
                    $_SESSION['type'] = 'raspberry';
                    $_SERVER['REQUEST_METHOD'] = '';
                    include 'raspberry.php';
                }
                elseif ($_POST['type']=='user') {
                    $util = "SELECT nom FROM utilisateurs WHERE nom = '$_POST[login]'";
                    $request = $db->prepare($util);
                    $request->execute();
                    if ($result = $request->fetch(PDO::FETCH_ASSOC)) {
                        $_SESSION['type'] = 'errorU';
                        include 'accueil.php';
                    } else {
                        $_SESSION['type'] = 'utilisateur';
                        $_SESSION['user'] = $_POST['login'];
                        $nouv = "INSERT INTO `utilisateurs`(`nom`) VALUES ('$_POST[login]')";
                        $request = $db->prepare($nouv);
                        $request->execute();
                        $_SERVER['REQUEST_METHOD'] = '';
                        include 'utilisateur.php';
                    }
                }
                else {
                    $_SESSION['type'] = 'errorR';
                    include 'accueil.php';
                }
            } elseif (isset ($_POST['deconnexion'])) {
                if ($_SESSION['type']!='raspberry') {
                $deco = "DELETE FROM utilisateurs WHERE nom = '$_SESSION[user]'";
                $request = $db->prepare($deco);
                $request->execute();
                }
                $_SESSION['type'] = 'accueil';
                include 'accueil.php';
            } else include "$_SESSION[type].php";
        } else include "$_SESSION[type].php";
    ?>
        
    </body>

</html>