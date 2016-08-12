<?

	include "../../conexion.php";

	include "../../funciones.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['concepto'])){

		echo "Usted no ha llenado todos los campos";

		exit;

	}

	

	

	$sql = sprintf("UPDATE prestaciones SET concepto='%s', valor='%s' where id=%d;", 

		fn_filtro($_POST['concepto']),

		fn_filtro(str_replace(",","",$_POST['valor'])),

		fn_filtro((int)$_POST['id'])

	);

	if(!mysql_query($sql)):

		echo "Error al actualizar el concepto:\n$sql";

	endif;

	exit;

?>