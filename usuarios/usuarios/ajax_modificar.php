<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['usuario']) || empty($_POST['email']) || empty($_POST['codigo_perfil'])){

		echo "Usted no ha llenado todos los campos";

		exit;

	}

	

	/*modificar el registro*/

	

	if($_POST['confirmar'] != ''):

		$sql = sprintf("UPDATE usuario SET usuario='%s', password='%s', nombres='%s', codigo_perfil='%s', email='%s', id_regional='%s', estado=%d WHERE id=%d;",

			fn_filtro($_POST['usuario']),

			fn_filtro($_POST['password']),

			fn_filtro($_POST['nombres']),

			fn_filtro($_POST['codigo_perfil']),

			fn_filtro($_POST['email']),
 
			fn_filtro($_POST['jqxWidget']),
			
			fn_filtro($_POST['cambio_estado']),

			fn_filtro((int)$_POST['id'])

		);

	else:


		$sql = sprintf("UPDATE usuario SET usuario='%s', nombres='%s', codigo_perfil='%s', email='%s', id_regional='%s', estado=%d WHERE id=%d;",

			fn_filtro($_POST['usuario']),

			fn_filtro($_POST['nombres']),

			fn_filtro($_POST['codigo_perfil']),

			fn_filtro($_POST['email']),

			fn_filtro($_POST['jqxWidget']),
			
			fn_filtro($_POST['cambio_estado']),

			fn_filtro((int)$_POST['id'])

		);

	

	endif;



	if(!mysql_query($sql) or die(mysql_error()))
		echo "Error al actualizar el usuario:\n$sql";

	exit;

?>