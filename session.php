<?php
    session_start();
    //session_destroy();
    if (!isset($_SESSION['type'])) {
        $_SESSION['type'] = 'accueil';
    }
?>
