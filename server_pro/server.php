<?php
// Nuestro token
$deviceToken = '6612ec8ec201e443ec6e8fff0303a41ff25b577e04f4a811c936dd6ea0af2102';

// El password del fichero .pem 
$passphrase = '2320245';

// El mensaje push
$message = 'Test Push Pro';

$ctx = stream_context_create();

//Especificamos la ruta al certificado .pem que hemos creado
stream_context_set_option($ctx, 'ssl', 'local_cert', 'certs5/TestPushCK.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);


// Abrimos conexión con APNS 
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
if (!$fp) {
	exit("Error de conexión: $err $errstr" . PHP_EOL);
}


echo 'Conectado al APNS' . PHP_EOL;

// Creamos el payload

$body['aps'] = array(
	'alert' => $message,
	'sound' => 'bingbong.aiff', 
	'badge' => 8
);

// Lo codificamos a json
$payload = json_encode($body);

// Construimos el mensaje binario
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Lo enviamos
$result = fwrite($fp, $msg, strlen($msg));

if (!$result) {
	echo 'Mensaje no enviado' . PHP_EOL;
} else { 
	echo 'Mensaje enviado correctamente 1' . PHP_EOL;
}

// cerramos la conexión

fclose($fp);

