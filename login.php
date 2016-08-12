<?php 

require_once "conexion.php"; 

$usuario = mysql_escape_string(stripslashes(trim($_POST['usuario'])));

$password = mysql_escape_string(stripslashes(trim($_POST['password'])));


$qrLogin = mysql_query("SELECT * FROM usuario WHERE estado = 0 AND usuario = '$usuario' AND password = '$password'") or die(mysql_error());

if ($rowsLogin = mysql_fetch_array($qrLogin)) {

	ini_set("session.cookie_lifetime","7200");
	ini_set("session.gc_maxlifetime","7200");
	// each client should remember their session id for EXACTLY 1 hour
	session_set_cookie_params(7200);

	session_start();	

	$_SESSION['id'] = $rowsLogin['id'];
	$_SESSION['nombres'] = $rowsLogin['nombres'];
	$_SESSION['perfil'] = $rowsLogin['codigo_perfil'];

	$_SESSION["ultimoAcceso"]= date("Y-m-d H:i:s"); 
	$_SESSION['start'] = time(); // Taking now logged in time.
	
    // Ending a session in 30 minutes from the starting time.
    $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
	

	header("location:panel.php");

}else{

	header("location:index.php?err=1");

}

?>