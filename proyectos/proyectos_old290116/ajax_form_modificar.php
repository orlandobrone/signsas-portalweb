<? header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	
	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from proyectos where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen proyectos con ese ID";
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
<h1>Modificando  Proyecto</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="requisssred" value="<?=$rs_per['nombre']?>" /></td>
            </tr>
            <tr>
                <td>Descripci&oacute;n</td>
                <td><input name="descri" type="text" id="descri" size="40" class="required" value="<?=$rs_per['descripcion']?>" /></td>
            </tr>
            <tr>
                <td>Cliente</td>
                <td>
                	<select name="client" ide="client" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from cliente order by nombre asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>" <? if($rs_pai['id']==$rs_per['id_cliente']) echo "selected='selected'";?>><?=$rs_pai['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            <tr>
                <td>Regi&oacute;n</td>
                <td><input type="hidden" name="lugeje" type="text" id="lugeje" size="40" value="<?=$rs_per['lugar_ejecucion']?>"/>
                	<select name="id_regional" id="id_regional" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from regional ORDER BY region ASC";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>" <? if($rs_pai['id']==$rs_per['id_regional']) echo "selected='selected'";?>><?=$rs_pai['region']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
           <!-- <tr>
                <td>Sitio</td>
                <td><select name="sitio" id="sitio" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from sitios ORDER BY nombre_rb ASC";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>" <?php echo ($rs_per['sitio']==$rs_pai['id']) ? 'selected="selected"': ''; ?>><?=$rs_pai['nombre_rb']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>-->
            <tr>
                <td>Estado</td>
                <td><select name="estado" id="estado" class="required chosen-select">
                		<option value=""></option>
                        <option value="E" <? if('E'==$rs_per['estado']) echo "selected='selected'";?>>En ejecuci&oacute;n</option>
                        <option value="F" <? if('F'==$rs_per['estado']) echo "selected='selected'";?>>Facturado</option>
                        <option value="P" <? if('P'==$rs_per['estado']) echo "selected='selected'";?>>Pendiente de Facturaci&oacute;n</option>
                	</select>
                </td>
            </tr>
            <?  
			$fecha_inicio = explode("-", $rs_per['fecha_inicio']);
			$fecha_inicio = $fecha_inicio[2] . "/" . $fecha_inicio[1] . "/" . $fecha_inicio[0];
			?>
            <tr>
                <td>Fecha de Inicio</td>
                <td><input name="fecini" type="text" id="fecini" size="40" class="required" value="<?=$rs_per['fecha_inicio']?>" readonly="readonly" />
                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecini",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador"   // el id del botón que lanzará el calendario hi lhola
					});
				</script></td>
            </tr>
            <? 
			$fecha_final = explode("-", $rs_per['fecha_final']);
			$fecha_final = $fecha_final[2] . "/" . $fecha_final[1] . "/" . $fecha_final[0];
			?>
            <tr>
                <td>Fecha de Finalizaci&oacute;n</td>
                <td><input name="fecfin" type="text" id="fecfin" size="40" class="required" value="<?=$rs_per['fecha_final']?>" readonly="readonly" />
                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecfin",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador2"   // el id del botón que lanzará el calendario
					});
				</script></td>
            </tr>
            <tr>
            	<td>Centro Costo:</td>
                <td>
                    <? $sqlPry = "SELECT * FROM centros_costos ORDER BY sigla ASC"; 
                    $qrPry = mysql_query($sqlPry);
                    ?>
                    <select name="centros_costos" id="centros_costos" class="chosen-select required var_ordenes">
                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                        <option value="<?=$rsPry['id']?>" <?php echo ($rsPry['id']==$rs_per['id_centroscostos'])? 'selected="selected"': '';?>><?=$rsPry['sigla']?> / <?=$rsPry['nombre']?></option>
                        <? } ?>
                    </select>            
                </td>              
            </tr>
            <tr>
                <td>Cotizaci&oacute;n</td>
                <td>
                	<select name="cotiza" ide="cotiza" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from cotizacion where estado<>'otorgado' or id=" . $rs_per['id_cotizacion'] . " order by nombre asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>" <? if($rs_pai['id']==$rs_per['id_cotizacion']) echo "selected='selected'";?>><?=$rs_pai['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
        </tbody>
        </table>
        <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
				<input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>
                <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>
      </div>
</form>
<link rel="stylesheet" href="/js/chosen/chosen.css">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		
		$(".chosen-select").chosen({width:"250px"});
		$(".btn_table").jqxButton({ theme: theme });
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente modificar este proyecto?')
				if (respuesta)
					form.submit();
			}
		});
		$('#id_regional').change(function(){ 
			$('#lugeje').val($('#id_regional option:selected').text());
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
					fn_buscar();
				}
			}
		});
	};
</script>