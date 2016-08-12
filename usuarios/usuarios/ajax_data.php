<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

	#Include the connect.php file

	#Connect to the database

	//connection String	

	// get data and store in a json array

	if(in_array(121,$_SESSION['permisos']))
		$whereE = ' 1 ';
	else
		$whereE = ' estado IN(0) ';

	$pagenum = $_GET['pagenum'];

	$pagesize = $_GET['pagesize'];

	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ".$whereE." LIMIT $start, $pagesize";

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
				
				
				switch($_GET["filterdatafield" . $i]):
				
					case "id_regional":
						$sqlr = "SELECT id FROM regional WHERE region = '".$filtervalue."' LIMIT 1";
						$resultr = mysql_query($sqlr);
						$rowr = mysql_fetch_assoc($resultr);
						
						$filtervalue = $rowr['id'];
					break;
				endswitch;
				
			

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
					$where .= ") ";

				}

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT *, (SELECT region FROM regional WHERE id = id_regional) AS regional
					  FROM usuario AS u ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT *, (SELECT region FROM regional WHERE id = id_regional) AS regional FROM usuario ".$where." LIMIT $start, $pagesize";		

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

					$query = "SELECT *,(SELECT region FROM regional WHERE id = id_regional) AS regional
					          FROM usuario WHERE ".$whereE."
							  ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT *,(SELECT region FROM regional WHERE id = id_regional) AS regional
					 		  FROM usuario WHERE ".$whereE." 
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

	// get data and store in a json array

	//echo $sql;

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$resultado = mysql_query("SELECT nombre FROM perfiles WHERE id =".$row['codigo_perfil']) or die(mysql_error());
		$perfil = mysql_fetch_assoc($resultado);	
		
		$regional = explode(',',$row['id_regional']);
		
		$query2 = '';
		$regiones = '';
		
		if(count($regional) > 1):
			//print_r($regional);
			foreach($regional as $row2):
				$query2 .= ' id='.$row2.' OR';
			endforeach;		
			$query2 = substr($query2, 0,-2);//			
		else:
			$query2 = " id=".$row['id_regional'];
		endif;
		
		if(!empty($row['id_regional'])): 
			$sql4 = "SELECT region FROM regional WHERE ".$query2;
			$result2 = mysql_query($sql4) or die(mysql_error());
			while($rowg = mysql_fetch_assoc($result2)):
				$regiones .= $rowg['region'].','; 
			endwhile;
			$regiones = substr($regiones, 0,-1);//*/
		endif;
		
		$estado = 'Activo';
		if($row['estado'] == 1)
			$estado = 'Inactivo';
		
		$eliminar = '';
		if(in_array(121,$_SESSION['permisos']))
			$eliminar = '&nbsp;<a href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>';
		
		$customers[] = array(   'id' => $row['id'],
								'usuario' => $row['usuario'],
								'email' => $row['email'],
								'nombres' => utf8_encode($row['nombres']),
								'codigo_perfil' => utf8_encode($perfil['nombre']),
								'fecha' => $row['fecha'],
								'id_regional' => $regiones,
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