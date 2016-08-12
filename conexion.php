<?

	$bd_host = "localhost";
	$bd_usuario = "operacio_project";
	$bd_password = "Tft36ZBwi2qK"; 
	$bd_base = "operacio_project";
	/*$bd_host = "localhost";
	$bd_usuario = "root";
	$bd_password = "";
	$bd_base = "cesprovi_project";*/
	$con = mysql_connect($bd_host, $bd_usuario, $bd_password) or die("Error en la conexi?n a MsSql");
	mysql_select_db($bd_base, $con);
	
	if(session_id() == '') {
		session_start();
	}
		
	require_once('objetos/init.php'); 
	
?>