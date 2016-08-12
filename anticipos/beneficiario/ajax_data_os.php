<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;
	
	if(in_array(401,$_SESSION['permisos']))
		$whereE = " AND estado NOT IN('draft') AND cedula_contratista = '".$_GET['identificacion']."'";
	else
		$whereE = " AND estado NOT IN('draft','ELIMINADO') AND cedula_contratista = '".$_GET['identificacion']."'";
	

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM orden_servicio WHERE 1 ".$whereE."  LIMIT $start, $pagesize";

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

					$where .= ") ".$whereE." ";

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM orden_servicio ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM orden_servicio ".$where." LIMIT $start, $pagesize";		

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

					$query = "SELECT * FROM orden_servicio WHERE 1 ".$whereE." ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM orden_servicio WHERE 1 ".$whereE." ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";

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

	//echo $query;

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	$obj = new TaskCurrent;

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$aprobar = '';
		if($row['aprobado'] == 0):
			if(in_array(404, $_SESSION['permisos'])):
				$aprobar = '<a href="javascript:" value="'.$row['id'].'" class="aprobar_os"><img src="https://cdn2.iconfinder.com/data/icons/color-svg-vector-icons-part-2/512/ok_check_yes_tick_accept_success-16.png" /></a>';
			endif;
			if(in_array(401, $_SESSION['permisos'])):
				$eliminar = '<a href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
			endif;
		endif;
		
		
		//Centro de costos
		$sql2 = "SELECT nombre, codigo 
				 FROM linea_negocio
				 WHERE id = ".$row['id_centroscostos'];
		$result2 = mysql_query($sql2) or die("SQL Error 1: " . mysql_error());
		$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
		
		//OT
		$sql3 = "SELECT nombre
				 FROM `proyectos`
				 WHERE `id` = ".$row['id_ordentrabajo'];
		$result3 = mysql_query($sql3) or die("SQL Error 1: " . mysql_error());
		$row3 = mysql_fetch_array($result3, MYSQL_ASSOC);
		
		//regional 
		$sql4 = "SELECT region
				FROM `regional`
				WHERE `id` = ".$row['id_regional'];
		$result4 = mysql_query($sql4) or die("SQL Error 1: " . mysql_error());
		$row4 = mysql_fetch_array($result4, MYSQL_ASSOC);
		
		//Valida si la os tiene anticipos
		$pitagora = '';
		if($obj->getValidateAnticiposByOS($row['id']))
			$pitagora = '&nbsp;<a href="javascript: fn_viewanticipos('.$row['id'].');"><img src="https://cdn0.iconfinder.com/data/icons/news-and-magazine/512/categories-16.png" /></a>';
		
		$customers[] = array(

			'id' => $row['id'],
			'fecha_create' => $row['fecha_create'],
			'fecha_inicio' => $row['fecha_inicio'],
			'fecha_terminado' => $row['fecha_terminado'],
			
			'valor_total' => $obj->getTotalSumItemsOS($row['id']),
			
			'estado' => $obj->getEstadoOS($row['aprobado']),
			
			'id_regional' => $row4['region'],			
			'nombre_responsable' => utf8_encode($row['nombre_responsable']),
			'cedula_responsable' => $row['cedula_responsable'],
			
			'id_centroscostos' => $row2['codigo'].'-'.$row2['nombre'],
			'id_ordentrabajo' => $row3['nombre'],
			
			'nombre_contratista' =>  utf8_encode($row['nombre_contratista']),			
			'telefono_contratista' => $row['telefono_contratista'],
			'cedula_contratista' => $row['cedula_contratista'],
			'regimen_contratista' => $row['regimen_contratista'],
			'correo_contratista' => $row['correo_contratista'],
			'poliza_contratista' => $row['poliza_contratista'],	
			'direccion_contratista' => $row['direccion_contratista'],		
			
			'acciones' => '<a href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="../extras/ico/page_edit.png" /></a>&nbsp;'.$eliminar.'<a href="javascript:" value="'.$row['id'].'" class="excelExport2"><img src="https://cdn2.iconfinder.com/data/icons/ledicons/doc_pdf.png" /></a>&nbsp;'.$aprobar.''.$pitagora

		  );

	}

    $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $customers
	);

	echo json_encode($data);

?>