<h1>
<?php
    $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
    if ($_SESSION['type']!='raspberry') header('location:/RaspiConnect/index.php');
    
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $clean1 = "SELECT url FROM media";
        $request1 = $db->prepare($clean1);
        $request1->execute();
        while ($result = $request1->fetch(PDO::FETCH_ASSOC))
            if (file_exists($result['url'])) unlink ($result['url']);
        
        $clean2 = "DELETE FROM media";
        $request2 = $db->prepare($clean2);
        $request2->execute();
    }
?>
</h1>
<script>
    var popup = null;
    function update() {
        var url = document.getElementById('url');
        var media = document.getElementById('media');
        setTimeout(function(){ url.src = url.src; }, 5000);
        var content = url.contentDocument.title;
        if (media.src != content) {
            if (popup!==null) popup.close();
            location.reload(true);
        }
    }
</script>
<div class="container">
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-10 col-xs-10 col-xs-offset-1">
        <iframe id="url" src="url.php" style="height: 0px; visibility: hidden" onload="update()"></iframe>
        <iframe id="media" src="<?php
                $db = new pdo('mysql:host=localhost;dbname=raspi_connect', 'root', 'password');
                $url = "SELECT url, statut FROM media WHERE statut = 'lecture' OR statut = 'stop'";
                $request = $db->prepare($url);
                $request->execute();
                if (($result = $request->fetch(PDO::FETCH_ASSOC)) && ($result['statut']!='stop'))
                    echo $result['url'];
                else echo 'vinyl.jpg';
            ?>" style="width: 100%; height: 40vw; border: none"></iframe>
        <form method="post" action="index.php">
            <button type="submit" class="btn btn-lg btn-danger" style="font-family: zekton; width: 49%; margin-left: 1%">Vider la liste de lecture</button>
            <button type="button" class="btn btn-lg btn-default" style="font-family: zekton; width: 49%" onclick="popup = window.open(document.getElementById('media').src)">
                Ouvrir dans une popup</button>
        </form>
        <form role="form" method="post" action="index.php">
            <div class="form-group">
                <button name="deconnexion" type="submit" class="btn btn-primary btn-lg btn-block" style="font-family: zekton" value="">Déconnexion</button>
            </div>
        </form>
    </div>
        
</div>
