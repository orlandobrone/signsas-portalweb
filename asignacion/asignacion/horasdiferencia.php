<?php
$hora1 = $_GET['hora1'];
$hora2 = $_GET['hora2'];
	
$separar[1]=explode(':',$hora1); 
$separar[2]=explode(':',$hora2); 

$total_minutos[1] = ($separar[1][0]*60)+$separar[1][1]; 
$total_minutos[2] = ($separar[2][0]*60)+$separar[2][1]; 
$total_minutos = $total_minutos[1]-$total_minutos[2]; 
$total_horas = $total_minutos/60;

if($total_horas < 0)
	echo json_encode(array('estado'=>false,'valor'=>'Señor usuario debe realizar una asignación de '.$_GET['hora1'].' a 23:00:00 y otra de 00:00:00 a '.$_GET['hora2']));
else
	echo json_encode(array('estado'=>true,'valor'=>$total_horas));	
		
		/*$dateFormat = explode(',',$_POST['hora_final']);
	
	if($dateFormat[0] == 00):
		echo "La hora seleccionada no puede ser 00:00:00, s";
		exit;
	endif;*/
?>