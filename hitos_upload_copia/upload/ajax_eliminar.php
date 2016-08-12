<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	echo $sql = sprintf("delete from valor_acpm where id=%d", 

		(int)$_POST['id']

	);

	if(!mysql_query($sql))

		echo "Ocurrio un error\n$sql";

	exit; 

?>