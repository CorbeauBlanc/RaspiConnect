
<div class="container">
    <div class="col-lg-4 col-lg-offset-4 col-xs-10 col-xs-offset-1">
        <?php
            if ($_SESSION['type']=='errorR')
                echo '<div class="alert alert-danger">Erreur! Vous avez entré un mauvais mot de passe.<a href="#" class="close" data-dismiss="alert">&times;</a></div>';
            elseif ($_SESSION['type']=='errorU')
                echo '<div class="alert alert-danger">Erreur! Ce nom d\'utilisateur est utilisé en ce moment.<a href="#" class="close" data-dismiss="alert">&times;</a></div>';
        ?>
        <h1 class="visible-lg visible-md">Type de compte :</h1>
        <h2 class="visible-xs">Type de compte :</h2>
        <script>
            function valider() {
                if (document.getElementById('mdp').value == '' && document.getElementById('log').value == '')
                    return false;
                else return true;
            }
        </script>
        <form role="form" method="post" action="index.php" onsubmit="valider()">
                <div class="form-group">
                    <input type="hidden" id="type" name="type" value="" />
                    <button type="button" data-toggle="collapse" data-target="#password" class="btn btn-primary btn-lg btn-block">
                        <span class="button-text-lg">Raspberry Pi</span>
                    </button>
                    <div id="password" class="collapse">
                        <h2 style="font-size: 25px">Veuillez entrer le mot de passe</h2>
                        <input type="password" id="mdp" class="form-control" name="password" />
                        <button type="submit" class="btn btn-block btn-success" onclick="document.getElementById('type').value='raspi'">
                            <span class="button-text-lg">Valider</span>
                        </button>
                    </div>
                    <br>
                    <button type="button" data-toggle="collapse" data-target="#login" class="btn btn-primary btn-lg btn-block">
                        <span class="button-text-lg">Utilisateur</span>
                    </button>
                    <div id="login" class="collapse">
                        <h2 style="font-size: 22px">Veuillez entrer un nom d'utilisateur</h2>
                        <input type="text" class="form-control" style="font-size: 16px" id="log" name="login" />
                        <button type="submit" class="btn btn-block btn-success" onclick="document.getElementById('type').value='user'">
                            <span class="button-text-lg">Valider</span>
                        </button>
                    </div>
                </div>
            </form>
    </div>
</div>