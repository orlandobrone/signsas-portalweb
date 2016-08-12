<?

function fn_filtro($cadena) {
	if(get_magic_quotes_gpc() != 0) {
		$cadena = stripslashes($cadena);
	}
	return mysql_real_escape_string(utf8_decode($cadena));
}

function conv_valores_monetarios ($valor) {
	$valor = explode("$", $valor);
	$costo = trim($valor[1]);
	$costo = explode(".", $costo);
	$costo = str_replace(",", "", $costo[0]) . '.' . $costo[1];
	return $costo;
}

?>