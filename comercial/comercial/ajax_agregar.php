<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['usuario']) || empty($_POST['cliente']) || empty($_POST['cotizacion']) || empty($_POST['otorgado'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$sql = sprintf("INSERT INTO `comercial` (id_cliente, id_usuario, id_cotizacion, otorgado) VALUES ('%s', '%s', '%s', '%s');",
		fn_filtro($_POST['cliente']),
		fn_filtro($_POST['usuario']),
		fn_filtro($_POST['cotizacion']),
		fn_filtro($_POST['otorgado'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar los datos de comercial:\n$sql";

	exit;
?>