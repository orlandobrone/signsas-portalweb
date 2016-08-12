<? header('Content-type: text/html; charset=iso-8859-1');

	session_start();
	
	include "../../conexion.php";

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array

	

	/*$sqlfgr = "select opcion as region from opciones_perfiles where id_perfil = ".$_SESSION['perfil']." and opcion > 100 order by id asc";

    $paifgr = mysql_query($sqlfgr);

	$filtroRegion = '';

	$filtroRegion2 = '';

	$cont=0;

	while($usuariofgr=mysql_fetch_assoc($paifgr)){

		if($cont==0){

			$filtroRegion .= ' (';

		}

		$filtroRegion .= ' s.id_regional='.substr($usuariofgr['region'], 2).' or';

		$cont++;

	}

	if($cont>0){

		$filtroRegion = substr($filtroRegion, 0, -2).') and';

		$filtroRegion2 = ' and'.$filtroRegion;

	}

	if($filtroRegion == '')

		$filtroRegion2 = ' and';*/



	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM inventario_acpm WHERE beneficiarios = '".$_GET['beneficiario']."' AND cant_galones > 0 AND estado != 1 LIMIT $start, $pagesize";

	$result = mysql_query($query) or die("SQL Error 10: ".$query. mysql_error());

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

					$where .= ") AND beneficiarios = '".$_GET['beneficiario']."' AND cant_galones > 0 AND estado != 1 ";

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM inventario_acpm ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 12: ".$query. mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM inventario_acpm ".$where." LIMIT $start, $pagesize";		

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

					$query = "SELECT * FROM inventario_acpm  WHERE beneficiarios = '".$_GET['beneficiario']."' AND cant_galones > 0 AND estado != 1 ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM inventario_acpm  WHERE beneficiarios = '".$_GET['beneficiario']."' AND cant_galones > 0 AND estado != 1 ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

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

	

	$result = mysql_query($query) or die("SQL Error 18: ".$query. mysql_error());

	// get data and store in a json array
	$letters = array('.','$',',');
	$fruit   = array('');

	//echo $query;

	$obj = new TaskCurrent;
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$sql2 = "SELECT id, 
				 (SELECT valor FROM prestaciones WHERE id = ".$row['id_prestaciones'].") AS codigo,
				 (SELECT region FROM regional WHERE id = ".$row['id_regional'].") AS region,
				 (SELECT name FROM ps_state WHERE id = ".$row['id_ps_state'].") AS departamento
				 FROM hitos WHERE id = ".$row['id_hito'];
		$per2 = mysql_query($sql2);
		$rs_per2 = mysql_fetch_assoc($per2);
		
		$array = $obj->getPromedioTotalGalByID($row['id']);
		
		if($array['total_gal'] > 0):
			$customers[] = array(
				'id' => $row['id'],
				'id_prestaciones' => $rs_per2['codigo'],
				'id_regional' => $rs_per2['region'],
				'beneficiarios' => utf8_encode($row['beneficiarios']),
				'descripcion' => 'Reintegro de ACPM',
				'cant_galones' => $array['total_gal'],
				'costo_unitario' => $row['costo_unitario'],
				'id_ps_state' => utf8_encode($rs_per2['departamento']),
				'id_hito' => $row['id_hito'],
				'id_anticipo' => $row['id_anticipo'],
				'fecha_registro' => $row['fecha_registro'],
				'cant_salida_gal' => 0		
			);
		endif; 

	}

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);

	echo json_encode($data);

?>