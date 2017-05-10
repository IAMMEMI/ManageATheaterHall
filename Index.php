<?php
include "config.php";
session_start();
static $utente = false;
static $admin = false;
static $displayLogin = true;
static $displayLogout = false;

if (isset($_SESSION['login_utente'])) {
    $utente = true;
    $displayLogin = false;
    $displayLogout = true;
} else if (isset($_SESSION['login_admin'])) {
    $admin = true;
    $displayLogin = false;
    $displayLogout = true;
} else {
    $newpage = 'LoginPage.php';
    header("location:" . $newpage);
}
?>

<html lang="en">
    <head>
        <title>Sferistereo::Musicultura</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="IndexStyle.css">    
    </head>
    <body>
    <div id="bg"></div>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand">SFERISTEREO</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="Index.php">Home</a></li>
                            <?php
                            $query = "SELECT `IDSerata`, `Denominazione` FROM `serate` ORDER BY 'Data'";
                            $result = mysql_query($query) or die(mysql_error());
                            while ($row = mysql_fetch_array($result)) {
                                $serata = $row['Denominazione'];
                                $id = $row['IDSerata'];
                                echo "<li><a href=\"Index.php?ID=$id\" value='$id'>$serata</a></li>";
                            }
                            ?> 
                        </ul>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>  
            </div>        
        </nav>

        <?php
        if (isset($_GET["ID"])) {

            //ho un idserata impostato quindi di conseguenza devo rendere disponibile tutte le informazioni con i bottoni per ogni posto
            $IDSerata = $_GET["ID"];
            $serata = "SELECT Denominazione FROM serate WHERE IDSerata = $IDSerata";
            $ris = $risultati = @mysql_query($serata) or die(mysql_error());
            $serata = mysql_fetch_array($ris)['Denominazione'];
            if($admin){
            echo "<div class='jumbotron' id='jb1'> <button class='btn btn-secondary btn-sm' id='add'><span>+</span></button> <h2>BENVENUTO</h2><p>Qui potrai gestire l'assegnazione dei posti per la $serata</p>";
            } else {
                echo "<div class='jumbotron' id='jb1'><h2>BENVENUTO</h2><p>Qui potrai visualizzare l'assegnazione dei posti per la $serata</p>";
            }
            
            echo "<div class='container-posti'><div class='row'>";
            $i=1;
            while($i<51){
                
                echo "<div class='col-md-1 col-md-1'><button class='btn btn-warning' id=$i name=$i><span>$i</span></button></div>";
                
                if($i % 10 === 0){
                    
                    if($i==50){
                        echo "</div></div></div>";
                    } else{
                        echo "</div><div class='row'>";
                        
                    }
                }
                $i++;
            }
           
            $assegnazioni = "SELECT * FROM assegnazioni WHERE Serata =$IDSerata";
            $risultati = @mysql_query($assegnazioni) or die(mysql_error());
            while ($row2 = mysql_fetch_array($risultati)) {              
                        $id = $row2['Posto'];
                        echo "<script>document.getElementById('$id').className = 'btn btn-info';
                               document.getElementById('$id').onclick = function () {window.location.href = 'Index.php?POSTO=$id&ID=$IDSerata';} </script>";
                    }
                    echo "</div>";
                    
                
             echo "</div></div>";
             
            //modal per le informazioni del posto
            if(isset($_GET["POSTO"])){
                    $posto = $_GET["POSTO"];
                    $sql1 = "SELECT * FROM assegnazioni WHERE Posto ='$posto' AND Serata=$IDSerata";
                    $query1 = @mysql_query($sql1) or die (mysql_error());
                    while($row = mysql_fetch_array($query1)){
                        $id = $row['ID'];
                        $CFspettatore = $row['Spettatore'];
                        
                        }
                    $sql1 = "SELECT * FROM spettatori WHERE CodiceFiscale = '$CFspettatore'";
                    $query1 = @mysql_query($sql1) or die (mysql_error());
                    while($row = mysql_fetch_array($query1)){
                        $nome = $row['Nome'];
                        $cognome = $row['Cognome'];
                    }

            ?>
             <div class="modal" id="modalINFOPosto" tabindex="-1" role="dialog" aria-labelledby="modalINFOPosto" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" id="btnchiudiInfo"aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                      <h5 class="modal-title">Info prenotazione</h5>

                  </div>
                  <div class="modal-body">
                      <h4>Nome</h4>
                      <p style="color:black;"><?php echo $nome . " ".  $cognome; ?></p>
                      <h4>Codice Fiscale</h4>
                      <p style="color:black;"><?php echo $CFspettatore;?></p>
                      <h4>N. Posto</h4>
                      <p style="color:black;"><?php echo $posto; ?></p>

                      </div>

                     </div> 
                </div>
              </div>
            <script>
              var chiudiInfoPosto = document.getElementById("btnchiudiInfo");
            chiudiInfoPosto.onclick = function(){
                $('#modalINFOPosto').hide();
            };
            </script>
             <?php
            }
        
                       
        } else {
            ?>
            <div class="container"></div>
            <div class="jumbotron" id="jb1">
                <h2>BENVENUTO</h2>      
                <p>Sei nella pagina principale, da qui potrai gestire l'assegnazione dei posti per le diverse serate</p>
            </div>
            <?php
            //non ho nessun id quindi significa che carico tutte le serate
            $sql1 = "SELECT `IDSerata`, `Denominazione` FROM `serate` ORDER BY 'Data' DESC";
            $query1 = @mysql_query($sql1) or die(mysql_error());
            while ($row = mysql_fetch_array($query1)) {
                $serata = $row['Denominazione'];
                $id = $row['IDSerata'];
                echo "<div class='jumbotron' id='jb2'><h3>$serata</h3><p>Clicca su questo bottone per poter gestire l'assegnazione dei posti della $serata</p><button class='btn btn-primary btn-lg' onclick='redirect($id)'><span class='glyphicon glyphicon-arrow-right'></span></button></div><br>";
            }
        }
        if($admin){
        ?>
    <div class="modal" id="modalPrenot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form class="form-group" action="prenotazione.php?ID=<?php echo $_GET["ID"]; ?>" method="post">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" id="btn1"aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    <h5 class="modal-title">PRENOTAZIONI</h5>

    </div>
    
    <div class="modal-body">
    <div class="container-fluid">
    <h4>Spettatore</h4>
    <select name="Spettatore" >
    <?php
    $query = "SELECT * FROM `spettatori`";
    $result = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_array($result)) {
    $CF = $row['CodiceFiscale'];
    $cognome = $row['Cognome'];
    $nome = $row['Nome'];
    echo "<option value='$CF'>$nome $cognome</option>";
    }
    ?>

    </select>
    <h4>Posto</h4>
    <select name="Posto" >
    <?php
    $IDSerata = $_GET["ID"];
    //LISTA POSTI LIBERI
    $assegnazioni = "SELECT * FROM POSTI WHERE IDPosto NOT IN (SELECT posto FROM ASSEGNAZIONI WHERE SERATA ='$IDSerata')";
    $risultati = @mysql_query($assegnazioni) or die(mysql_error());
    while ($row2 = mysql_fetch_array($risultati)) {
    $id = $row2['IDPosto'];
    $posto = $row2['Nome'];
    echo "<option value='$id'>$posto</option>";
    }
    ?>
    </select>
   
    </div>
    </div>
       <div class="modal-footer">
         <button type="button"  class="btn btn-primary" id="aggiungi">Aggiungi Spettatore</button>
         <button type="submit" class="btn btn-primary" id="saveChanges" name="saveChanges" onclick="top.location.href='prenotazione.php'">Save changes</button>
    </div>
    </div>
    </form>
    </div>    
    </div> 
            
    <div class="modal" id="modalSpettatore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" id="chiudiSpett"aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div id="CF">
        <form class="CF-form" action="prenotazione.php?ID=<?php echo $_GET["ID"]; ?>" method="post">
        <input type="text" class="form-control" id="CF" name="CF" placeholder="CF" autofocus maxlength="16" >
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
        <input type="text" class="form-control" id="cognome" name="cognome" placeholder="Cognome">
        <button type="submit" class="btn btn-primary btn-sm" id="newSpettatore" name="newSpettatore" onclick="top.location.href='prenotazione.php'">Invia</button>    
    </form>

    </div>
    </div>
    </div>
    </div>

    </div>
    <?php 
        }
        ?>

    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
             //la prenotazione quando carico la pagina non si deve vedere
            $(document).ready(function () {
                $('#modalPrenot').hide();
                //quando carico la pagina la parte spettatore non si deve vedere
                $('#modalSpettatore').hide();
            });
                       
            //bottone aggiungi prenotazione, tutto per fare l'effetto grafico
            var bottoneADD = document.getElementById("add");
            bottoneADD.onclick = bottoneADD.style.marginLeft = "65%";
            bottoneADD.onmouseover = function () {
                bottoneADD.style.backgroundColor = "#009688";
                bottoneADD.innerHTML = "";
                bottoneADD.style.width = "150px";
                setTimeout(scritta, 500);
            };

            function scritta() {
                bottoneADD.innerHTML = "Aggiungi Prenotazione";
            }
            
            
            //serve al bottone sotto ogni serata per il redirect
            function redirect(id) {
                window.location.href = "Index.php?ID=" + id;
            }
            
            //il bottone add mi apre il modal della prenotazione
            $('#add').click(function () {
                $('#modalPrenot').show();
                
            });

            //la x mi deve chiudere il modal della prenotazione
            $(document).ready(function () {
                $('#btn1').click(function () {
                    $('#modalPrenot').hide();
                    
                });
            });
            
            //quando clicco il bottone aggiungi spettatore, mi mostra il modalspettatore e nasconde modalprenotazione
            $(document).ready(function () {
                $('#aggiungi').click(function(){
                    $('#modalPrenot').hide();
                    $('#modalSpettatore').show();
             });
            });
            
            
            //la x mi deve chiudere il modal dello spettatore
            var chiudiSpett = document.getElementById("chiudiSpett");
            chiudiSpett.onclick = function(){
                  $('#modalSpettatore').hide(); 
                };
            
            
            
    </script>
        
    </body>
    </html>