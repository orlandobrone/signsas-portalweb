<?  header('Content-type: text/html; charset=iso-8859-1');
	session_start();
	include "../../conexion.php";

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array

	if($_SESSION['asignacion_eliminar']){
		$estado = '1';
	}
	else{
		$estado = 'estado = 0';
	}

	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM asignacion WHERE ".$estado." LIMIT $start, $pagesize";

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

	$rows = mysql_query($sql);

	$rows = mysql_fetch_assoc($rows);

	$total_rows = $rows['found_rows'];

	$filterquery = "";


	// filter data.

	if (isset($_GET['filterscount']))

	{

		$filterscount = $_GET['filterscount'];

		if ($filterscount > 0)

		{

			$where = " WHERE (";

			$tmpdatafield = "";

			$tmpfilteroperator = "";

		


			for ($i=0; $i < $filterscount; $i++)

		    {	

				// get the filter's value.

				$filtervalue = $_GET["filtervalue" . $i];

				// get the filter's condition.

				$filtercondition = $_GET["filtercondition" . $i];

				// get the filter's column.

				$filterdatafield = $_GET["filterdatafield" . $i];
				
				switch($_GET["filterdatafield" . $i]):
					
					case 'id_tecnico':
						
						$queryTec = "SELECT id FROM tecnico WHERE nombre LIKE '".strtoupper($_GET["filtervalue" . $i])."%'";
						$resultTec = mysql_query($queryTec) or die("SQL Error 1: " . mysql_error());
						$total_rows2 = mysql_num_rows($resultTec);
						
						if($total_rows2 == 0){
							$data[] = array(
								'TotalRows' => $total_rows2,
								'Rows' => NULL
							);
							echo json_encode($data);
							exit;
						}
						
						$orTecnicos = '';
						while($rowsTec = mysql_fetch_assoc($resultTec)):
							$orTecnicos .= " OR id_tecnico =".$rowsTec['id'];
						endwhile;
						
					break;	
				
				endswitch;




				

				// get the filter's operator.

				$filteroperator = $_GET["filteroperator" . $i];

				

				if ($tmpdatafield == "")

				{

					$tmpdatafield = $filterdatafield;			

				}

				else if ($tmpdatafield <> $filterdatafield)

				{

					$where .= ")AND(";

				}

				else if ($tmpdatafield == $filterdatafield)

				{

					if ($tmpfilteroperator == 0)

					{

						$where .= " AND ";

					}

					else $where .= " OR ";	

				}

				

				// build the "WHERE" clause depending on the filter's condition, value and datafield.

				switch($filtercondition)

				{

					case "NOT_EMPTY":

					case "NOT_NULL":

						$where .= " " . $filterdatafield . " NOT LIKE '" . "" ."'";

						break;

					case "EMPTY":

					case "NULL":

						$where .= " " . $filterdatafield . " LIKE '" . "" ."'";

						break;

					case "CONTAINS_CASE_SENSITIVE":

						$where .= " BINARY  " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";

						break;

					case "CONTAINS":

						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";

						break;

					case "DOES_NOT_CONTAIN_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";

						break;

					case "DOES_NOT_CONTAIN":

						$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";

						break;

					case "EQUAL_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " = '" . $filtervalue ."'";

						break;

					case "EQUAL":

						$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";

						break;

					case "NOT_EQUAL_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " <> '" . $filtervalue ."'";

						break;

					case "NOT_EQUAL":

						$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";

						break;

					case "GREATER_THAN":

						$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";

						break;

					case "LESS_THAN":

						$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";

						break;

					case "GREATER_THAN_OR_EQUAL":

						$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";

						break;

					case "LESS_THAN_OR_EQUAL":

						$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";

						break;

					case "STARTS_WITH_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
						break;

					case "STARTS_WITH":

						$where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";

						break;

					case "ENDS_WITH_CASE_SENSITIVE":

						$where .= " BINARY " . $filterdatafield . " LIKE '%" . $filtervalue ."'";

						break;

					case "ENDS_WITH":

						$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";

						break;
				}


				if ($i == $filterscount - 1)

				{

					$where .= ") AND ".$estado." ".$orTecnicos;

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM asignacion ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM asignacion ".$where." LIMIT $start, $pagesize";		

			$total_rows = $new_total_rows;	

		}

	}

	

	if (isset($_GET['sortdatafield']))

	{

	

		$sortfield = $_GET['sortdatafield'];

		$sortorder = $_GET['sortorder'];

		

		if ($sortorder != '')

		{

			if ($_GET['filterscount'] == 0)

			{

				if ($sortorder == "desc")

				{
					$query = "SELECT * FROM asignacion WHERE ".$estado." ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM asignacion WHERE ".$estado." ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

				}

			}

			else

			{

				if ($sortorder == "desc")

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")	

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

				}

				$query = $filterquery;


			}		

		}

	}

	

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	$orders = null;

	// get data and store in a json array

	$obj = new TaskCurrent;

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		if($row['id_hito'] != 0):

			if($row['id_vehiculo'] != 0):
				
				$sql2 = "SELECT 

							h.nombre AS nombre_hitos, 	

							t.nombre AS nombre_tecnico,

							v.placa AS placa

						 FROM `hitos` AS h

						 INNER JOIN  tecnico AS t ON t.id = ".$row['id_tecnico']."

						 INNER JOIN  vehiculos AS v ON v.id = ".$row['id_vehiculo']."

						 WHERE h.id =".$row['id_hito'];

			else:

				$sql2 = "SELECT 

							h.nombre AS nombre_hitos,

							t.nombre AS nombre_tecnico

						 FROM `hitos` AS h

						 INNER JOIN  tecnico AS t ON t.id = ".$row['id_tecnico']."

						 WHERE h.id =".$row['id_hito'];

			endif;

		else:

			$sql2 = "SELECT nombre AS nombre_tecnico
					 FROM `tecnico` 
					 WHERE id =".$row['id_tecnico'];

		endif;

		

		//FGR desde acá

		$sql3 = "select orden_trabajo as OT from orden_trabajo where id_proyecto = ".$row['id_ordentrabajo'];
		$pai3 = mysql_query($sql3);
		$rs_pai3 = mysql_fetch_assoc($pai3);

		//FGR hasta acá

		//echo $sql2.'<br/>';
		$pai2 = mysql_query($sql2); 
		$rs_pai2 = mysql_fetch_assoc($pai2);

		if($row['hora_inicio'] == '00:00:00' && $row['hora_final'] == '00:00:00'):
			$hora_vehicular = 'N/A';
		else:
			$hora_vehicular = $row['hora_inicio'].' a '.$row['hora_final'];
		endif;
		
		
		$estadoLiquidado = $obj->isMayorLiquidadoByHito($row['id_hito']);
		
		if($estadoLiquidado == false)
			$eliminar = '&nbsp;<a href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
			
		elseif($obj->isActionDelModulo($row['id'],'Asignaciones')==true)
			$eliminar = '&nbsp;<a href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
		else
			$eliminar = '';
		
		if(in_array(3001,$_SESSION['permisos'])):
			$eliminar = '&nbsp;<a href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
			
			if($row['estado'] == 1):
				$row['libre'] = 'ELIMINADO';
			endif;
		else:
			$eliminar = '';
		endif;
	
		if($row['estado'] == 1)
			$estado = 'ELIMINADO';
		else
			$estado = 'ACTIVO';
		

		$customers[] = array(

			'id' => $row['id'],

			'id_hito' =>utf8_encode($rs_pai2['nombre_hitos']),

			'libre' => strtoupper($row['libre']),

			'id_tecnico' => utf8_encode($rs_pai2['nombre_tecnico']),

			'id_vehiculo' => $rs_pai2['placa'],

			'id_ordentrabajo' => $row['id_ordentrabajo']==0?'':$rs_pai3['OT'],

			'fecha_ini' =>  $row['fecha_ini'],

			'observacion' =>utf8_encode( $row['observacion'] ) ,

			'hora_vehicular' => $hora_vehicular,
			
			'horas_trabajadas' => $row['horas_trabajadas'],
			
			'estado' => $estado,

			'acciones' => '<a href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="../extras/ico/page_edit.png" /></a>'.$eliminar

		  );

	}

    $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $customers
	);

	echo json_encode($data);

?>