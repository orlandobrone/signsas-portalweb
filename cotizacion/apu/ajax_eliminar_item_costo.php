<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	$sql = sprintf("DELETE FROM apu_costos WHERE id=%d",

		(int)$_POST['id']

	);

	if(!mysql_query($sql))
		echo json_encode(array('estado'=>false, 'message'=>"Error al eliminar el APU:\n$sql"));

	exit;

?>