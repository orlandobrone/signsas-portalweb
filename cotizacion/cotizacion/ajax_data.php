<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array



	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM cotizacion WHERE state = 0 LIMIT $start, $pagesize";

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

					$where .= ") AND state = 0 ".$materiales;

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM cotizacion ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM cotizacion ".$where." LIMIT $start, $pagesize";		

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

					$query = "SELECT * FROM cotizacion WHERE state = 0 ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM cotizacion WHERE state = 0 ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

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

	//<a href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="../extras/ico/page_edit.png" /></a>&nbsp;

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$data = costoReal($row['id']);
		$ventaTotal = $data['ventaTotal'];
		$costoTotal = $data['costoTotal'];
		
		$eliminar = '&nbsp;<a href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';	

		$customers[] = array(
			'id' => $row['id'],
			'nombre' => $row['nombre'],
			'descripcion' => $row['descripcion'],
			'ventaTotal' => $ventaTotal,
			'costoTotal' => $costoTotal,
			'ganancia_adicional' => $row['ganancia_adicional'],			
			'acciones' => '<a href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="../extras/ico/page_edit.png" /></a>'.$eliminar
		  );

	}

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);

	echo json_encode($data);
	
	
	
function costoReal($proyecto){		

	

	if ($proyecto != '*' && $proyecto != ''):

		$sql = "SELECT *
				FROM cotizacion 
				WHERE id = {$proyecto} ";
		$qrCostos = mysql_query($sql); 
		$rowsCostos = mysql_fetch_array($qrCostos);
		$vowels = array(",");	

	   /* $nombreProyecto = $rowsCostos['nombre'];
	    $costoReal = (int)$rowsCostos['SumaTotal'];
		$descriptionProyect = $rowsCostos['description'];*/


	    $costoPresu =       + (int)str_replace($vowels, "", $rowsCostos['transportes'])

							+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos'])

							+ (int)str_replace($vowels, "", $rowsCostos['imprevistos'])

							+ (int)str_replace($vowels, "", $rowsCostos['ica'] )

							+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero']) 

							+ (int)str_replace($vowels, "", $rowsCostos['acarreos'] )							

							+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos'] )

							+ (int)str_replace($vowels, "", $rowsCostos['reparaciones'])

							+ (int)str_replace($vowels, "", $rowsCostos['profesionales'])

							+ (int)str_replace($vowels, "", $rowsCostos['seguros'])

							+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular'])

							+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia'])

							+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica'])

							+ (int)str_replace($vowels, "", $rowsCostos['envios_correos'])

							+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios'])

							+ (int)str_replace($vowels, "", $rowsCostos['combustible'])

							+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo'])

							+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje'])

							+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos'])

							+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria'])

							+ (int)str_replace($vowels, "", $rowsCostos['papeleria'])

							+ (int)str_replace($vowels, "", $rowsCostos['internet'])

							+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses'])

							+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos'])

							+ (int)str_replace($vowels, "", $rowsCostos['caja_menor'])

							+ (int)str_replace($vowels, "", $rowsCostos['peajes'])

							+ (int)str_replace($vowels, "", $rowsCostos['polizas'])

							+ (int)str_replace($vowels, "", $rowsCostos['materiales'])	

							+ (int)str_replace($vowels, "", $rowsCostos['MOD'])	

			 				+ (int)str_replace($vowels, "", $rowsCostos['MOI'])	

							+ (int)str_replace($vowels, "", $rowsCostos['TOES']);

							

	  $ventaTotal   =       + (int)str_replace($vowels, "", $rowsCostos['transportes2'])

							+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos2'])

							+ (int)str_replace($vowels, "", $rowsCostos['imprevistos2'])

							+ (int)str_replace($vowels, "", $rowsCostos['ica2'] )

							+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero2']) 

							+ (int)str_replace($vowels, "", $rowsCostos['acarreos2'] )							

							+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos2'] )

							+ (int)str_replace($vowels, "", $rowsCostos['reparaciones2'])

							+ (int)str_replace($vowels, "", $rowsCostos['profesionales2'])

							+ (int)str_replace($vowels, "", $rowsCostos['seguros2'])

							+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular2'])

							+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia2'])

							+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica2'])

							+ (int)str_replace($vowels, "", $rowsCostos['envios_correos2'])

							+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios2'])

							+ (int)str_replace($vowels, "", $rowsCostos['combustible2'])

							+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo2'])

							+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje2'])

							+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos2'])

							+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria2'])

							+ (int)str_replace($vowels, "", $rowsCostos['papeleria2'])

							+ (int)str_replace($vowels, "", $rowsCostos['internet2'])

							+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses2'])

							+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos2'])

							+ (int)str_replace($vowels, "", $rowsCostos['caja_menor2'])

							+ (int)str_replace($vowels, "", $rowsCostos['peajes2'])

							+ (int)str_replace($vowels, "", $rowsCostos['polizas2'])

							+ (int)str_replace($vowels, "", $rowsCostos['materiales2'])	

							+ (int)str_replace($vowels, "", $rowsCostos['MOD2'])	

			 				+ (int)str_replace($vowels, "", $rowsCostos['MOI2'])	

							+ (int)str_replace($vowels, "", $rowsCostos['TOES2']);

		

	endif;
	
	return $arrayData = array('costoTotal' =>$costoPresu, 'ventaTotal'=>$ventaTotal);

}

?>