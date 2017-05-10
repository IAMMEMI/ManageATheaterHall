<?php
 @include "config.php";

    if (isset($_POST['login-button']))
    {
       
    $user=$_POST['user'];
    $pw=$_POST['psw'];
    $query = "select * from utenti where utenti.Username='$user' and utenti.Password='$pw'";
    $result = mysql_query($query) or die (mysql_error());
    $row = mysql_num_rows($result);
    if($row == 1){
    session_start();
    $_SESSION['login_utente']= $user; 
    redirect();
    } else {
        $query = "select * from amministratori where Username='$user' and Password='$pw'";
    	$result = mysql_query($query) or die (mysql_error());
    	$row = mysql_num_rows($result);
    	if($row == 1){
    	session_start();
   		$_SESSION['login_admin']= $user;
        redirect();
    } else{
		$newpage = "LoginPage.php?type=login";
		header("Location:".$newpage);
		} 
  	}
}

function redirect(){
$newpage = "Index.php";
		header("Location:".$newpage);
}
?>


