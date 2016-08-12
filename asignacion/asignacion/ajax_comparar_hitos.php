<?
	include "../../conexion.php";
	
	/*$sqlPry = "SELECT * FROM hitos WHERE 
						 ((fecha_inicio >= '".$_POST['fechaini']."' AND fecha_inicio <= '".$_POST['fechaend']."') 
					   OR (fecha_final >= '".$_POST['fechaini']."' AND fecha_final <= '".$_POST['fechaend']."') 
					   OR (fecha_inicio <= '".$_POST['fechaini']."' AND fecha_inicio >= '".$_POST['fechaend']."'))";*/
					   
	$sqlPry = "SELECT * FROM hitos WHERE 1";				   
					   
	$qrPry = mysql_query($sqlPry);
	
	$optionT = '';
	
    while ($row = mysql_fetch_array($qrPry)):
   				$optionT .= '<option value="'.$row['id'].'">'.utf8_encode($row['nombre']).'</option>';
    endwhile;
	 
	echo $optionT;                   
	
	
?>