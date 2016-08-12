<?php
  include "../conexion.php";
  include "../anticipos/extras/php/basico.php";
  
  //incluimos la clase
  require_once 'php/ext/PHPExcel-1.7.7/Classes/PHPExcel/IOFactory.php';
  
  //cargamos el archivo que deseamos leer
  $objPHPExcel = PHPExcel_IOFactory::load('uploads/importar_anticipos.xls');
  //obtenemos los datos de la hoja activa (la primera) 
  $objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
  
  foreach (array_slice($objHoja,1) as $iIndice=>$objCelda):
  
	  $sql = sprintf("INSERT INTO `anticipo` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', 0, '');",
			fn_filtro($objCelda['A']),
			fn_filtro($objCelda['B']),
			fn_filtro($objCelda['C']),
			fn_filtro($objCelda['D']),
			fn_filtro($objCelda['E']),
			fn_filtro($objCelda['F']),
			fn_filtro($objCelda['G']),
			fn_filtro($objCelda['H']),
			fn_filtro($objCelda['I']),
			fn_filtro($objCelda['J']),
			fn_filtro($objCelda['K']),
			fn_filtro($objCelda['L']),
			fn_filtro($objCelda['M']),
			fn_filtro($objCelda['N']),
			fn_filtro($objCelda['O']),
			fn_filtro($objCelda['P']),
			fn_filtro($objCelda['Q']),
			fn_filtro($objCelda['R']), 
			fn_filtro($objCelda['S'])	 	
		);
		
		if(!mysql_query($sql)){
			echo "Error al insertar la nueva asosaci&oacute;n:\n$sql";
			exit;
		}
	
	endforeach;
?>