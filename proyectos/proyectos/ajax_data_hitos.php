<? 	//header('Content-type: text/html; charset=iso-8859-1');

	session_start();

	include "../../conexion.php";

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array



	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	

	if($_GET['pagesize'] != 1):

		$litmit = " LIMIT $start, $pagesize";

	else:

		$litmit = " ";

		$pagenum  = 1;

		$start = 1;

	endif;

	

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM hitos WHERE id_proyecto = ".$_GET['idproyecto']." AND estado != 'ELIMINADO' ".$litmit ;

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
					
					case "id_proyecto":
						$sql4 = "SELECT id
								 FROM proyectos
								 WHERE id_proyecto = ".$_GET['idproyecto']." AND nombre LIKE '%".strtoupper($_GET["filtervalue" . $i])."%'";

        				$pai4 = mysql_query($sql4); 
						$total_rows2 = mysql_num_rows($pai4);

						if($total_rows2 == 0){
							$data[] = array(
								'TotalRows' => $total_rows2,
								'Rows' => NULL
							);
							echo json_encode($data);
							exit;
						}

						$filtervalue = '';
						$i2=0;

						while($rs_pai4 = mysql_fetch_assoc($pai4)):

							if($i2==0):
								$id_proyectos .= ' AND id_proyecto = '.$rs_pai4['id'];
								$i2++;
							else:
								$id_proyectos .= ' OR id_proyecto = '.$rs_pai4['id'];
							endif;
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

					$where .= ") AND id_proyecto = ".$_GET['idproyecto']." AND estado != 'ELIMINADO' ".$id_proyectos;

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM hitos ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM hitos ".$where." ".$litmit ;		

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

					$query = "SELECT * FROM hitos WHERE id_proyecto = ".$_GET['idproyecto']." AND estado != 'ELIMINADO' ORDER BY" . " " . $sortfield . " DESC ".$litmit;

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM hitos WHERE id_proyecto = ".$_GET['idproyecto']." AND estado != 'ELIMINADO' ORDER BY" . " " . $sortfield . " ASC ".$litmit;

				}

			}

			else

			{

				if ($sortorder == "desc")

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " DESC ".$litmit;

				}

				else if ($sortorder == "asc")	

				{

					$filterquery .= " ORDER BY" . " " . $sortfield . " ASC ".$litmit;

				}

				$query = $filterquery;

			}		

		}
	}

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$orders = null;
	
	$obj = new TaskCurrent;
	// get data and store in a json array

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		/*$sqlfgr = "select estado from hitos where id = ".$row['id'];
		$paifgr = mysql_query($sqlfgr); 
		$rs_paifgr = mysql_fetch_assoc($paifgr);
		
		if($rs_paifgr['estado'] != 'ELIMINADO') {*/
		
			$sqlih = "	SELECT COUNT(*) AS total, a.estado AS estado_anticipo
						FROM items_anticipo AS ia
						LEFT JOIN anticipo AS a ON a.id = ia.id_anticipo
						WHERE a.estado != 4 AND ia.estado !=0 AND ia.id_hitos = ".$row['id'];
			$paiih = mysql_query($sqlih);			
			$rowih = mysql_fetch_assoc($paiih);
			
			if($rowih['total'] > 0):
				$anticpos = '&nbsp;<a href="javascript: fn_veranticipos('.$row['id'].');"  title="Anticipo amarrado"><img src="https://cdn2.iconfinder.com/data/icons/circular%20icons/warning.png" /></a>';
			else:
				$anticpos =  '';
			endif; 
		
			$sql2 = "SELECT nombre FROM proyectos WHERE id = ".$row['id_proyecto'];
			$pai2 = mysql_query($sql2); 
			$rs_pai2 = mysql_fetch_assoc($pai2);
	
			
			$unlimited = '';
			if($_SESSION['perfil'] == 5):
				if($row['ilimitado'] == 0): 
					$unlimited = '&nbsp;<a href="javascript: fn_unlockhito('.$row['id'].');"><img src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/Lock.png" /></a>';
				else:
					$unlimited = '&nbsp;<a href="javascript: fn_lockhito('.$row['id'].');"><img src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/Unlock.png" /></a>';
				endif;
			endif;
						
			//Obtener el adicion cotizado del hito	
			$adicionCotizado = $obj->getAdicionCotizado($row['id_ps_state'],$row['id']);	
			
			$customers[] = array(
	 
				'id' => $row['id'],
				'id_proyecto' => $rs_pai2['nombre'],
				'nombre' => utf8_encode($row['nombre']),
				'estado' => $row['estado'],
				'fecha_inicio' => $row['fecha_inicio'],
				'fecha_final' => $row['fecha_final'],
				'dias_hito' => $row['dias_hito'],
				'fecha_inicio_ejecucion' => $row['fecha_inicio_ejecucion'],
				'fecha_ejecutado' => $row['fecha_ejecutado'],
				'fecha_informe' => $row['fecha_informe'],
				'fecha_liquidacion' => $row['fecha_liquidacion'],
				'fecha_facturacion' => $row['fecha_facturacion'],
				'fecha_facturado' => $row['fecha_facturado'],
				'descripcion' =>  utf8_encode($row['descripcion']),
				'ot_cliente' => $row['ot_cliente'], 
				'po' => $row['po'], 
				'gr' => $row['gr'], 
				'factura' => $row['factura'], 
				'po2' => $row['po2'], 
				'gr2' => $row['gr2'], 
				'factura2' => $row['factura2'],
				'valor_cotizado_hito' => $row['valor_cotizado_hito'], 
				'adicion_cotizado' => $adicionCotizado, 
				'factor' => $row['factor'], 
			);
		  
		//}

	}

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);


   echo json_encode($data);

?>