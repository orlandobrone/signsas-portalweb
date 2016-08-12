<?php

require "class/Uploader.php";
include "../conexion.php";
include "../funciones.php";
include "extras/php/basico.php";

$valid_extensions = array('xls');

$upload_dir = 'uploads/'; 
$Upload = new FileUpload('uploadfile');
$result = $Upload->handleUpload($upload_dir, $valid_extensions);


if (!$result) {	 
    echo json_encode(array('success' => false, 'msg' => $Upload->getErrorMsg()));   
} else {
	
	require_once 'php/ext/PHPExcel-1.8.0/Classes/PHPExcel/IOFactory.php';
	//cargamos el archivo que deseamos leer
	$objPHPExcel = PHPExcel_IOFactory::load($upload_dir.$Upload->getFileName());
	//$objPHPExcel = PHPExcel_IOFactory::load($upload_dir.'Copia de cargue.xls');
	//obtenemos los datos de la hoja activa (la primera) 
	$objHoja = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	
	foreach ($objHoja as $index=>$row): 
	
		/*$valor = str_replace(',', '.', str_replace('.', '',str_replace(' ','',$row['B'])));*/
		
		if($index != 1 && $row['A'] != ''):
			$sql = sprintf("INSERT INTO hitos_upload VALUES ('','%s', '%s','%s','%s','%s','%s','%s');",
				fn_filtro( preg_replace('#([^.a-z0-9]+)#i','',utf8_decode($row['A'])) ),
				fn_filtro( preg_replace('#([^.a-z0-9]+)#i','',utf8_decode($row['B']))),
				fn_filtro($row['C']),
				fn_filtro($row['D']),
				fn_filtro($row['E']),
				fn_filtro( preg_replace('#([^.a-z0-9]+)#i','',utf8_decode($row['F']))),
				fn_filtro( preg_replace('#([^.a-z0-9]+)#i','',utf8_decode($row['G'])))
			);	
			
			/*//var_dump(utf8_decode($row['A']));
			echo '<br>';
			//$text = string2url(utf8_decode($row['A']));
			$var = preg_replace('#([^.a-z0-9]+)#i','',utf8_decode($row['A']));
			var_dump($var);
			
			echo '<br>';
			
			echo $sql;
			echo '<br>';*/		
		
			if(!mysql_query($sql)):
				echo "Error al insertar al nuevo cliente:\n$sql";
			endif;
			
		endif;		
		
	endforeach;
	 
    echo json_encode(array('success' => true, 'file' => $Upload->getFileName())); 
}

?>