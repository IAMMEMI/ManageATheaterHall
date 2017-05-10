<?php session_start();
@include "config.php";
unset($_SESSION['login_utente']);
unset($_SESSION['login_admin']);
session_destroy();
header("location: LoginPage.php");
?>