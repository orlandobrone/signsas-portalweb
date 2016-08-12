<? header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){

		echo "Por favor no altere el fuente";

		exit;

	}



	include "../extras/php/basico.php";

	include "../../conexion.php";
	
	session_start();



	$sql = sprintf("select * from vehiculos where id=%d",

		(int)$_POST['ide_per']

	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existen vehiculo con ese ID";

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



<!-- The main CSS file -->

<link href="/js/upload/assets/css/style.css" rel="stylesheet" />

<style>

#frm_per input{

	width:80px;

}

table.formulario, #upload { margin:0 !important; }

</style>



<h1>Modificando Veh&iacute;culo</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per" style="float:left; width:338px;margin-right: 30px;">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />

    <table class="formulario">

        <tbody>

            <tr>

                <td>Placa</td>

                <td><input name="placa" type="text" id="placa" size="6" class="required" value="<?=$rs_per['placa']?>" /></td>

            </tr>

            <tr>

                <td>Marca</td>

                <td><input name="marca" type="text" id="marca" size="40" class="required" value="<?=$rs_per['marca']?>" /></td>

            </tr>

        	<tr>

                <td>Fecha Vencimiento SOAT:</td>

                <td><input name="soat" type="text" id="soat" size="40" class="required fechas" value="<?=$rs_per['soat']?>"/>

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "soat",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr> 

            

            <tr>

                <td>Fecha revisi&oacute;n TM:</td>

                <td><input name="tm" type="text" id="tm" size="40" class="required fechas" value="<?=$rs_per['tm']?>"/>

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "tm",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador2"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr> 

            

            <tr>

                <td>Fecha &uacute;ltimo cambio de aceite:</td>

                <td><input name="aceite" type="text" id="aceite" size="40" class="required fechas" value="<?=$rs_per['aceite']?>"/>

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador3" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "aceite",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador3"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr> 

            

            <tr>

                <td>Regi&oacute;n</td>

                <td><input type="hidden" name="lugeje" id="lugeje" size="40" value="<?=$rs_per['region']?>"/>

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

                <td>Valor Hora:</td>

                <td><input name="valor_hora" type="text" id="valor_hora" size="40" class="required" alt="integer" value="<?=$rs_per['valor_hora']?>"/></td>

            </tr>
            
            <tr>
				
                <td>Estado:</td> 
                <td>
                	<select name="estado" id="estado" class="required chosen-select">
                    	<option value="0" <?=($rs_pai['region']==0)? 'selected':'';?>>Activo</option>
                        <option value="1" <?=($rs_pai['region']==1)? 'selected':'';?>>No Activo</option>
                        <option value="2" <?=($rs_pai['region']==2)? 'selected':'';?>>Mantenimiento</option>
       					<? if($_SESSION['vehiculos_eliminar']): ?>
							<option value="3" <?=($rs_pai['estado']==3)? 'selected':'';?>>Eliminado</option>	
                        <? endif;?>                
                        
                    </select>
				</td>
            </tr>

        </tbody>

    </table>

    <div id="plantillas">

    <?php

		if(unserialize($rs_per['planillas']) != false):

			foreach(unserialize($rs_per['planillas']) as $file){	

				

			?>

  		<input type="hidden" class="pos_<?=$file?>" name="plantillas[]" value="<?=$file?>">

    <?php

			} 

		endif;

	?>

    </div>

</form>



<!-- Our main JS file -->

<script src="/js/upload/assets/js/script.js"></script>



<form id="upload" method="post" action="/upload.php" enctype="multipart/form-data" style="float:left;margin-left: 65px;">

	<h3 style="color:#FFF;">Plantillas (Suba aca sus archivos):</h3>

    <div id="drop">Coloque aqu&iacute;

        <a>Buscar</a>

        <input type="file" name="upl" multiple />

    </div>



    <ul>

    

    <?php


		if(unserialize($rs_per['planillas']) != false):

			foreach(unserialize($rs_per['planillas']) as $file){

				if($file != 'undefined'):
				
					$sql4 = "SELECT * FROM `uploads` WHERE id = ".$file;
					$pai4 = mysql_query($sql4); 
					$rs_pai4 = mysql_fetch_assoc($pai4);

			?>

				

                <li class="pos_<?=$file?>">

                    <div style="display:inline;width:48px;height:48px;"><canvas width="48" height="48px"></canvas>

                    <input type="text" value="0" data-width="48" data-height="48" data-fgcolor="#0788a5" 

                           data-readonly="1" data-bgcolor="#3e4043" readonly 

                           style="width: 28px; height: 16px; position: absolute; vertical-align: middle; margin-top: 16px; margin-left: -38px; 

                                   border: 0px; background-image: none; font-weight: bold; font-style: normal; 

                                   font-variant: normal; font-size: 9px; line-height: normal; font-family: Arial; text-align: 

                                   center; color: rgb(7, 136, 165); padding: 0px; -webkit-appearance: none; background-position: initial initial; 

                                   background-repeat: initial initial;"></div><p><?=$rs_pai4['file']?><i><?=$rs_pai4['size']?> KB</i></p>

                           <a href="javascript:" style="" class="manager ref_<?=$file?>" data_file="<?=$file?>" data="<?=$file?>">x</a>

                </li>

                

            <?php	

				//$files .= '<a href="javascript:" data="'.$file.'" class="delete_img">Eliminar</a>-><a target="_blank" href="/archivos/'.$rs_pai4['file'].'">'.$rs_pai4['file'].'</a><br/>';
				endif; 
			}

		else:

			$files = 'N/A';

		endif;

		

		

	?>

    </ul>

</form>



<div style="clear:both;"></div>



<div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
		<? if(in_array(282,$_SESSION['permisos'])): ?>
    	<input name="modificar" type="submit" id="modificar" value="Modificar" class="btn_table"/>
		<? endif; ?>
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>

</div>

                

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		

		$('input').setMask();

		

		$(".btn_table").jqxButton({ theme: theme });

		

		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente agregar a este nuevo veh\xCDculo?');

				if (respuesta)

					form.submit();

			}

		});

		$('#modificar').click(function(){

			$('#frm_per').submit();

		});

		

		$(".delete_img").click(function(){

			var id = $(this).attr('data');

			

			$(this).remove();

			

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