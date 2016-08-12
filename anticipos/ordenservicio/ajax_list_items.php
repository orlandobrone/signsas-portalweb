<?php

	include "../../conexion.php";

	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "	SELECT SQL_CALC_FOUND_ROWS *, i.id AS ID, h.estado AS estado_hito, i.descripcion AS descripcion_os
				FROM items_ordenservicio AS i
				LEFT JOIN hitos AS h ON  h.id = i.id_hitos
			  	WHERE i.id_ordenservicio = ".$_GET['id']." AND i.estado IN(0,2) LIMIT $start, $pagesize";

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

			$where = " AND (";

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

					$where .= ") AND i.estado = 1";

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM items_ordenservicio ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM items_anticipo ".$where." LIMIT $start, $pagesize";		

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
					//consulta items_ordenservicio,orden_servicio,centros_costos Milena

					$query = "SELECT *, i.id AS ID, i.id_hitos AS idHitos, i.estado AS estado_anti, h.estado AS estado_hito, i.descripcion AS descripcion_os, h.nombre AS nombre_hito
					
							  FROM items_ordenservicio AS i
							  
							  LEFT JOIN hitos AS h ON  h.id = i.id_hitos 

							  WHERE i.id_ordenservicio = ".$_GET['id']." AND i.estado IN(0,2)

							  ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
							  
							 
							  /// original tatan

//SELECT *, i.id AS ID, i.id_hitos AS idHitos, i.estado AS estado_anti, h.estado AS estado_hito, i.descripcion AS descripcion_os
							  
			//				  FROM items_ordenservicio AS i

				//			  LEFT JOIN hitos AS h ON  h.id = i.id_hitos 

					//		  WHERE i.id_ordenservicio = ".$_GET['id']." AND i.estado = 0

						//	  ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize




				}

				else if ($sortorder == "asc")




				{

					$query = "SELECT *, i.id AS ID, i.id_hitos AS idHitos, i.estado AS estado_anti, h.estado AS estado_hito, i.descripcion AS descripcion_os
					
							  FROM items_ordenservicio AS i
							  
							  LEFT JOIN hitos AS h ON  h.id = i.id_hitos 

							  WHERE i.id_ordenservicio = ".$_GET['id']." AND i.estado IN(0,2)

							  ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

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

	

	//print_r($row = mysql_fetch_array($result, MYSQL_ASSOC));

	// get data and store in a json array

	$letters = array('.','$');
	$fruit   = array('');
	

	//$obj = new TaskCurrent;	
	//echo $query;

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {		
		
		
		$eliminar = '<a href="javascript: fn_eliminar_item('.$row['ID'].','.$_GET['id'].');"><img src="../extras/ico/delete.png" /></a>';
			
		$customers[] = array( 

			'i.id'=>$row['ID'],
			'idHitos'=>$row['id_hitos'],			
			'id_hitos'=>utf8_encode($row['nombre_hito']),
			'po_ticket'=>utf8_encode($row['po_ticket']),
			
			'descripcion'=>utf8_encode($row['descripcion_os']),
			'cantidad'=>$row['cantidad'],
			'valor_unitario'=>$row['valor_unitario'],
			'total'=>$row['total'],
			'forma_pago'=>utf8_encode($row['forma_pago']),
						
			'acciones' => $eliminar
		  );

	}

    $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $customers
	);
	
	/*echo '<pre>';
		print_r($data);
	echo '</pre>';*/

	echo json_encode($data);