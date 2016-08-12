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

<link rel="stylesheet" href="/js/chosen/chosen.css">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 


<h1>FORMATO DE LEGALIZACION DE CAJA MENOR test</h1> 
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
           
            <tr>
                <td>Responable</td>
                <td><input name="responsable" type="text" id="responsable" size="40" class="required" /></td> 
            </tr>
            <tr>
                <td>Fecha</td>
                <td><input name="fecha" type="text" id="fecha" readonly="readonly required" />
                  <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador"   // el id del botón que lanzará el calendario
					});
				</script>
               </td>
            </tr>
            <tr>
                <td>No. de Caja</td>
                <td><input name="num_caja" type="text" id="num_caja" size="40" class="required" alt="integer" /></td>
            </tr>
            <tr>
                <td>Valor fondo / anticipo</td>
                <td><input name="valor_fa" type="text" id="valor_fa" size="40" class="required" alt="decimal" /></td>
            </tr>
            <tr>
                <td>Valor Legalizado</td>
                <td><input name="valor_legalizado" type="text" id="valor_legalizado" size="40" class="required" alt="decimal" /></td>
            </tr>
            <tr>
                <td>Valor a Pagar</td>
                <td><input name="valor_pagar" type="text" id="valor_pagar" size="40" class="required" alt="decimal" /></td>
            </tr>
            <tr>
                <td>Legalizaci&oacute;n (L) o Reintego(R)</td>
                <td><input name="lega_rein" type="text" id="lega_rein" size="40" class="required" alt="decimal" /></td>
            </tr>
            
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="agregar" type="submit" id="agregar" value="Agregar" />
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		
		$("#frm_per select").chosen({width:"220px"}); 
		$('input').setMask();	
		
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
				var respuesta = confirm('\xBFDesea realmente agregar esta legalizacion?')   
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
					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
				}
			}
		});
	};
</script>