<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
?>
<!--Hoja de estilos del calendario -->
<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">

<!-- librería principal del calendario -->
<script type="text/javascript" src="../../calendario/calendar.js"></script>

<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="../../calendario/calendar-es.js"></script>

<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>
<h1>Agregando nuevo proyecto</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Descripci&oacute;n</td>
                <td><input name="descri" type="text" id="descri" size="40" class="required" /></td>
            </tr>
            <tr>
                <td>Cliente</td>
                <td>
                	<select name="client" ide="client" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from cliente order by id asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>"><?=$rs_pai['nombre']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
            <tr>
            	<td>Centro Costo:</td>
                <td>
                    <? $sqlPry = "SELECT * FROM centros_costos ORDER BY sigla ASC"; 
                    $qrPry = mysql_query($sqlPry);
                    ?>
                    <select name="centros_costos" id="centros_costos" class="chosen-select required var_ordenes">
                    	<option value=""></option>
                        <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                        <option value="<?=$rsPry['id']?>"><?=$rsPry['sigla']?> / <?=$rsPry['nombre']?></option>
                        <? } ?>
                    </select>            
                </td>            
            </tr>  
            <tr>
                <td>Regi&oacute;n</td>
                <td><input type="hidden" name="lugeje" type="text" id="lugeje" size="40" />
                	<select name="id_regional" id="id_regional" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from regional ORDER BY region ASC";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>"><?=$rs_pai['region']?></option>
                        <? } ?>
					</select>
                </td>
            </tr>
           <!-- <tr>
                <td>Sitio</td>
                <td>
                	<select name="sitio" id="sitio" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from sitios ORDER BY nombre_rb ASC";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>"><?=$rs_pai['nombre_rb']?></option>
                        <? } ?>
					</select>
                
                </td>
            </tr>-->
            <tr>
                <td>Estado</td>
                <td><select name="estado" id="estado" class="required chosen-select">
                		<option value=""></option>
                        <option value="E">En ejecuci&oacute;n</option>
                        <option value="F">Facturado</option>
                        <option value="P">Pendiente de Facturaci&oacute;n</option>
                	</select>
                </td>
            </tr>
            <tr>
                <td>Fecha de Inicio</td>
                <td><input name="fecini" type="text" id="fecini" size="40" class="required" readonly="readonly" />
                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecini",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador"   // el id del botón que lanzará el calendario
					});
				</script></td>
            </tr>
            <tr>
                <td>Fecha de Finalizaci&oacute;n<br /></td>
                <td><input name="fecfin" type="text" id="fecfin" size="40" class="required" readonly="readonly" />
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
                <td>Cotizaci&oacute;n</td>
                <td>
                	<select name="cotiza" ide="cotiza" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from cotizacion where estado<>'otorgado' order by id asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>"><?=$rs_pai['nombre']?></option>
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
		$('#id_regional').change(function(){ 
			$('#lugeje').val($('#id_regional option:selected').text());
		});
		
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
				var respuesta = confirm('\xBFDesea realmente agregar este nuevo proyecto?')
				if (respuesta)
					form.submit();
			}
		});
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