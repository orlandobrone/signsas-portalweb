<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['usuario']) || empty($_POST['cliente']) || empty($_POST['cotizacion']) || empty($_POST['otorgado']) || empty($_POST['id'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	
	/*modificar el registro*/

	$sql = sprintf("UPDATE comercial SET id_usuario='%s', id_cliente='%s', id_cotizacion='%s', otorgado='%s' where id=%d;",
		fn_filtro($_POST['usuario']),
		fn_filtro($_POST['cliente']),
		fn_filtro($_POST['cotizacion']),
		fn_filtro($_POST['otorgado']),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar los datos de comercial:\n$sql";
	exit;
?>