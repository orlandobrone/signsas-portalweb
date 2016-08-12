<?  header('Content-type: text/html; charset=iso-8859-1');
	session_start();	
	
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	include "../extras/php/basico.php";
	include "../../conexion.php";
	
	$sql = sprintf("select factor from hitos where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen hitos con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
			
?>

<style>
	form#frm_per input{ width:150px; }
</style>
<h1>Modificando Factor Financiero</h1>
<p>En el siguiente formulario cambie el factor financiero si es necesario</p>

<table class="formulario">
    <tbody>        	
        <tr>
            <td>Factor Financiero</td>
            <td>
               <input name="factor" id="factor" type="text" value="<?=$rs_per['factor']?>"  />
            </td>
        </tr>        
        
    </tbody>
</table>

<div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
        <input name="modificar" type="botton" id="openhito" value="Abrir Hito" class="btn_table"/>
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>
</div>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
		
	$(".btn_table").jqxButton({ theme: theme });		
	
	$("#openhito").click(function(){
		$.ajax({
				url: 'ajax_ilimitado_hito.php',
				data: { id: <?=(int)$_POST['ide_per']?>, type:'unlock', factor: $("#factor").val() },
				type: 'post',
				success: function(data){
					if(data != '')				
						swal("Error", data, "error");
					else
						fn_cerrar();						
				}
		});
	});
});
</script>