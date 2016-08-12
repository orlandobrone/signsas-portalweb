<? header('Content-type: text/html; charset=iso-8859-1');
	
	session_start();
	
	if(empty($_POST['ide_per'])){

		echo "Por favor no altere el fuente";

		exit;

	}

	include "../extras/php/basico.php";

	include "../../conexion.php";


	$sql = sprintf("select * from tecnico where id=%d",

		(int)$_POST['ide_per']

	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existen tecnico con ese ID";

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

<h1>Modificando t&eacute;cnico</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />

    <table class="formulario">

        <tbody>

            <tr>

                <td>Nombre</td>

                <td><input name="nombre" type="text" id="nombre" size="40" class="required" value="<?=$rs_per['nombre']?>" /></td>

            </tr>

            <tr>

                <td>Cedula</td>

                <td><input name="cedula" type="text" id="cedula" size="40" class="required" value="<?=$rs_per['cedula']?>" /></td>

            </tr>

             <tr>

                <td>ARP</td>

                <td><input name="arp" type="text" id="arp" size="40" class="required" value="<?=$rs_per['ARP']?>" /></td>

            </tr>

             <tr>

                <td>EPS</td>

                <td><input name="eps" type="text" id="eps" size="40" class="required" value="<?=$rs_per['EPS']?>" /></td>

            </tr>

            

            <tr>

                <td>Celular</td>

                <td><input name="celular" type="text" id="celular" size="40" class="required" value="<?=$rs_per['celular']?>" /></td>

            </tr>
            
            <tr>

                <td>Regi&oacute;n</td>

                <td><input type="hidden" name="lugeje"  id="lugeje" size="40" value="<?=$rs_per['region']?>"/>

                	<select name="region" id="region" class="required chosen-select">

                    	<option value=""></option>

						<?

                            $sql = "select * from regional ORDER BY region ASC";

                            $pai = mysql_query($sql);

                            while($rs_pai = mysql_fetch_assoc($pai)){

                        ?>

                            <option value="<?=$rs_pai['region']?>" <? if($rs_pai['region']==$rs_per['region']) echo "selected='selected'";?>><?=$rs_pai['region']?></option>

                        <? } ?>

					</select>

                </td>

            </tr>
           

            <tr>

                <td>Cargo</td>

                <td><input name="cargo" type="text" id="cargo" size="40" class="required"  value="<?=$rs_per['cargo']?>" /></td>

            </tr>

           <tr>

                <td>Estado</td>

                <td><select name="estado" id="estado" class="required chosen-select">
                    	<option value=""></option>
                        <option value="1" <?php if($rs_per['estado']==1) echo 'selected'; ?>>Activo</option>
                        <option value="0" <?php if($rs_per['estado']==0) echo 'selected'; ?>>Inactivo</option>
                        
                        <option value="2" <?php if($rs_per['estado']==2) echo 'selected'; ?>>Vacaciones</option>
                        <option value="3" <?php if($rs_per['estado']==3) echo 'selected'; ?>>Incapacitado</option>
                        <option value="4" <?php if($rs_per['estado']==4) echo 'selected'; ?>>Operando</option>
                    </select>
                </td>

            </tr>
            
            <tr>

                <td>Sueldo</td>

                <td><input name="sueldo" type="text" id="sueldo" size="40" class="required" value="<?=$rs_per['sueldo']?>" /></td>

            </tr>
            
            <tr>

                <td>Valor Plan</td>

                <td><input name="valor_plan" type="text" id="valor_plan" size="40" class="required" value="<?=$rs_per['valor_plan']?>"/></td>

            </tr>
            
            <? if(in_array(294,$_SESSION['permisos'])): ?>
        	<tr>
                <td>Cambio Estado:</td>
                <td>
                	<select name="cambio_estado" id="cambio_estado">
                    	<option value="1" <?=($rs_per['estado_registro']==1)?'selected':''?>>Eliminado</option>
                        <option value="0" <?=($rs_per['estado_registro']==0)?'selected':''?>>NO Eliminado</option>
                    </select>					
                </td>
            </tr>
            <? endif; ?>

             

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">
					<? if(in_array(292,$_SESSION['permisos'])): ?>
                    <input name="modificar" type="submit" id="modificar" value="Modificar" />
                    <? endif; ?>

                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />

                </td>

            </tr>

        </tfoot>

    </table>

    

</form>

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		

		$(".money").maskMoney({ prefix:'$', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

		

		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente modificar este t\xE9cnico?')  

				if (respuesta)

					form.submit();

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

					fn_buscar();

				}

			},

			error: function(err) {

				alert(err);

			}

		});

	};

</script>