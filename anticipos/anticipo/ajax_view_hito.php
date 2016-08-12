<?php
	
	header('Content-type: text/html; charset=iso-8859-1');
	
	include "../../conexion.php";

	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "	SELECT SQL_CALC_FOUND_ROWS *, ia.id AS ID
				FROM items_anticipo AS ia
				LEFT JOIN anticipo AS a ON ia.id_anticipo = a.id 
			  	WHERE a.estado != 4 AND ia.id_hitos = ".$_GET['idhito']." LIMIT $start, $pagesize";

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

					$where .= ") AND estado = 1";

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

			$query = "SELECT * FROM items_anticipo ".$where." LIMIT $start, $pagesize";		

			$total_rows = $new_total_rows;	

		}

	}

	

	if (isset($_GET['sortdatafield']))
	{

		$sortfield = $_GET['sortdatafield'];

		$sortorder = $_GET['sortorder'];
		/*
			SELECT SQL_CALC_FOUND_ROWS *
				FROM items_anticipo AS ia
				LEFT JOIN anticipo AS a ON ia.id_anticipo = a.id 
			  	WHERE a.estado != 4 AND ia.id_hitos = ".$_GET['idhito']." LIMIT $start, $pagesize";

		*/

		if ($sortorder != '')

		{

			if ($_GET['filterscount'] == 0)

			{

				if ($sortorder == "desc")
				{

					$query = "SELECT *, ia.id AS ID
							  FROM items_anticipo AS ia
							  LEFT JOIN anticipo AS a ON ia.id_anticipo = a.id 
							  WHERE a.estado != 4 AND ia.id_hitos = ".$_GET['idhito']."
							  ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
				}
				else if ($sortorder == "asc")
				{

					$query = "SELECT *, ia.id AS ID
							  FROM items_anticipo AS ia
							  LEFT JOIN anticipo AS a ON ia.id_anticipo = a.id 
							  WHERE a.estado != 4 AND ia.id_hitos = ".$_GET['idhito']."
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
	
	$obj = new TaskCurrent;	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$valor_transporte = substr($row['valor_transporte'],0, -3);
		$valor_transporte = str_replace($letters, $fruit, $valor_transporte);
		
		$toes = substr($row['toes'],0, -3);
		$toes = str_replace($letters, $fruit, $toes);
		
		$acpm = substr($row['acpm'],0, -3);
		$acpm = str_replace($letters, $fruit, $acpm);
		
		$total = $valor_transporte + $toes + $acpm;
		
		$menoGal = ($acpm < 0)? '-':'';
		
		
		//Obtiene los valores con impuestos
		$valueImp = $obj->getImpuestoByAnticipoItem($row['ID']);
		
		//sin impuestos
		$acpm = (is_array($valueImp['acpm']))?$valueImp['acpm']['valor_neto']:0;
		$transporte = (is_array($valueImp['transporte']))?$valueImp['transporte']['valor_neto']:0;
		$toes = (is_array($valueImp['toes']))?$valueImp['toes']['valor_neto']:0;
		$viaticos = (is_array($valueImp['viaticos']))?$valueImp['viaticos']['valor_neto']:0;
		$mular = (is_array($valueImp['mular']))?$valueImp['mular']['valor_neto']:0;
		$total = $transporte + $toes + $acpm + $viaticos + $mular;
			 
		
		$customers[] = array(
			'id_anticipo'=>$row['id_anticipo'],	
					
			'acpm'=>$acpm, //sin impuesto
			'valor_transporte'=>$transporte, //sin impuestos
			'toes'=>$toes,//sin impuestos
			'viaticos'=>$viaticos,//sin impuestos
			'mular'=>$mular,//sin impuestos
			
			'cant_galones'=>$menoGal.''.$row['cant_galones'],
			'valor_galon'=>$row['valor_galon'],
			'total' => $total
		);
	}

    $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $customers
	);

	echo json_encode($data);