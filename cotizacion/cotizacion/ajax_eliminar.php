<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	$sql = sprintf("UPDATE cotizacion SET state = 1 WHERE id=%d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql))

		echo "Ocurrio un error\n$sql";

	exit;

?>