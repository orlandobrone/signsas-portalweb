<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['natjur']) || empty($_POST['nombre']) || empty($_POST['descri']) || empty($_POST['percon']) || empty($_POST['telefo']) || empty($_POST['celula']) || empty($_POST['email'])){

		echo "Usted no ha llenado todos los campos";

		exit;

	}

	

	/*modificar el registro*/



	$sql = sprintf("UPDATE cliente SET natural_juridico='%s', nombre='%s', descripcion='%s', persona_contacto='%s', telefono='%s', celular='%s', email='%s', suministro=%s, servicios=%s, otros_servicios=%s, dias_vencimiento_pago=%s, numero_amigable='%s' WHERE id=%d;",

		fn_filtro($_POST['natjur']),

		fn_filtro($_POST['nombre']),

		fn_filtro($_POST['descri']),

		fn_filtro($_POST['percon']),

		fn_filtro($_POST['telefo']),

		fn_filtro($_POST['celula']),

		fn_filtro($_POST['email']),
		
		fn_filtro($_POST['suministro']),
		
		fn_filtro($_POST['servicios']),
		
		fn_filtro($_POST['otros_servicios']),
		
		fn_filtro($_POST['dias_vencimiento_pago']),
		
		fn_filtro($_POST['numero_amigable']),

		fn_filtro((int)$_POST['id'])

	);

	if(!mysql_query($sql))

		echo "Error al actualizar el cliente:\n$sql";

	exit;

?>