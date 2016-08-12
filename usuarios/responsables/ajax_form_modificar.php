<? header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){

		echo "Por favor no altere el fuente";

		exit;

	}



	include "../extras/php/basico.php";

	include "../../conexion.php";



	$sql = sprintf("select * from responsables where id=%d",

		(int)$_POST['ide_per']

	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existen usuarios con ese ID";

		exit;

	}

	

	$rs_per = mysql_fetch_assoc($per);

	

?>

<h1>Modificando usuario</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />

    <table class="formulario">

       <tbody>
       
       		<tr>
              <td>Regi&oacute;n</td>
              <td>
              	 <? $sqlPry = "SELECT * FROM regional ORDER BY region ASC"; 
                    $qrPry = mysql_query($sqlPry);
                 ?>
                 <select class="chosen-select required" name="regional">
                 	 <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                        <option value="<?=$rsPry['id']?>" <?=($rsPry['id']==$rs_per['id_regional'])? 'selected="selected"': '';?>><?=$rsPry['region']?></option> 

                     <? } ?>
                 </select>   
              </td>
            </tr>

            <tr>
                <td>Nombre</td>
                <td>
                	<input name="nombre" type="text" id="nombre" size="40" class="required" value="<?=$rs_per['nombre']?>" />
                </td>
            </tr>
            
            <tr>
                <td>Cedula</td>
                <td>
                	<input name="cedula" type="text" id="cedula" size="40" class="required" alt="integer" value="<?=$rs_per['cedula']?>"/>
                </td>
            </tr>        

         
           <? if(in_array(424, $_SESSION['permisos'])): ?>
           <tr>
            	<td>Cambio estado:</td>
                <td>
                	<select name="cambio_estado" id="cambio_estado">
                    	<option value="0" <?=($rs_per['estado']==0)?'selected':''?>>Activo</option>
                        <option value="1" <?=($rs_per['estado']==1)?'selected':''?>>Inactivo</option>
                    </select>
                </td>
            </tr>
            <? endif; ?>
                   
       
        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">
					<? if(in_array(392,$_SESSION['permisos'])): ?>
                    <input name="modificar" type="submit" id="modificar" value="Modificar" />
					<? endif; ?>
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />

                </td>

            </tr>

        </tfoot>

    </table>

</form>

<link rel="stylesheet" href="/js/chosen/chosen.css">

<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		

		$("#frm_per select").chosen({width:"250px"});

		$("#frm_per").validate({

			submitHandler: function(form) {

						var respuesta = confirm('\xBFDesea realmente modificar a este usuario?')

						if (respuesta)

							form.submit();

			}

		});
		
		/*var url = "ajax_data_regiones.php";
		// prepare the data
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'id' },
				{ name: 'region' }
			],
			id: 'id',
			url: url,
			async: false,
			root: 'Rows'
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		// Create a jqxDropDownList
		$("#jqxWidget").jqxDropDownList({ checkboxes: true, source: dataAdapter, displayMember: "region", valueMember: "id", width: 250, height: 32});
		//
		<? foreach($arrayCheck as $index=>$row):
				if($row == 1):
		?>
				$("#jqxWidget").jqxDropDownList('checkIndex', <?=$index?>);
		<? endif; endforeach ?>
		// subscribe to the checkChange event.
		/*$("#jqxWidget").on('checkChange', function (event) {
			if (event.args) {
				var item = event.args.item;
				if (item) {
					/*var valueelement = $("<div></div>");
					valueelement.text("Value: " + item.value);
					var labelelement = $("<div></div>");
					labelelement.text("Label: " + item.label);
					var checkedelement = $("<div></div>");
					checkedelement.text("Checked: " + item.checked);
					$("#selectionlog").children().remove();
					$("#selectionlog").append(labelelement);
					$("#selectionlog").append(valueelement);
					$("#selectionlog").append(checkedelement);*/
					
					/*var items = $("#jqxWidget").jqxDropDownList('getCheckedItems');
					var checkedItems = "";					
					$.each(items, function (index) {
						checkedItems += this.value+",";                          
					});
					//$("#checkedItemsLog").text(checkedItems);
					$("#id_regional").val(checkedItems);
				}
			}
		});*/

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