<?

	include "../../conexion.php";

	

	$sqlPry = "SELECT * FROM tecnico"; 

	$qrPry = mysql_query($sqlPry);

	

	$optionT = '';

	

    while ($row = mysql_fetch_array($qrPry)):

						

		/*$sql = "	 SELECT COUNT(1) AS conteo FROM asignacion WHERE id_tecnico = ".$row['id']." 

					 AND ((fecha_ini >= '".$_POST['fechaini']."' AND fecha_ini <= '".$_POST['fechaend']."') 

					 OR (fecha_fin >= '".$_POST['fechaini']."' AND fecha_fin <= '".$_POST['fechaend']."') 

					 OR (fecha_ini <= '".$_POST['fechaini']."' AND fecha_fin >= '".$_POST['fechaend']."'))"; 

		

		$result = mysql_query($sql);

		$rows = mysql_fetch_array($result);*/

								

		//if($rows['conteo'] != 1):									
			$disabled = ($row['estado']!=1)? 'disabled':'';		
   			$optionT .= '<option value="'.$row['id'].'" '.$disabled.'>'.utf8_encode($row['nombre']).'</option>';

       //endif;                       			

                                

     endwhile;

	 

	 echo $optionT;

                    

	

	/*$usu_per = $_GET['nombre_material'];

	$sql = "select * from inventario where nombre_material='$usu_per'";

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if($num_rs_per == 0)

		echo "true";

	else

		echo "false";*/

?>