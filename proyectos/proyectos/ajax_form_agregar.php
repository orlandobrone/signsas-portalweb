<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";
	session_start();
	
	$resultado = mysql_query("SELECT id_regional FROM usuario WHERE id = " .$_SESSION['id']); 
	$row = mysql_fetch_assoc($resultado);	
	
	
	/*$regional = explode(',',$row['id_regional']);	
	$count_regional = count($regional);	
	
	if($count_regional >= 1):
		$sqlr = "SELECT * FROM regional WHERE id = ".$row['id_regional'];
        $pair = mysql_query($sqlr); 
		$rs_pair = mysql_fetch_assoc($pair);
	else :
		
	endif;*/
	
	$idRegionales  = 0;
	$sqlPry = "SELECT id_regional FROM usuario WHERE id = ".$_SESSION['id']; 
	$qrPry = mysql_query($sqlPry);
	$rs_pai = mysql_fetch_assoc($qrPry);
	
	
	if((int)$rs_pai['id_regional'] == 26):
		$sqlR = "SELECT * FROM regional WHERE 1"; 
	else:	
		$idRegionales = explode(',',$rs_pai['id_regional']);
		$idRegionales = count($idRegionales);	
		
		if($idRegionales > 1):		
			$sqlR = "SELECT * FROM regional WHERE id IN(".$rs_pai['id_regional'].")"; 
		else:
			$sqlR = "SELECT * FROM regional WHERE id = ".$rs_pai['id_regional']; 
		endif;
	endif;
	
	//echo $sqlR;
	$resultR000 = mysql_query($sqlR);		
	$filotas00 = mysql_num_rows($resultR000);	
	
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
                <td>
                	<input name="nombre" type="text" id="nombre" size="40" class="required" value="OT-REGIONAL-CLIENTE-CENTROCOSTO-<?=date('Y')?>-MES-#" readonly/>
                </td>
            </tr>

            <tr>
                <td>Descripci&oacute;n</td>
                <td><input name="descri" type="text" id="descri" size="40" class="required" /></td>
            </tr>
			
            <? if($filotas00 > 1): ?>
            <tr>
                <td>Regi&oacute;n</td>

                <td><input type="hidden" name="lugeje" type="text" id="lugeje" size="40" />

                	<select name="id_regional" id="id_regional" class="required chosen-select">

                    	<option value=""></option>

						<?
                            while($rowR = mysql_fetch_assoc($resultR000)){
                        ?>

                            <option value="<?=$rowR['id']?>" sigla="<?=$rowR['sigla']?>"><?=$rowR['region']?></option>

                        <? } ?>

					</select>

                </td>

            </tr>
            <? else: 
					$rowR = mysql_fetch_assoc($resultR000);
					$regionalSigla = $rowR['sigla'];
			?>
            
            <tr>
                <td>Regi&oacute;n</td>

                <td>
                	<input type="hidden" name="lugeje" type="text" id="lugeje" size="40" value="<?=$rowR['region']?>" />
                    <input type="hidden" name="id_regional" id="id_regional" value="<?=$rowR['id']?>"/>
                    
					<?=$rowR['region']?>
                </td>
            </td> 
            <? endif; ?>
            
            <tr>
                <td>Cliente</td>
                <td>
                	<select name="client" id="client" class="required chosen-select">
                    	<option value=""></option>
						<?
                            $sql = "select * from cliente order by id asc";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>

                            <option value="<?=$rs_pai['id']?>" numero="<?=$rs_pai['numero_amigable']?>"><?=$rs_pai['numero_amigable'].'-'.$rs_pai['nombre']?></option>

                        <? } ?>

					</select>

                </td>
            </tr>
            
			<!--
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
            -->

            

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

            </tr>

            <tr>
                <td>Estado</td>
                <td><select name="estado" id="estado" class="required chosen-select">

                		<option value=""></option>

                        <option value="E">En ejecuci&oacute;n</option>

                        <option value="F">Facturado</option>

                        <option value="P">Pendiente de Facturaci&oacute;n</option>

                	</select>

                </td>
            </tr> -->
            
            <tr>
                <td>Actividad</td>
                <td>                	
                	<select name="actividad" id="actividad" class="required chosen-select">
                    	<option value=""></option>
                    	<?  $sql = "select * from linea_negocio WHERE id NOT IN(1,2,3,4,5) ORDER BY codigo ASC";
                            $pai = mysql_query($sql);
                            while($rs_pai = mysql_fetch_assoc($pai)){
                        ?>
                            <option value="<?=$rs_pai['id']?>" codigo="<?=$rs_pai['codigo']?>"><?=$rs_pai['codigo'].'-'.$rs_pai['nombre']?></option>
                        <? } ?>            
                    </select>
                </td>
           </tr>
           <tr>
                <td>Sub - Actividad</td>
                <td>                	
                	<select name="subactividad" id="subactividad" class="subactividad required chosen-select">
                    	<option value=""></option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Mes</td>
                <td>                	
                	<select name="mes" id="mes" class="required chosen-select">
                    	<option value=""></option>
                        <option value="ENERO">Enero</option>
                        <option value="FEBRERO">Febrero</option>
                        <option value="MARZO">Marzo</option>
                        <option value="ABRIL">Abril</option>
                        <option value="MAYO">Mayo</option>
                        <option value="JUNIO">Junio</option>
                        <option value="JULIO">Julio</option>
                        <option value="AGOSTO">Agosto</option>
                        <option value="SEPTIEMBRE">Septiembre</option>
                        <option value="OCTUBRE">Octubre</option>
                        <option value="NOVIEMBRE">Noviembre</option>
                        <option value="DICIEMBRE">Diciembre</option>                             
                    </select>  
                </td>
            </tr>
            
            <tr>

                <td>Fecha de Inicio</td>

                <td><input name="fecini" type="text" id="fecini" size="40" class="required" readonly />

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

                <td><input name="fecfin" type="text" id="fecfin" size="40" class="required" readonly />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecfin",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador2"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr>

            
			<!--
            <tr style="display:none;">

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
		    -->
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
	
		var defecto = 'OT-';
		
		<? if($filotas00 == 1):  ?>
		var regional = '<?=$regionalSigla?>-';
		<? else: ?>
		var regional = 'REGIONAL-';
		<? endif; ?>
		
		var cliente = 'CLIENTE-';
		var centrocosto = 'CENTROCOSTO-';
		var year = '<?=date('Y')?>-';
		var mes = 'MES-';
		
		var actividad = '';
		var subactiviad = '';

		$(".chosen-select").chosen({width:"250px"});
		$(".btn_table").jqxButton({ theme: theme });
		$('#id_regional').change(function(){ 
			$('#lugeje').val($('#id_regional option:selected').text());
		});
		
		
		//Si cambia cliente
		$('#id_regional').change(function(){ 
			//alert( $('#client option:selected').attr('numero') );
			//alert( $(this).chosen().attr('numero') );	
			regional = $('#id_regional option:selected').attr('sigla')+'-';
			generarNombre();
		});
		
		//Si cambia cliente
		$('#client').change(function(){ 
			//alert( $('#client option:selected').attr('numero') );
			//alert( $(this).chosen().attr('numero') );	
			cliente = $('#client option:selected').attr('numero')+'-';
			generarNombre();
		});

		function generarNombre(){
			console.log(defecto+regional+cliente+centrocosto+year+mes+'-#');
			$('#nombre').val(defecto+regional+cliente+centrocosto+year+mes+'-#');
		}

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
		

	$("#actividad").change(function(){
		
		var value = $(this).val();			
		centrocosto = 'CENTROCOSTO-';
		actividad = $('#actividad option:selected').attr('codigo');
		generarNombre();
							
		loaderSpinner();	
		
		$.getJSON('ajax_lista_subactividades.php', { id:value }, function (data) {
		
			  var options = $('.subactividad');
		
			  $('.subactividad').empty();
			  $('.subactividad').append('<option value="">Seleccione..</option>');
			  $('.subactividad').removeAttr('disabled');				
			  
			  if(data.length > 0){
				  $.each(data, function (i, v) { 
					  options.append($("<option></option>")
										.val(v.id)
										.text(v.nombre)
										.attr('codigo',v.codigo)
					  );
				  });				 					  
			  }			  
			  stoploaderSpinner();
			  $('.chosen-select').trigger("chosen:updated");					 
		});				
	});
	
	
	$("#subactividad").change(function(){			
		subactiviad = $('#subactividad option:selected').attr('codigo');
		centrocosto = actividad+''+subactiviad+'-';
		generarNombre();		
	});
	
	
	$("#mes").change(function(){			
		mes = $('#mes option:selected').val();
		generarNombre();		
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