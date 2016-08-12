<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";
	session_start();

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array

	if(in_array(291,$_SESSION['permisos']))
		$estadosql = '1';
	else
		$estadosql = 'estado_registro = 0';

	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tecnico WHERE ".$estadosql." LIMIT $start, $pagesize";

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

					$where .= ")  AND estado_registro = 0";

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM tecnico ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM beneficiarios ".$where." LIMIT $start, $pagesize";		

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

					$query = "SELECT * FROM tecnico  WHERE estado_registro = 0 ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM tecnico  WHERE estado_registro = 0 ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

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
	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		switch($row['estado']):
		
			case 1:
				$activo = 'Activo';
			break;
			case 0:
				$activo = 'Inactivo';
			break;
			case 2:
				$activo = 'Vacaciones';
			break;
			case 3:
				$activo = 'Incapacitado';
			break;
			case 4:
				$activo = 'Operando';
			break;
		endswitch;
		
		if(in_array(291,$_SESSION['permisos'])){
			$eliminar = '&nbsp;<a href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
			if($row['estado_registro']==1)
				$activo = 'ELIMINADO';
		}else
			$eliminar = '';

		$customers[] = array(

			'id' => $row['id'],

			'nombre' => utf8_encode($row['nombre']),

			'cedula' => $row['cedula'],

			'arp' => $row['ARP'],

			'eps' => $row['EPS'],

			'celular' => $row['celular'],
			
			'estado' => $activo,

			'region' => $row['region'],

			'cargo' => utf8_encode($row['cargo']),
			
			'sueldo' => '$'.$row['sueldo'],
			
			'valor_plan' => '$'.$row['valor_plan'],

			'valor_hora' => '$'.$row['valor_hora'],
			
			'fecha_creacion' => $row['fecha_creacion'],

			'acciones' => '<a href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="../extras/ico/page_edit.png" /></a>&nbsp;<a href="javascript: fn_reporte('.$row['id'].');"><img src="https://cdn1.iconfinder.com/data/icons/fatcow/16x16_0740/report_user.png" /></a>'.$eliminar

		  );

	}

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);

	echo json_encode($data);

?>