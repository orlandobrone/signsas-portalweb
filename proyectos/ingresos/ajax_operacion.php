<?php

$letters = array(',','$','.');
$fruit   = array('');

$valor_mantenimiento = substr($_POST['valor_mantenimiento'],0, -3);
$valor_suministro = substr($_POST['valor_suministro'],0, -3);

$valor_mantenimiento = str_replace($letters, $fruit, $valor_mantenimiento);
$valor_suministro = str_replace($letters, $fruit, $valor_suministro);

$valor_total = $valor_mantenimiento + $valor_suministro;

setlocale(LC_MONETARY, 'es_CO');		
echo $valor_total = money_format('%(#0n',$valor_total);


?>