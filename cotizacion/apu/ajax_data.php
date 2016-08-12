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

	$query = "SELECT SQL_CALC_FOUND_ROWS *

			  FROM apu 
			  
			  WHERE estado != 'draft'

			  LIMIT $start, $pagesize ";

			  

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

			$where = " WHERE ( ";

			$tmpdatafield = "";

			$tmpfilteroperator = "";

			for ($i=0; $i < $filterscount; $i++)

		    {

				

				$orden_trabajo = '';

				$hito = false;

				// get the filter's value.

				// get the filter's column.

				$filterdatafield = $_GET["filterdatafield" . $i];

				

				switch($_GET["filterdatafield" . $i]):

				

					case "s.estado":

						switch($_GET["filtervalue" . $i]):

							case "NO REVISADO":

								$estado = 0;

							break;

							case "APROBADO":

								$estado = 1;

							break;

							case "RECHAZADO":

								$estado = 2;

							break;

							case "REVISADO":

								$estado = 3;

							break;

						endswitch;

						

						$filtervalue = $estado;

						

					break;

					case "s.id_ordentrabajo";

						$sql4 = "SELECT o.id_proyecto AS idproyecto, a.id AS idanticipo FROM `orden_trabajo` AS o

								 RIGHT JOIN anticipo AS a ON o.id_proyecto = a.id_ordentrabajo

								 WHERE ".$filtroRegion3." o.orden_trabajo LIKE '%".strtoupper($_GET["filtervalue" . $i])."%'";

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

								$orden_trabajo .= ' AND s.id = '.$rs_pai4['idanticipo'];

								$i2++;

							else:

								$orden_trabajo .= ' OR s.id = '.$rs_pai4['idanticipo'];

							endif;

						endwhile;

					break;	

					case "s.total_anticipo":

						$sql4 = "SELECT DISTINCT(id_anticipo) AS idanticipo

								 FROM `items_anticipo` AS ia

								 RIGHT JOIN anticipo AS a ON ia.id_anticipo = a.id

								 WHERE ia.id_hitos = ".(int)$_GET["filtervalue" . $i];

        				$pai4 = mysql_query($sql4); 

						$filtervalue = '';

						$hito = true;

						$i2=0;

						while($rs_pai4 = mysql_fetch_assoc($pai4)):

							if($i2==0):

								$orden_trabajo .= ' AND s.id = '.$rs_pai4['idanticipo'];

								$i2++;

							else:

								$orden_trabajo .= ' OR s.id = '.$rs_pai4['idanticipo'];

							endif;

						endwhile;

					break;				

					default:

						$filtervalue = $_GET["filtervalue" . $i];

					break;

					

				endswitch;

				

			

				// get the filter's condition.

				$filtercondition = $_GET["filtercondition" . $i];				

				// get the filter's operator.

				$filteroperator = $_GET["filteroperator" . $i];

				

				if($_GET["filterdatafield" . $i] != 's.total_anticipo'):

				

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

				

				endif;

								

				if ($i == $filterscount - 1)

				{

					$where .= ") ".$orden_trabajo;

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			if($hito == true):

				$where = ' WHERE estado != "draft" AND '.$orden_trabajo;

			endif;

			

			$query = "SELECT * FROM apu ".$where." ";

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM apu ".$where."  LIMIT $start, $pagesize";		

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

					$query = "SELECT *

			  				  FROM apu 
							  
							  WHERE estado != 'draft'

							  ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT *

			  				  FROM apu 
							  
							  WHERE estado != 'draft'

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

	

	//echo $query;

	

	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

	$orders = null;

	// get data and store in a json array

		
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$eliminar = '<a href="javascript: fn_eliminar('.$row['ID'].');"><img src="../extras/ico/delete.png" /></a>';

		$customers[] = array(

			'id' => $row['id'],

			'descripcion' => utf8_encode($row['descripcion']),			

			'acciones' => '<a href="javascript: fn_mostrar_frm_modificar('.$row['id'].');"><img src="../extras/ico/page_edit.png" /></a>&nbsp;<a href="javascript: fn_eliminar('.$row['id'].');"><img src="../extras/ico/delete.png" /></a>'

		  );

	}

	

    $data[] = array(

       'TotalRows' => $total_rows,

	   'Rows' => $customers

	);

	echo json_encode($data);

?>