<? header('Content-type: text/html; charset=iso-8859-1');
	session_start();
	include "../../conexion.php";

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array



	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM documental WHERE estado IN(0,2) LIMIT $start, $pagesize";

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

					$where .= ") AND estado IN(0,2) ";

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM documental ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM documental ".$where." LIMIT $start, $pagesize";		

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

					$query = "SELECT * FROM documental WHERE estado IN(0,2) ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM documental WHERE estado IN(0,2) ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

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
	/*echo '<pre>';
		print_r($_SESSION['permisos']);
	echo '</pre>';*/
	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$upload_dir = 'uploads/'.$row['id'].'/';
		
		$query2 = "SELECT * FROM documental_items WHERE documental_id = ".$row['id'];
		$result2 = mysql_query($query2);
		
		$fotos = ''; $excel = ''; $pdf = ''; $word = ''; $power = ''; $cad = '';	
		
		while ( $rows =  mysql_fetch_array($result2, MYSQL_ASSOC) ):
			
			switch($rows['tipo_archivo']):
				
				case 'jpg':
				case 'png':
				case 'gif':
				case 'jpeg':
					$fotos .= '<a target="_blank" href="'.$upload_dir.$rows['nombre_archivo'].'">Ver</a> -'; 
				break;
				
				case 'xls':
				case 'xlsx':
					$excel .= '<a target="_blank" href="'.$upload_dir.$rows['nombre_archivo'].'">Bajar</a> -'; 
				break;
				
				case 'pdf':
					$pdf .= '<a target="_blank" href="'.$upload_dir.$rows['nombre_archivo'].'">Ver</a> -'; 
				break;
				
				case 'doc':
				case 'docx':
					$word .= '<a target="_blank" href="'.$upload_dir.$rows['nombre_archivo'].'">Bajar</a> -'; 
				break;
				
				case 'ppt':
				case 'pptx':
					$power .= '<a target="_blank" href="'.$upload_dir.$rows['nombre_archivo'].'">Bajar</a> -'; 
				break;	
				
				case 'dwg':
					$cad .= '<a target="_blank" href="'.$upload_dir.$rows['nombre_archivo'].'">Bajar</a> -';
				break;			
			endswitch;
			
		endwhile;
		
		switch($row['estado']):
			case 0:
				$estado = 'Creado';
			break;
			case 1:
				$estado = 'Eliminado';
			break;
			case 2:
				$estado = 'Aprobado';
			break;
		endswitch;
		
		if (in_array('362', $_SESSION['permisos']) && $row['estado'] == 0)
			$eliminar = '&nbsp;<a href="javascript: fn_noeliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
		else
			$eliminar = '';
			
		//if (in_array('361', $_SESSION['permisos']) && $row['estado'] == 0)
			$modificar = '<a href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="../extras/ico/page_edit.png" /></a>';
		/*else
			$modificar = '';*/
			
		if (in_array('363', $_SESSION['permisos']) && $row['estado'] == 0)
			$aprobar = '&nbsp;<a href="javascript: fn_mostrar_frm_aprobar('.$row['id'].');"><img src="https://cdn2.iconfinder.com/data/icons/color-svg-vector-icons-part-2/512/ok_check_yes_tick_accept_success-16.png" /></a>';
		else
			$aprobar = '';

		$customers[] = array(

			'id' => $row['id'],
			'fecha_creacion' => $row['fecha_creacion'],
			'codigo_sitio' =>$row['codigo_sitio'],
			'actividad' => utf8_encode($row['actividad']),
			'nombre_sitio' => utf8_encode($row['nombre_sitio']),
			'cliente' => utf8_encode($row['cliente']),
			'ot_tickets' => $row['ot_tickets'],
			'nombre_documentador' => $row['nombre_documentador'],
			'fecha_ejecucion_editable' => $row['fecha_ejecucion_editable'],
			'detalle_actividad' => $row['detalle_actividad'],
			'hito_id' => $row['hito_id'],
			'estado' => $estado,
			
			'fotos' => $fotos,
			'pdf' => $pdf,
			'word' => $word,
			'excel' => $excel,
			'powerpoint' => $power,
			'autocad' => $cad,			

			'acciones' => $modificar.''.$eliminar.''.$aprobar
		);

	}

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);

	echo json_encode($data);

?>