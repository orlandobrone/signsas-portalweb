<?  header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	
	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from beneficiarios where id=%d",
		(int)$_POST['ide_per']
	);

	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){
		echo "No existen un Beneficiario con ese ID";
		exit;
	}

	$rs_per = mysql_fetch_assoc($per);

?>

<!--Hoja de estilos del calendario -->

<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">



<!-- librería principal del calendario -->

<script type="text/javascript" src="../../calendario/calendar.js"></script>



<!-- librería para cargar el lenguaje deseado -->

<script type="text/javascript" src="../../calendario/calendar-es.js"></script>



<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->

<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

<h1>Modificando Beneficiario</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />

      <table class="formulario">

        <tbody>
        	<tr>
            	<td colspan="3">
                	Fecha Creaci&oacute;n: <?=$rs_per['fecha_creacion']?>                	
                </td>
			</tr>
            
            <tr>
                <td colspan="2">Tipo Persona</td>              
            </tr>
            
            <tr>

                <td colspan="2">
                	BENEFICIARIO <input type="radio" name="tipo_persona" class="tipo_persona required" value="BENEFICIARIO" <?=($rs_per['tipo_persona'] == 'BENEFICIARIO')? 'checked':''?>>
                </td>
                <td colspan="2">
               		CONTRATISTA <input type="radio" name="tipo_persona" class="tipo_persona required" value="CONTRATISTA" <?=($rs_per['tipo_persona'] == 'CONTRATISTA')? 'checked':''?>>
                </td>
                
            </tr>
            
         
            <tr>
            	<td>HSQE:</td> 
            </tr>
            <tr>
            	<td colspan="2">Lista Clinton:</td> 
                <? if($rs_per['tipo_persona'] == 'CONTRATISTA'):?>
                <td colspan="2">SGSS:</td>
                <? endif; ?>
            </tr>
            <tr>
                <td colspan="2">
                	SI <input type="radio" name="clinton" class="clinton" value="0" <?=($rs_per['clinton'] == 0 && $rs_per['fecha_clinton'] != '0000-00-00')? 'checked':''?> >
              		NO <input type="radio" name="clinton" class="clinton" value="1" <?=($rs_per['clinton'] == 1 && $rs_per['fecha_clinton'] != '0000-00-00')? 'checked':''?>>
                </td>     
                <? if($rs_per['tipo_persona'] == 'CONTRATISTA'):?>       
                <td colspan="2">
                	SI <input type="radio" name="sgss" class="sgss" value="0" <?=($rs_per['sgss'] == 0 && $rs_per['fecha_sgss'] != '0000-00-00')? 'checked':''?>>
                	NO <input type="radio" name="sgss" class="sgss" value="1" <?=($rs_per['sgss'] == 1 && $rs_per['fecha_sgss'] != '0000-00-00')? 'checked':''?>>
                </td>
                 <? endif; ?>
            </tr>
            <tr>
            	<td>Tipo Trabajo:</td>
            </tr>
            <tr>
                <td colspan="4">
                	SI <input type="radio" name="tipo_trabajo" class="tipo_trabajo required" value="0" <?=($rs_per['tipo_trabajo'] == 0)? 'checked':''?>>
                	NO <input type="radio" name="tipo_trabajo" class="tipo_trabajo required" value="1" <?=($rs_per['tipo_trabajo'] == 1)? 'checked':''?>>
                	No Aplica <input type="radio" name="tipo_trabajo" class="tipo_trabajo required" value="2" <?=($rs_per['tipo_trabajo'] == 2)? 'checked':''?>>
                </td>
            </tr>
            
            
            <!--Alturas-->
            <? if($rs_per['tipo_trabajo'] == 2): ?>
            	<style>
					.content_tipotrabajo{ display:none; }
				</style>
            <? endif; ?> 
			
			<?
				$tipo_trabajos = unserialize($rs_per['tipos_trabajos']);
				if(!is_array($tipo_trabajos))
					$tipo_trabajos = array();
					
			?>
            <tr class="content_tipotrabajo">
            	<td colspan="2">
                	<input type="checkbox" name="check_tipo_trabajo[]" value="Altura" <?=(in_array('Altura',$tipo_trabajos))?'checked':''?>> Trabajo Alturas
                </td>
         
            	<td colspan="2">
               		<input type="checkbox" name="check_tipo_trabajo[]" value="Electrico" <?=(in_array('Electrico',$tipo_trabajos))?'checked':''?>> Trabajo Riesgo El&eacute;ctrico
                </td>
            </tr>
            <tr class="content_tipotrabajo">
            	<td colspan="2">
                	<input type="checkbox" name="check_tipo_trabajo[]" value="Soldadura" <?=(in_array('Soldadura',$tipo_trabajos))?'checked':''?>> Soldadura
                </td>
            	<td colspan="2">
                	<input type="checkbox" name="check_tipo_trabajo[]" value="Espacio" <?=(in_array('Espacio',$tipo_trabajos))?'checked':''?>> Espacio Confinado
                </td>
            </tr>
            <!--fin de alturas-->
           
            <tr>
                <td colspan="2">Actividad:</td>
            </tr>    
            <tr>
                <td colspan="4">              
                    <textarea name="actividad" cols="60" rows="8" <?=(in_array(195, $_SESSION['permisos']))?'':'readonly'?>><?=$rs_per['actividad'] ?></textarea>
                </td>
            </tr>
            
            <tr>

                <td>Identificaci&oacute;n</td>

                <td colspan="2"><input name="identificacion" type="text" id="identificacion" size="40" class="required"  value="<?=$rs_per['identificacion']?>"/></td>

            </tr>

            <tr>

                <td>Nombre</td>

                <td colspan="2"><input name="nombre" type="text" id="nombre" size="40" class="required"  value="<?=$rs_per['nombre']?>"/></td>

            </tr>

            <tr>

                <td>No. Cuenta</td>

                <td colspan="2"><input name="num_cuenta" type="text" id="num_cuenta" size="40" class="required"  value="<?=$rs_per['num_cuenta']?>"/></td>

            </tr>

            <tr>

                <td>Entidad</td>

                <td colspan="2"><input name="entidad" type="text" id="entidad" size="40" class="required"  value="<?=$rs_per['entidad']?>"/></td>

            </tr>

            <tr>

                <td>Tipo Cuenta</td>

                <td colspan="2">
                	<select name="tipo_cuenta" id="tipo_cuenta">
                        
                        <option value="AHORROS" <?=($rs_per['tipo_cuenta']=='AHORROS')?'selected':''?>>Ahorros</option>
                        <option value="CORRIENTE" <?=($rs_per['tipo_cuenta']=='CORRIENTE')?'selected':''?>>Corriente</option>
                    </select>    
                </td>

            </tr>
            
            <?php if($rs_per['tipo_persona'] == 'contratista'): ?>
            
            <tr class="content_contratista">
                <td>Contacto</td>
                <td colspan="2">
                	<input name="contacto" type="text" id="contacto" size="40" value="<?=$rs_per['contacto']?>"/>
                </td>
            </tr>
            
			<tr class="content_contratista">
                <td>Tel&eacute;fono/celular</td>
                <td colspan="2">
                	<input name="telefono" type="text" id="telefono" size="40" value="<?=$rs_per['telefono']?>"/>
                </td>
            </tr>
            
            <tr class="content_contratista">
                <td>Direcci&oacute;n</td>
                <td colspan="2">
                	<input name="direccion" type="text" id="direccion" size="40" value="<?=$rs_per['direccion']?>"/>
                </td>
            </tr>
            
            <tr class="content_contratista">
                <td>R&eacute;gimen</td>
                <td colspan="2">
                    <select name="regimen" id="regimen">
                		<option value="COM&Uacute;N" <?=($rs_per['regimen']=='COMÚN')?'selected':''?>>Com&uacute;n</option>
                        <option value="SIMPLIFICADO" <?=($rs_per['regimen']=='SIMPLIFICADO')?'selected':''?>>Simplificado</option>
                    </select>
                </td>
            </tr>
            
            <tr class="content_contratista">
                <td>Correo</td>
                <td colspan="2">
                	<input name="correo" type="text" id="correo" size="40" value="<?=$rs_per['correo']?>"/>
                </td>
            </tr>
            
            <tr class="content_contratista">
                <td>No. Contrato</td>
                <td colspan="2">
                	<input name="contrato" type="text" id="contrato" size="40" value="<?=$rs_per['num_contrato']?>"/>
                </td>
            </tr>

            <? endif; ?>

            <? if(in_array(194, $_SESSION['permisos'])): ?>
            <tr>
            	<td>Cambio estado:</td>
                <td colspan="2">
                	<select name="cambio_estado" id="cambio_estado">
                    	<option value="0" <?=($rs_per['estado']==0)?'selected':''?>>Activo</option>
                        <option value="1" <?=($rs_per['estado']==1)?'selected':''?>>Inactivo</option>
                    </select>		                
                </td>
            </tr>
            <? endif; ?>

        </tbody>       

    </table>

    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
		
        <? if(in_array(192, $_SESSION['permisos'])): ?>
    	<input name="agregar" type="submit" id="agregar" value="Modificar" class="btn_table" onclick="fn_modificar();"/>
       	<? endif; ?>

        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>

	</div>

</form>

<script language="javascript" type="text/javascript">

$(document).ready(function(){

		$(".btn_table").jqxButton({ theme: theme });

		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente modificar este beneficiario?')

				if (respuesta)

					form.submit();

			}

		});
		
		$('.tipo_trabajo').change(function(){
			
			if($('input[name=tipo_trabajo]:checked').val() == 2){
				$('.content_tipotrabajo').hide();
				$('.content_tipotrabajo input[type=checkbox]').prop("checked", "");
			}else
				$('.content_tipotrabajo').show();
			
		});
		
		$('.tipo_persona').change(function(){
			
			var tipo = $('input[name=tipo_persona]:checked').val();
			
			if(tipo == 'contratista'){
				$('.content_contratista').find('input').val('');
				$('.content_contratista').show();
			}else{
				$('.content_contratista').find('input').val('');
				$('.content_contratista').hide();
			}
			
		});

});

	

	function fn_modificar(){

		var str = $("#frm_per").serialize();

		$.ajax({

			url: 'ajax_modificar.php',

			data: str,

			type: 'post',

			success: function(data){

				if(data != "") {

					alert(data);

				}else{

					fn_cerrar();	

					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

				}

			}

		});

	};

</script>