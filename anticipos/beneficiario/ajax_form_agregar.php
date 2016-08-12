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

<h1>Agregando Beneficiario</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario">

        <tbody>
        
        	<tr>
                <td colspan="2">Tipo Persona</td>              
            </tr>
            
            <tr>

                <td colspan="2">
                	Beneficiario <input type="radio" name="tipo_persona" class="tipo_persona required" value="beneficiario" checked>
                </td>
                <td colspan="2">
               		Contratista <input type="radio" name="tipo_persona" class="tipo_persona required" value="contratista">
                </td>
                
            </tr>
            
            <tr>
            	<td colspan="2">HSQE:</td> 
            </tr>
            <tr>
            	<td colspan="2">Lista Clinton:</td>
                <td colspan="2">SGSS:</td>
            </tr>
            <tr>
                <td colspan="2">
                	SI <input type="radio" name="clinton" class="clinton required" value="0" checked>
                	NO <input type="radio" name="clinton" class="clinton required" value="1">
                </td>
            
                <td colspan="2">
                	SI <input type="radio" name="sgss" class="clinton required" value="0" checked>
                	NO <input type="radio" name="sgss" class="clinton required" value="1">
                </td>
            </tr>
            
            <tr>
            	<td>Tipo Trabajo:</td>
            </tr>
            <tr>
                <td colspan="4">
                	SI <input type="radio" name="tipo_trabajo" class="tipo_trabajo required" value="0" checked>
                	NO <input type="radio" name="tipo_trabajo" class="tipo_trabajo required" value="1">
               
                	No Aplica <input type="radio" name="tipo_trabajo" class="tipo_trabajo required" value="2">
                </td>
            </tr>
            
            <!--Alturas-->
            <tr class="content_tipotrabajo">
            	<td colspan="2">
                	<input type="checkbox" name="check_tipo_trabajo[]" value="Altura"> Trabajo Alturas
                </td>
         
            	<td colspan="2">
               		<input type="checkbox" name="check_tipo_trabajo[]" value="Electrico"> Trabajo Riesgo El&eacute;ctrico
                </td>
            </tr>
            <tr class="content_tipotrabajo">
            	<td colspan="2">
                	<input type="checkbox" name="check_tipo_trabajo[]" value="Soldadura"> Soldadura
                </td>
            	<td colspan="2">
                	<input type="checkbox" name="check_tipo_trabajo[]" value="Espacio"> Espacio Confinado
                </td>
            </tr>
            <!--fin de alturas-->
           
            <tr>

                <td>Identificaci&oacute;n</td>

                <td colspan="2"><input name="identificacion" type="text" id="identificacion" size="40" class="required" />
                </td>

            </tr>

            <tr>

                <td>Nombre</td>

                <td colspan="3"><input name="beneficiario" type="text" id="beneficiario" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>No. Cuenta</td>

                <td colspan="3"><input name="num_cuenta" type="text" id="num_cuenta" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Entidad</td>

                <td colspan="3"><input name="entidad" type="text" id="entidad" size="40" class="required" /></td>

            </tr>

            <tr>
                <td>Tipo Cuenta</td>
                <td colspan="3">
                	<select name="tipo_cuenta" id="tipo_cuenta" class="required">
                		<option value="AHORROS">Ahorros</option>
                        <option value="CORRIENTE">Corriente</option>
                    </select>    
                </td>
            </tr>
            
            

			<tr class="content_contratista">
                <td>Contacto</td>
                <td colspan="3">
                	<input name="contacto" type="text" id="contacto" size="40"/>
                </td>
            </tr>
            
			<tr class="content_contratista">
                <td>Tel&eacute;fono/celular</td>
                <td colspan="3">
                	<input name="telefono" type="text" id="telefono" size="40"/>
                </td>
            </tr>
            
            <tr class="content_contratista">
                <td>R&eacute;gimen</td>
                <td colspan="3">
                    <select name="regimen" id="regimen">
                		<option value="" selected>Seleccione</option>
                        <option value="COM&Uacute;N">Com&uacute;n</option>
                        <option value="SIMPLIFICADO">Simplificado</option>
                    </select>    
                </td>
            </tr>
            
            
            <tr class="content_contratista">
                <td>Direcci&oacute;n</td>
                <td colspan="3">
                	<input name="direccion" type="text" id="direccion" size="40"/>
                </td>
            </tr>
            
            
            <tr class="content_contratista">
                <td>Correo</td>
                <td colspan="3">
                	<input name="correo" type="text" id="correo" size="40"/>
                </td>
            </tr>
            
            <tr class="content_contratista">
                <td>No. Contrato</td>
                <td colspan="3">
                	<input name="contrato" type="text" id="contrato" size="40"/>
                </td>
            </tr>
           
        </tbody>       

    </table>

    

    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

    	<input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>

        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>

	</div>

</form>

<style>
.content_contratista{
	display:none;
}
</style>


<script language="javascript" type="text/javascript">

$(document).ready(function(){
		
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
		$(".btn_table").jqxButton({ theme: theme });

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

				var respuesta = confirm('\xBFDesea realmente agregar este Beneficiario?')

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
});

	

	function fn_agregar(){

		var str = $("#frm_per").serialize();

		$.ajax({

			url: 'ajax_agregar.php',

			data: str,

			type: 'post',

			success: function(data){

				if(data != "") {
					
					swal({   
						title: "Oops",   
						text: data,   
						type: "error",   
						showCancelButton: false,   
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Ok, entendido!",   
						closeOnConfirm: true 
					});
					//alert(data);

				}else{

					fn_cerrar();	

					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

				}

			}

		});

	};

</script>