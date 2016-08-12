<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['id_po']) || empty($_POST['id_proyecto'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$sql = sprintf("INSERT INTO `items_po` (id_proyecto, id_po) VALUES ('%s', '%s');",
		fn_filtro($_POST['id_proyecto']),
		fn_filtro($_POST['id_po'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar un nuevo item:\n$sql";
	exit;
?>