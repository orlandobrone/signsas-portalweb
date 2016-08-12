<?php

//Ejemplo de código PHP
/*$postData = array( 
    'idApplication' => '6946-7d82-aa95-b2ac', 
    'idDevice' => '556b458f9217c99e5f3af141',
    'title' => 'EntregaYa',
    'content' => 'Solicitud de un nuevo servicio'
);
 
$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => 'token: 5526b0e15029496162233f70',
        'content' => http_build_query($postData)
    )
));
 
$url = 'http://api.devicepush.com/send';
$result = file_get_contents($url, false, $context);*/
require_once('../wp-config.php');

echo send_notificaciones_allDevices(1, 'Nuevo servicio',0,'Nuevo');


//echo sendMailByMensajeria(3,11,4);


//echo round(9850, -2); 


/*require_once('../wp-config.php');

$message = 'Solicitud de un nuevo servicio';               
$title = 'Nuevo Servicio';
send_notificaciones_allDevices(1,$message,0,$title);*/


/*--- Enviando notificaciones push ----*/
/*
define("GOOGLE_API_KEY", "AIzaSyAoayX1J2FcDvKpHtNrdR77AhNiJtz4LoM");  
$url = 'https://push.ionic.io/api/v1/push'; 

$fields = array( 
	'tokens' => array("b284a6f7545368d2d3f753263e3e2f2b7795be5263ed7c95017f628730edeaad",
    				  "d609f7cba82fdd0a568d5ada649cddc5ebb65f08e7fc72599d8d47390bfc0f20"), 
	'notification' => array( "alert"=>"Hello World!",
							 "android"=>array(
								  "collapseKey"=>"foo",
								  "delayWhileIdle"=>true,
								  "timeToLive"=>300,
								  "payload"=>array(
									"key1"=>"value",
									"key2"=>"value"
								  )
								)
							), 
); 

$headers = array( 
	'Content-Type: application/json', 
	'X-Ionic-Application-Id: 94ea09c7'
	 
); 
// abriendo la conexion 
$ch = curl_init(); 

// Set the url, number of POST vars, POST data 
curl_setopt($ch, CURLOPT_URL, $url); 

curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

// Deshabilitamos soporte de certificado SSL temporalmente 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields)); 

// ejecutamos el post 
$result = curl_exec($ch); 
if ($result === FALSE) { 
	die('Curl failed: ' . curl_error($ch)); 
} 
// Cerramos la conexion 
curl_close($ch);     
//echo $result; */


?>
