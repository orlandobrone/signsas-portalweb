<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";

	if(in_array(204,$_SESSION['permisos']))
		$whereE = ' ';
	else 
		$whereE = ' AND estado NOT IN("ELIMINADO") ';

	$pagenum = $_GET['pagenum'];
	$pagesize = $_GET['pagesize'];
	$start = $pagenum * $pagesize;

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM legalizacion WHERE 1 ".$whereE." LIMIT $start, $pagesize";

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
					case "id_beneficiario":
						$sql4 = "SELECT id FROM `beneficiarios`
								 WHERE beneficiario LIKE '".strtoupper($_GET["filtervalue" . $i])."%'";

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
						
						$idBeneficiarios  = '';
						while($rs_pai4 = mysql_fetch_assoc($pai4)):
								$idBeneficiarios .= ' OR id_beneficiario = '.$rs_pai4['id'];
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

					$where .= ") ".$whereE." ".$idBeneficiarios;

				}

				

				$tmpfilteroperator = $filteroperator;

				$tmpdatafield = $filterdatafield;			

			}

			// build the query.

			$query = "SELECT * FROM legalizacion ".$where;

			$filterquery = $query;

			$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

			$sql = "SELECT FOUND_ROWS() AS `found_rows`;";

			$rows = mysql_query($sql);

			$rows = mysql_fetch_assoc($rows);

			$new_total_rows = $rows['found_rows'];		

			$query = "SELECT * FROM legalizacion ".$where." LIMIT $start, $pagesize";		

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

					$query = "SELECT * FROM legalizacion WHERE 1 ".$whereE." ORDER BY" . " " . $sortfield . "  DESC LIMIT $start, $pagesize";

				}

				else if ($sortorder == "asc")

				{

					$query = "SELECT * FROM legalizacion WHERE 1 ".$whereE." ORDER BY" . " " . $sortfield . "   ASC LIMIT $start, $pagesize";

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

	$letters = array('.','$',',');
	$fruit   = array('');
	
	//echo $query;
	
	$obj = new TaskCurrent;	
	

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {


		$estado = '';
		$editado = '';


		if($row['fecha_edit'] != '0000-00-00 00:00:00'):

           $editado = '<img class="tolltip" title="Fecha Editado:'.$row['fecha_edit'].'" src="https://cdn1.iconfinder.com/data/icons/16x16-free-toolbar-icons/16/58.png" /></td>';

       	endif;

		

		/*-----------------------------------------------------------------------------------*/
		$valor_legalizado = 0;
		$reintegro = 0;
		$valor_pagar = 0;
		

		$resultado = mysql_query("SELECT pagado FROM items WHERE estado = 0 AND id_legalizacion =".$row['id']) or die(mysql_error());

		$total = mysql_num_rows($resultado);

		while ($rows = mysql_fetch_assoc($resultado)):

			if($rows['pagado'] != ''):

				$valor = explode(',00',$rows['pagado']);

				$valor2 = str_replace($letters, $fruit, $valor[0] );

				$valor_legalizado += $valor2;

			endif;

		endwhile;

		

		//$valor = explode(',00',$row['valor_fa']);


		$valor = substr($row['valor_fa'],0, -3);
		$valor_fondo = str_replace($letters, $fruit, $valor);		
		
		if($valor_legalizado != 0 ):			
			$reintegro = $valor_fondo - $valor_legalizado;
		endif;

		if($valor_legalizado > $valor_fondo):			
			$valor_pagar = $valor_legalizado - $valor_fondo;
			$reintegro = 0;
		endif;

		
		//Obtengo el valor total de reintegro de un anticipo de prioridad reintegro
		$reintegro_anticipo = $obj->getReintegroByLegalizacion((int)$row['id']);
		$reintegro_anticipo = substr($reintegro_anticipo,0, -3);
		$reintegro_anticipo = str_replace($letters, $fruit, $reintegro_anticipo);	
	
		$reintegro = $reintegro - $reintegro_anticipo;
		

		setlocale(LC_MONETARY, 'en_US');

	

		$resultado_anticipo = mysql_query("SELECT * FROM anticipo WHERE publicado NOT IN('draft','ELIMINADO') AND estado != 4 AND id_legalizacion =".$row['id']) or die(mysql_error());
		$total_anticipo = mysql_num_rows($resultado_anticipo);
		$row_anticipo = mysql_fetch_assoc($resultado_anticipo);
		

		if($total_anticipo > 0):

			$otro_anticipo = ' - '.$row_anticipo['id'];
			$total_anticipo2 = substr($row_anticipo['total_anticipo'],0, -3);
			$total_anticipo2 = str_replace($letters, $fruit, $total_anticipo2);
			$valor_pagar = $valor_pagar - $total_anticipo2;

		else:
			$otro_anticipo = '';
		endif;


		$valor_pagar = $valor_pagar + $reintegro_anticipo;

		$valor_pagar = money_format('%(#1n',$valor_pagar);
		$valor_reintegro = money_format('%(#1n',$reintegro);
		$valor_legalizado =  money_format('%(#1n',$valor_legalizado);

		/*$sql2 = sprintf("SELECT total_anticipo FROM anticipo WHERE id_legalizacion=%d",

			(int)$row['id']

		);

		$per2 = mysql_query($sql2);

		$num_rs_per2 = mysql_num_rows($per2);

		if ($num_rs_per2 > 0){

			while($rs_per2 = mysql_fetch_assoc($per2)){

				$valor = substr($rs_per2['total_anticipo'],0, -3);

				$valor = str_replace($letters, $fruit, $valor);

				

				$total_anticipos_vinculados += (int)$valor;

			}

		}else{

			$total_anticipo  = 0;

		}*/

		$valor_fondo = money_format('%(#1n',$valor_fondo + $total_anticipos_vinculados);
		//$valor_fondo = (int)$valor_fondo + (int)$total_anticipos_vinculados;

		/*---------------------------------------------------------------------------------*/
		$sql2 = sprintf("SELECT beneficiario, orden_servicio_id 
						 FROM anticipo WHERE id=%d",
			(int)$row['id_anticipo']
		);

		$per2 = mysql_query($sql2);
	    $rs_per2 = mysql_fetch_assoc($per2);
		
		if($rs_per2['orden_servicio_id']==0):
			$beneficiario = ($rs_per2['beneficiario'] != '')? utf8_encode($rs_per2['beneficiario']): 'N/A';
		else:
		
			$sql2 = sprintf("SELECT nombre_contratista
						 	 FROM orden_servicio WHERE id=%d",
				(int)$rs_per2['orden_servicio_id']
			);
	
			$per2 = mysql_query($sql2);
			$rs_per2 = mysql_fetch_assoc($per2);
			$beneficiario = utf8_encode($rs_per2['nombre_contratista']);
			
		endif;
		
		$customers[] = array(

			'id' => $row['id'],
			'responsable' =>  utf8_encode($row['responsable']),
			'fecha' => $row['fecha'],
			'id_anticipo' => $row['id_anticipo'].'-'.$otro_anticipo,
			'valor_fondo' => $valor_fondo,
			'valor_legalizado' => $valor_legalizado,
			'valor_pagar' =>  $valor_pagar,
			'legalizacion' => $valor_reintegro,
			'estado' => $row['estado'],
			'id_beneficiario' => $beneficiario,
			'acciones' => '<a href="javascript: fn_mostrar_frm_add_items('.$row['id'].');"><img src="https://cdn1.iconfinder.com/data/icons/fugue/icon_shadowless/application-sidebar-list.png"></a>&nbsp;'.$editado

		  );

	}

    $data[] = array(
       'TotalRows' => $total_rows,
	   'Rows' => $customers
	);

	echo json_encode($data);

?>