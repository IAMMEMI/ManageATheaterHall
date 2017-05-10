<?php
session_start();
static $displayLogin = true;

if (isset($_SESSION['login_utente']) || isset($_SESSION['login_admin'])) {
    redirect();
}

function redirect() {
    $newpage = 'Index.php';
    header("location:" . $newpage);
}
?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Log-in-Sferistereo</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="IndexStyle.css">

    </head>
    <body>
    <div id="bg"></div>
        <?php
        if (isset($_GET["type"])){
            $type = $_GET["type"];
            if($type === "login"){
            
            ?>
        <!-- Modal -->
        <div class="modal" id="modalPrenot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" id="btn1"aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">ATTENZIONE!!!!!!!</h5>

                    </div>
                    <div class="modal-body">

                        <p style="color:black;">Lo username o la password sono sbagliati</p>

                    </div>

                </div> 
            </div>
        </div>
        <?php
        }}
        ?>
        <div class="container">
            <h3>BENVENUTO</h3>
            <form action="login.php" method="post">
                <div class="input-group">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                    </span>
                    <input type="text" id="user" name="user" class="form-control" placeholder="Username" autofocus/>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-lock"></span>
                    </span>
                    <input type="password" id="psw" name="psw" class="form-control" placeholder="Password"/>
                </div>
                <button type="submit" class="btn btn-success" name="login-button" onclick="top.location.href = 'login.php'">Log-in</button>
            </form>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script>
                   var url = window.location.href;
                   var modal = document.getElementById('exampleModalLong');
                   if(url.search('login')>0){
                       $('.modal').show();
                   }
        </script>
        <script>
            $(document).ready(function () {
                $('#btn1').click(function () {
                    $('.modal').hide();
                    return false;
                });
            });
        </script>      
    </body>
</html>