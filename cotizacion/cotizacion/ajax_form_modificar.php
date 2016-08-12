<?	header('Content-Type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from cotizacion where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen cotizaciones con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
	
?>
<style>
	table.formulario td, table.formulario th {
		padding: 0px;	
	}
	.error{ background:#FFB3B3; }
	.requiere{ color:#FF0000;  font-size:9px; display:none; }
	.required{ text-align:right !important; }
	.disabled{ background:#CCC; }
</style>
<h1>Modificando cotizaci&oacute;n</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table width="1100" class="formulario">
            <tr>
                <td width="326">Nombre Cotizaci&oacute;n</td>
                <td width="358">Descripci&oacute;n</td>
                <td width="268">Factor de Utilidad</td>
            </tr>
            <tr>
                <td><input name="nombre" type="text" id="nombre" size="50" class="required" value="<?=$rs_per['nombre']?>" /></td>
                <td><input name="descri" type="text" id="descri" size="50" class="required" value="<?=$rs_per['descripcion']?>" /></td>
                <td><input name="ganancia_adicional" type="text" id="ganancia_adicional" size="28" class="required" alt="decimal-us" value="<?=$rs_per['ganancia_adicional']?>" />
                <span class="requiere" >Debe completar este campo</span>
                </td>
            </tr>
            <tr>
              <td colspan="3"><table width="100%">
                <tr>
                <td width="10%">&nbsp;</td>
                <td width="10%" style="font-weight:bold;">Materiales</td>
                <td width="10%" style="font-weight:bold;">MOD</td>
                <td width="10%" style="font-weight:bold;">MOI</td>
                <td width="10%" style="font-weight:bold;">TOES</td>
                <td width="10%">Transportes</td>
                <td width="10%">Alquiler de Veh&iacute;culos</td>
                <td width="10%">Imprevistos</td>
                <td width="10%">ICA</td>
                <td width="11%">Coste Financiero</td>
                <td width="11%">Acarreos</td>
                <td width="10%">Caja Menor</td>               
                </tr>
            <tr class="costoEstimado">
              <td>Costo Estimado</td>
              	<td><input name="materiales" type="materiales" id="materiales" size="16" class="required" alt="decimal-us" value="<?=$rs_per['materiales']?>" /></td>
                <td><input name="MOD" type="text" id="MOD" size="16" class="required" alt="decimal-us" value="<?=$rs_per['MOD']?>" /></td>
                <td><input name="MOI" type="text" id="MOI" size="16" class="required" alt="decimal-us" value="<?=$rs_per['MOI']?>" /></td>
                <td><input name="TOES" type="text" id="TOES" size="16" class="required" alt="decimal-us" value="<?=$rs_per['TOES']?>" /></td>
                <td><input name="transp" type="text" id="transp" size="16" class="required" alt="decimal-us" value="<?=$rs_per['transportes']?>" /></td>
                <td><input name="alqveh" type="text" id="alqveh" size="16" class="required" alt="decimal-us" value="<?=$rs_per['alquileres_vehiculos']?>" /></td>
                <td><input name="imprev" type="text" id="imprev" size="16" class="required" alt="decimal-us" value="<?=$rs_per['imprevistos']?>" /></td>
                <td><input name="ica" type="text" id="ica" size="16" class="required" alt="decimal-us" value="<?=$rs_per['ica']?>" /></td>
                <td><input name="cosfin" type="text" id="cosfin" size="16" class="required" alt="decimal-us" value="<?=$rs_per['coste_financiero']?>" /></td>
                <td><input name="acarre" type="text" id="acarre" size="16" class="required" alt="decimal-us" value="<?=$rs_per['acarreos']?>" /></td>
                <td><input name="cajmen" type="text" id="cajmen" size="16" class="required" alt="decimal-us" value="<?=$rs_per['caja_menor']?>" /></td>
               
                </tr>
            <tr>
              <td>Precio de Venta</td>
              	<td><input name="materiales2" type="text" id="materiales2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['materiales2']?>"  readonly="readonly"/></td> 
                <td><input name="MOD2" type="text" id="MOD2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['MOD2']?>"   readonly="readonly"/></td>
                <td><input name="MOI2" type="text" id="MOI2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['MOI2']?>"   readonly="readonly"/></td>
                <td><input name="TOES2" type="text" id="TOES2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['TOES2']?>"   readonly="readonly"/></td>
                <td><input name="transp2" type="text" id="transp2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['transportes2']?>"   readonly="readonly"/></td>
                <td><input name="alqveh2" type="text" id="alqveh2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['alquileres_vehiculos2']?>"  readonly="readonly" /></td>
                <td><input name="imprev2" type="text" id="imprev2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['imprevistos2']?>"   readonly="readonly"/></td>
                <td><input name="ica2" type="text" id="ica2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['ica2']?>"   readonly="readonly"/></td>
                <td><input name="cosfin2" type="text" id="cosfin2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['coste_financiero2']?>"   readonly="readonly"/></td>
                <td><input name="acarre2" type="text" id="acarre2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['acarreos2']?>"   readonly="readonly"/></td>
                <td><input name="cajmen2" type="text" id="cajmen2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['caja_menor2']?>"   readonly="readonly"/></td>
              
                </tr>
            <tr>
              <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            <tr>
              <td>&nbsp;</td>
                <td>Tiquetes A&eacute;reos</td>
                <td>Servicio de internet</td>
                <td>Arrendamientos</td>
                <td>Reparaciones</td>
                <td>Profesionales</td>
                <td>Seguros</td>
                <td>Comunicaciones Celular</td>
                <td>Aseo y Vigilancia</td>
                <td>Peajes</td>
                <td>Elementos de Aseo y Cafeter&iacute;a</td>
                <td>Taxis y Buses</td>
                
                </tr>
            <tr class="costoEstimado">
              <td>Costo Estimado</td>
              
                <td><input name="tiqaer" type="text" id="tiqaer" size="16" class="required" alt="decimal-us" value="<?=$rs_per['tiquetes_aereos']?>" /></td>
                <td><input name="intern" type="text" id="intern" size="16" class="required" alt="decimal-us" value="<?=$rs_per['internet']?>" /></td>
              
                <td><input name="arrend" type="text" id="arrend" size="16" class="required" alt="decimal-us" value="<?=$rs_per['arrendamientos']?>" /></td>
                <td><input name="repara" type="text" id="repara" size="16" class="required" alt="decimal-us" value="<?=$rs_per['reparaciones']?>" /></td>
                <td><input name="profes" type="text" id="profes" size="16" class="required" alt="decimal-us" value="<?=$rs_per['profesionales']?>" /></td>
                <td><input name="seguro" type="text" id="seguro" size="16" class="required" alt="decimal-us" value="<?=$rs_per['seguros']?>" /></td>
                <td><input name="comcel" type="text" id="comcel" size="16" class="required" alt="decimal-us" value="<?=$rs_per['comunicaciones_celular']?>" /></td>
                <td><input name="asevig" type="text" id="asevig" size="16" class="required" alt="decimal-us" value="<?=$rs_per['aseo_vigilancia']?>" /></td>
                <td><input name="peajes" type="text" id="peajes" size="16" class="required" alt="decimal-us" value="<?=$rs_per['peajes']?>" /></td>
                <td><input name="asecaf" type="text" id="asecaf" size="16" class="required" alt="decimal-us" value="<?=$rs_per['aseo_cafeteria']?>" /></td>
                <td><input name="taxbus" type="text" id="taxbus" size="16" class="required" alt="decimal-us" value="<?=$rs_per['taxis_buses']?>" /></td>
                </tr>
            <tr>
              <td>Precio de Venta</td>
              	  <td><input name="tiqaer2" type="text" id="tiqaer2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['tiquetes_aereos2']?>"  readonly="readonly"/></td>
                <td><input name="intern2" type="text" id="intern2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['internet2']?>"   readonly="readonly"/></td>
                <td><input name="arrend2" type="text" id="arrend2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['arrendamientos2']?>"   readonly="readonly"/></td>
                <td><input name="repara2" type="text" id="repara2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['reparaciones2']?>"   readonly="readonly"/></td>
                <td><input name="profes2" type="text" id="profes2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['profesionales2']?>"   readonly="readonly"/></td>
                <td><input name="seguro2" type="text" id="seguro2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['seguros2']?>"   readonly="readonly"/></td>
                <td><input name="comcel2" type="text" id="comcel2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['comunicaciones_celular2']?>"   readonly="readonly"/></td>
                <td><input name="asevig2" type="text" id="asevig2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['aseo_vigilancia2']?>"   readonly="readonly"/></td>
                <td><input name="peajes2" type="text" id="peajes2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['peajes2']?>"   readonly="readonly"/></td>
                <td><input name="asecaf2" type="text" id="asecaf2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['aseo_cafeteria2']?>"   readonly="readonly"/></td>
                <td><input name="taxbus2" type="text" id="taxbus2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['taxis_buses2']?>"   readonly="readonly"/></td>
                </tr>
            <tr>
              <td>&nbsp;</td>
                <td>&nbsp;</td>
         nd       <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            <tr>
              <td>&nbsp;</td>
                <td>Asistencia T&eacute;cnica</td>
                <td>Env&iacute;o Correos, Postales y Telegramas</td>
                <td>Otros Servicios</td>
                <td>Combustible</td>
                <td>Lavado Veh&iacute;culo</td>
                <td>Gastos de Viaje</td>
                <td>Polizas</td>
                <td>Utiles Papeler&iacute;a y Fotocopias</td>
                <td>Parqueaderos</td>
                </tr>
            <tr class="costoEstimado">
              <td>Costo Estimado</td>
                <td><input name="asitec" type="text" id="asitec" size="16" class="required" alt="decimal-us" value="<?=$rs_per['asistencia_tecnica']?>" /></td>
                <td><input name="envcor" type="text" id="envcor" size="16" class="required" alt="decimal-us" value="<?=$rs_per['envios_correos']?>" /></td>
                <td><input name="otrser" type="text" id="otrser" size="16" class="required" alt="decimal-us" value="<?=$rs_per['otros_servicios']?>" /></td>
                <td><input name="combus" type="text" id="combus" size="16" class="required" alt="decimal-us" value="<?=$rs_per['combustible']?>" /></td>
                <td><input name="lavveh" type="text" id="lavveh" size="16" class="required" alt="decimal-us" value="<?=$rs_per['lavado_vehiculo']?>" /></td>
                <td><input name="gasvia" type="text" id="gasvia" size="16" class="required" alt="decimal-us" value="<?=$rs_per['gastos_viaje']?>" /></td>
                <td><input name="poliza" type="text" id="poliza" size="16" class="required" alt="decimal-us" value="<?=$rs_per['polizas']?>" /></td>
                <td><input name="papele" type="text" id="papele" size="16" class="required" alt="decimal-us" value="<?=$rs_per['papeleria']?>" /></td>
                <td><input name="parque" type="text" id="parque" size="16" class="required" alt="decimal-us" value="<?=$rs_per['parqueaderos']?>" /></td>
                </tr>
            <tr>
              <td>Precio de Venta</td>
                <td><input name="asitec2" type="text" id="asitec2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['asistencia_tecnica2']?>"   readonly="readonly"/></td>
                <td><input name="envcor2" type="text" id="envcor2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['envios_correos2']?>"   readonly="readonly"/></td>
                <td><input name="otrser2" type="text" id="otrser2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['otros_servicios2']?>"   readonly="readonly"/></td>
                <td><input name="combus2" type="text" id="combus2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['combustible2']?>"  readonly="readonly" /></td>
                <td><input name="lavveh2" type="text" id="lavveh2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['lavado_vehiculo2']?>"   readonly="readonly"/></td>
                <td><input name="gasvia2" type="text" id="gasvia2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['gastos_viaje2']?>"  readonly="readonly" /></td>
                <td><input name="poliza2" type="text" id="poliza2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['polizas2']?>"   readonly="readonly"/></td>
                <td><input name="papele2" type="text" id="papele2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['papeleria2']?>"   readonly="readonly"/></td>
                <td><input name="parque2" type="text" id="parque2" size="16" class="required disabled" alt="decimal-us" value="<?=$rs_per['parqueaderos2']?>"   readonly="readonly"/></td>
                </tr>
            <tr>
              <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            <tr>
                <td colspan="10" align="right" style="padding-right:20px">
                    <input name="modificar" type="submit" id="modificar" value="Modificar" />
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />
                </td>
            </tr>
              </table></td>
            </tr>
    </table>
</form>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar esta cotizaci\xf3n?')
				if (respuesta)
					form.submit();
			}
		});
		
		$('input').setMask();		
		
	});
	
	$('.costoEstimado input').blur(function(){
		$ganacia =  $('#ganancia_adicional').val();
		$estimado = $(this).val().replace(/,/gi,'');
		$cotizado = ($estimado * $ganacia).toFixed(2);		
		
		if($ganacia != 0){
			$('#ganancia_adicional').removeClass('error');
			$('.requiere').hide();
					
			$id = $(this).attr('id');		
			$('#'+$id+'2').val($cotizado).setMask();
			
			
		}else{
			$('#ganancia_adicional').addClass('error');
			$('.requiere').show();
		}
	});
	
	
	
	function fn_modificar(){
		var str = $("#frm_per").serialize();	
		
		$.ajax({
			url: 'ajax_modificar.php',
			data: str,
			type: 'post',
			success: function(data){ 
				if(data != "") {
					alert(data)
				}else{
					fn_cerrar();	
					fn_buscar();
				}
			}
		});
	};
</script>