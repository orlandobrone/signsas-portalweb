<?php

	include "../../conexion.php";

	session_start();

	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "	SELECT SQL_CALC_FOUND_ROWS *, i.id AS ID, h.estado AS estado_hito FROM items_anticipo AS i

				LEFT JOIN hitos AS h ON  h.id = i.id_hitos

			  	WHERE i.id_anticipo = ".$_GET['id']." AND i.estado IN (1,2)";

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

			$query = "SELECT * FROM items_anticipo ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM items_anticipo ".$where;		

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

					$query = "SELECT *, i.id AS ID, i.id_hitos AS idHitos, i.estado AS estado_anti, h.estado AS estado_hito
							  
							  FROM items_anticipo AS i

							  LEFT JOIN hitos AS h ON  h.id = i.id_hitos 

							  WHERE i.id_anticipo = ".$_GET['id']." AND i.estado IN (1,2)

							  ORDER BY" . " " . $sortfield . " DESC ";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT *, i.id AS ID, i.id_hitos AS idHitos, i.estado AS estado_anti, h.estado AS estado_hito
					
							  FROM items_anticipo AS i
							  
							  LEFT JOIN hitos AS h ON  h.id = i.id_hitos 

							  WHERE i.id_anticipo = ".$_GET['id']." AND i.estado IN (1,2)

							  ORDER BY" . " " . $sortfield . " ASC ";

				}

			}
 
			else

			{

				if ($sortorder == "desc")

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " DESC ";

				}

				else if ($sortorder == "asc")	

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " ASC ";

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

	$obj = new TaskCurrent;	
	
	//echo $query; 

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$valor = substr($row['valor_hito'],0, -3);
		$valor_hito = str_replace($letters, $fruit, $valor);	 
		
		$costoCompra = $obj->getTotalCompraByhito($row['id_hitos']);
		$sumaTotal = $obj->getSumaTotalAnticipoByhito($row['id_hitos']);
		$costoVehiculos = $obj->getCostoVehiculoByhito($row['id_hitos']);
		$costo_manobra = $obj->getCostoManobraByhito($row['id_hitos']);
		
		if($row['estado_hito'] == 'FACTURADO')
			$valor_facturas = $obj->getValorFacturasByhito($row['id_hitos']);
		else
			$valor_facturas = 0;
		
		$valor_transporte = substr($row['valor_transporte'],0, -3);
		$valor_transporte = str_replace($letters, $fruit, $valor_transporte);
		
		$toes = substr($row['toes'],0, -3);
		$toes = str_replace($letters, $fruit, $toes);
		
		$acpm = substr($row['acpm'],0, -3);
		$acpm = str_replace($letters, $fruit, $acpm);
		
		$totalAnticipo = $valor_transporte + $toes + (int)$acpm;
		
		if($row['estado'] == 1 || $row['estado'] == 2):
			if($_SESSION["perfil"] == 5)
				$eliminar = '<a href="javascript: fn_eliminar_item('.$row['ID'].','.$_GET['id'].');"><img src="../extras/ico/delete.png" /></a>';
			else 
				$eliminar = '';
		elseif($_GET['prioridad'] != 'GIRADO'):
			$eliminar = '<a href="javascript: fn_eliminar_item('.$row['ID'].','.$_GET['id'].');"><img src="../extras/ico/delete.png" /></a>';
		else:
			$eliminar = '';
		endif;
			
		$customers[] = array( 

			'i.id'=>$row['ID'],

			'idHitos'=>$row['id_hitos'],

			'id_hitos'=>utf8_encode($row['nombre']),
			
			'total_hito'=>$row['total_hito'],

            'valor_hito'=>$row['valor_hito'],
			
			'valor_cotizado_hito'=>$row['valor_cotizado_hito'], 
			
			'anticipos_anteriores'=>$sumaTotal,	
			
			'costo_compra' => $costoCompra,
			
			'costo_vehiculos'=>$costoVehiculos,
			
			'costo_manobra' =>$costo_manobra,

			'total_costo' => (int)$costoVehiculos + (int)$costo_manobra + $row['valor_hito'] + $costoCompra + $sumaTotal,
			
			'cant_galones'=>$row['cant_galones'],
			'valor_galon'=>$row['valor_galon'],
			'acpm'=>$acpm,
			
			'valor_transporte'=>$valor_transporte,
			'toes'=>$toes,
			'acciones' => $eliminar,
			'estado' => $_SESSION["perfil"],
			'estado_hito' => $row['estado_hito'],
			'total_anticipo' => $totalAnticipo,
			'valor_facturas' => $valor_facturas
		  );

	}

    $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $customers
	);

	echo json_encode($data);