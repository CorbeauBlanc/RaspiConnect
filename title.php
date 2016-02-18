<html>
    <head><title>Titre</title></head>
    <body>
    <?php
        if ($_GET['url']!='') {
            $str = file_get_contents($_GET['url']);
            if(strlen($str)>0){
                $str = trim(preg_replace('/\s+/', ' ', $str));
                preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title);
                echo $title[1];
            }
        }
    ?>
    </body>
</html>