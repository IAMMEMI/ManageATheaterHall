<?php

session_start();
@include "config.php";
if(isset($_POST['newSpettatore'])){
        $CF = $_POST['CF'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $query = "INSERT INTO spettatori (CodiceFiscale, Nome, Cognome) VALUES ('$CF','$nome', '$cognome')";
        $result = mysql_query($query) or die(mysql_error());
        
        if($result){
            $newpage = "Index.php?ID=";
            $newpage.=$_GET["ID"];
            header("Location:".$newpage);
        }
}

if(isset($_POST['saveChanges'])){
    $spettatore = $_POST['Spettatore'];
    $posto = $_POST['Posto'];
    $id = $_GET["ID"];
    $query = "INSERT INTO assegnazioni (ID, Spettatore, Posto, Serata) VALUES(NULL, '$spettatore', '$posto', '$id')";
    $result = mysql_query($query) or die(mysql_error());
    
     if($result){
            $newpage = "Index.php?ID=";
            $newpage.=$id;
            header("Location:".$newpage);
        }
}
?>