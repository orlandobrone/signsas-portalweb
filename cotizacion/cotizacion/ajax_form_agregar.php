<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
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
<h1>Agregando nueva cotizaci&oacute;n</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table width="1100" class="formulario">
            <tr>
              	<td width="305">Nombre Cotizaci&oacute;n</td>
                <td width="375">Descripci&oacute;n</td>
                <td width="272">Factor de Utilidad</td>
            </tr>
            <tr>
              <td><input name="nombre" type="text" id="nombre" size="50" class="required" /></td>
              <td><input name="descri" type="text" id="descri" size="50" class="required" /></td>
              <td><input name="ganancia_adicional" type="text" id="ganancia_adicional" size="28" class="required" alt="decimal-us" />
               <span class="requiere" >Debe completar este campo</span></td>
            </tr>
            <tr>
              <td colspan="3"><table width="100%">
                <tr>
              <td width="114">&nbsp;</td>
              <td width="10%" style="font-weight:bold;">Materiales</td>
              <td width="10%" style="font-weight:bold;">MOD</td>
              <td width="10%" style="font-weight:bold;">MOI</td>
              <td width="10%" style="font-weight:bold;">TOES</td>
              <td width="105">Transportes</td>
              <td width="106">Alquiler de Veh&iacute;culos</td>
              <td width="106">Imprevistos</td>
              <td width="103">ICA</td>
              <td width="104">Coste Financiero</td>
              <td width="102">Acarreos</td>
              <td width="105">Caja Menor</td>
             
                </tr>
            <tr class="costoEstimadoADD">
              <td>Costo Estimado</td>
              <td><input name="materiales" type="text" id="materiales" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="MOD" type="text" id="MOD" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="MOI" type="text" id="MOI" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="TOES" type="text" id="TOES" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="transp" type="text" id="transp" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="alqveh" type="text" id="alqveh" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="imprev" type="text" id="imprev" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="ica" type="text" id="ica" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="cosfin" type="text" id="cosfin" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="acarre" type="text" id="acarre" size="16" class="required" alt="decimal-us" /></td>
              <td><input name="cajmen" type="text" id="cajmen" size="16" class="required" alt="decimal-us" /></td>
             
            </tr>
            <tr>
              <td>Precio de Venta</td>
                <td><input name="materiales2" type="text" id="materiales2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="MOD2" type="text" id="MOD2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="MOI2" type="text" id="MOI2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="TOES2" type="text" id="TOES2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="transp2" type="text" id="transp2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="alqveh2" type="text" id="alqveh2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="imprev2" type="text" id="imprev2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="ica2" type="text" id="ica2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="cosfin2" type="text" id="cosfin2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="acarre2" type="text" id="acarre2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                <td><input name="cajmen2" type="text" id="cajmen2" size="16" class="required disabled" alt="decimal-us"   readonly="readonly"/></td>
                
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
            <tr class="costoEstimadoADD">
              <td>Costo Estimado</td>
                <td><input name="tiqaer" type="text" id="tiqaer" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="intern" type="text" id="intern" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="arrend" type="text" id="arrend" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="repara" type="text" id="repara" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="profes" type="text" id="profes" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="seguro" type="text" id="seguro" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="comcel" type="text" id="comcel" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="asevig" type="text" id="asevig" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="peajes" type="text" id="peajes" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="asecaf" type="text" id="asecaf" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="taxbus" type="text" id="taxbus" size="16" class="required" alt="decimal-us" /></td>
               
            </tr>
            <tr>
              <td>Precio de Venta</td>
                <td><input name="tiqaer2" type="text" id="tiqaer2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="intern2" type="text" id="intern2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="arrend2" type="text" id="arrend2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="repara2" type="text" id="repara2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="profes2" type="text" id="profes2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="seguro2" type="text" id="seguro2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="comcel2" type="text" id="comcel2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="asevig2" type="text" id="asevig2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="peajes2" type="text" id="peajes2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="asecaf2" type="text" id="asecaf2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="taxbus2" type="text" id="taxbus2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
               
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
            <tr class="costoEstimadoADD">
                <td>Costo Estimado</td> 
                <td><input name="asitec" type="text" id="asitec" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="envcor" type="text" id="envcor" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="otrser" type="text" id="otrser" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="combus" type="text" id="combus" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="lavveh" type="text" id="lavveh" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="gasvia" type="text" id="gasvia" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="poliza" type="text" id="poliza" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="papele" type="text" id="papele" size="16" class="required" alt="decimal-us" /></td>
                <td><input name="parque" type="text" id="parque" size="16" class="required" alt="decimal-us" /></td>
            </tr>
            <tr>
              <td>Precio de Venta</td>
                <td><input name="asitec2" type="text" id="asitec2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="envcor2" type="text" id="envcor2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="otrser2" type="text" id="otrser2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="combus2" type="text" id="combus2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="lavveh2" type="text" id="lavveh2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="gasvia2" type="text" id="gasvia2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="poliza2" type="text" id="poliza2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="papele2" type="text" id="papele2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
                <td><input name="parque2" type="text" id="parque2" size="16" class="required disabled" alt="decimal-us"  readonly="readonly" /></td>
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
                    <input name="agregar" type="submit" id="agregar" value="Agregar" />
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
			rules:{
				usu_per:{
					required: true,
					remote: "ajax_verificar_usu_per.php"
				}
			},
			messages: {
				usu_per: "x"
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente agregar esta nueva cotizaci\xf3n?')
				if (respuesta)
					form.submit();
			}
		});
		
		$('input').setMask();	
		
	});
	
	$('.costoEstimadoADD input').blur(function(){
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
	
	
	function fn_agregar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_agregar.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "") {
					alert(data);
				}else{
					fn_cerrar();	
					fn_buscar();
				}
			}
		});
	};
</script>