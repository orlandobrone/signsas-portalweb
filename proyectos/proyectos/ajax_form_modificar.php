<? header('Content-type: text/html; charset=iso-8859-1');
	
	session_start();
	
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

                <td><?=$rs_per['nombre']?></td>

            </tr>

            <tr>

                <td>Descripci&oacute;n</td>

                <td><input name="descri" type="text" id="descri" size="40" class="required" value="<?=$rs_per['descripcion']?>" /></td>

            </tr>

            <tr>

                <td>Cliente</td>

                <td>

						<?
                            $sql2 = "SELECT nombre FROM cliente WHERE id = ".$rs_per['id_cliente'];
							$pai2 = mysql_query($sql2); 
							$rs_pai2 = mysql_fetch_assoc($pai2);	

                        ?>

                        <?=$rs_pai2['nombre']?>


					</select>

                </td>

            </tr>

            <tr>

                <td>Regi&oacute;n</td>

                <td>
						<?

                            $sql = "select region from regional WHERE id = ".$rs_per['id_regional'];
                            $pai = mysql_query($sql);
                            $rs_pai = mysql_fetch_assoc($pai);
                        ?>

                        <?=$rs_pai['region']?>
                </td>

            </tr>
            
            <?php
            
            	$sqlr = "SELECT nombre, (SELECT nombre FROM actividad WHERE id = ".$rs_per['actividad_id'].") AS actividad
				 FROM linea_negocio where id = ".$rs_per['linea_negocio_id'];
				$pair = mysql_query($sqlr); 
				$rs_pair = mysql_fetch_assoc($pair);
		
			?>	
            
            <tr>

                <td>Linea de Negocio</td>

                <td>
                        <?=$rs_pair['nombre']?>
                </td>

            </tr>
            
            <tr>

                <td>Actividad</td>

                <td>
                        <?=$rs_pair['actividad']?>
                </td>

            </tr>
			
            <? if($_SESSION['perfil'] == 5): ?>
          
            <tr>

                <td>Estado</td>

                <td><select name="estado" id="estado" class="required chosen-select">

                		<option value=""></option>

                        <option value="E" <? if('E'==$rs_per['estado']) echo "selected='selected'";?>>En ejecuci&oacute;n</option>

                        <option value="F" <? if('F'==$rs_per['estado']) echo "selected='selected'";?>>Facturado</option>

                        <option value="P" <? if('P'==$rs_per['estado']) echo "selected='selected'";?>>Pendiente de Facturaci&oacute;n</option>
                        
                        <? if($_SESSION['proyecto_eliminar']): ?>
                    	<option value="1" <?=($rs_per['estado']=='ELIMINADO')?'selected':''?>>Eliminado</option>
            			<? endif; ?>

                	</select>

                </td>

            </tr>

            <?  
			endif;
			
			$fecha_inicio = explode("-", $rs_per['fecha_inicio']);

			$fecha_inicio = $fecha_inicio[2] . "/" . $fecha_inicio[1] . "/" . $fecha_inicio[0];

			?>

            <tr>

                <td>Fecha de Inicio</td>

                <td><input name="fecini" type="text" id="fecini" size="40" class="required" value="<?=$rs_per['fecha_inicio']?>" readonly />

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

                <td><input name="fecfin" type="text" id="fecfin" size="40" class="required" value="<?=$rs_per['fecha_final']?>" readonly />

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecfin",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador2"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr>
            
           

           
        </tbody>

        </table>

        <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
		<? if(in_array(112,$_SESSION['permisos'])): ?>
				<input name="agregar" type="submit" id="agregar" value="Actualizar" class="btn_table"/>
		<? endif; ?>
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