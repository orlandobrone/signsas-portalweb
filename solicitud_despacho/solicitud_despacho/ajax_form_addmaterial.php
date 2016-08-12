<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		//exit;
	}
?>
<!-- librería grilla --> 
<link rel="stylesheet" type="text/css" media="all" href="/js/flexigrid.css" title="win2k-cold-1">
<link rel="stylesheet" href="/js/chosen/chosen.css">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/flexigrid.js"></script>

<style type="text/css">
	  .delete{ background:url('https://cdn1.iconfinder.com/data/icons/diagona/icon/16/101.png') no-repeat; }
	  .excel{  background:url('https://cdn1.iconfinder.com/data/icons/fatcow/16/page_white_excel.png') no-repeat; }
</style>


<h1>Agreagar Materiales</h1>
<div style="position:relative;"  class="box-material">
	<h1>Agregando salida de mercancia</h1>
	<p>Por favor rellene el siguiente formulario</p>
    <form action="javascript: fn_agregar();" method="post" id="frm_per">
    	<input type="hidden" value="<?=$_POST['ide_per']?>" name="id_despacho"/>
        <input type="hidden" value="0" name="cantidadPendiente" id="cantidadPendiente"/>
        <table class="formulario">
            <tbody>
                <tr>
                    <td>Material</td>
                    <td colspan="2">
						<? $sqlMat = sprintf("SELECT * FROM inventario ORDER BY nombre_material ASC");
                                $perMat = mysql_query($sqlMat);
                                $num_rs_per_mat = mysql_num_rows($perMat); ?>
                       <select class="chosen-select" tabindex="2" name="material">
                            <option value="">Seleccione una opci&oacute;n</option>
                            <? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?>
                            <option value="<? echo $rs_per_mat['id']; ?>"><?php echo $rs_per_mat['nombre_material']; ?></option>
                            <? } ?>
                        </select>
                    </td>
                    <td>
                    	<a href="javascript:" id="btn_agregar_material">Agregar Material</a>
                    </td>
                </tr>
                <tr>
                    <td>Cantidad Existente:</td>
                    <td><input type="text" name="cantidadInv" id="cantidadInv" value="0" readonly/></td>
                    
                    <td>Cantidad Solicitada:</td>
                    <td><input name="cantidad" type="text" id="cantidad" class="required solicitud" alt="zip"/></td>
                    
                </tr>
                <tr>
                    <td>Costo:</td>
                    <td><input type="text" name="costoInv" id="costoInv" value="0" readonly alt="signed-decimal"/></td>
                    
                    <td>Costo Solicitado:</td>
                    <td>
                    	<input name="costo_solicitado" type="text" id="costo_solicitado" class="required solicitud" readonly alt="integer"/>
                    </td>
                </tr>
                
                <tr>
                	<td>Descripci&oacute;n:</td>
                    <td><textarea id="descripcion" name="descripcion" cols="50" rows="3" style="width: 253px;" disabled="disabled"></textarea></td>
                    <td><div class="alert-box"></div></td>
                </tr>
               
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>
                        <input name="cancelar" type="button" id="cancelar" value="Terminar" onclick="fn_cerrar();" class="btn_table"/>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>


<div class="add-material" style="display:none;">
    <h1>Agregando nuevo material</h1>
    <p>Por favor rellene el siguiente formulario</p>
    <form action="javascript: fn_agregar_material();" method="post" id="frm_add_material">
        <table class="formulario">
            <tbody>
                <tr>
                    <td>Nombre Material</td>
                    <td><input name="nommat" type="text" id="nommat" size="40" class="required" /></td>
                </tr>
                <tr>
                    <td>Descripci&oacute;n</td>
                    <td><input name="descri" type="text" id="descri" size="40" class="required" /></td>
                </tr>
                <tr>
                    <td>Cantidad</td>
                    <td><input name="cantid" type="text" id="cantid" size="40" class="required" /></td>
                </tr>
                <tr>
                    <td>Costo Unitario</td>
                    <td><input name="cosuni" type="text" id="cosuni" size="40" class="required" alt="decimal-us" /></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>
                        <input name="cancelar" type="button" id="btn-cancelar" value="Cancelar" class="btn_table" />
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<div style="clear:both;"></div>

<div style="margin-bottom:20px;">
	<table id="flex1" style="display: none"></table>
</div>



<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		
		$(".chosen-select").chosen({width:"520px"});
		$(".btn_table").jqxButton({ theme: theme });
		
		$(".chosen-select").change(function(){
			$(".solicitud").val('');
			var idMaterial = $(this).val();
			$.getJSON('/ajax/listMaterial.php',{id:idMaterial}, function (data) {
				$.each(data, function (i, v) {					
					$('#'+i).val(v);
				});
			});
		});
		
		$('#cantidad').keyup(function(){		
						
			if($(this).val() != ''){
				
				var cantidad = parseInt($(this).val());
				var cantidadInv = parseInt($('#cantidadInv').val());
				var solicitarCompra = 0;
				
				if(cantidad <= cantidadInv){
					$('.alert-box').removeClass('warning');
					$('.alert-box').addClass('success');
					$('.alert-box').html('<span>OK:</span>&nbsp;En existencia.');
					$('.alert-box').slideDown('slow');
					$('#cantidadPendiente').val(0);
				}else{
					solicitarCompra = cantidad - cantidadInv;
					$('.alert-box').removeClass('success');
					$('.alert-box').addClass('warning');
					$('.alert-box').html('<span>Advertencia:</span>&nbsp;No hay existencia.<br/>Solicitar Comprar:'+solicitarCompra);
					$('.alert-box').slideDown('slow');
					$('#cantidadPendiente').val(solicitarCompra);
				}				
				
				var costoInv = parseFloat($('#costoInv').val());			
				var costo_solicitado =  parseFloat(costoInv * cantidad);		
				$('#costo_solicitado').val(costo_solicitado);
				$('#costo_solicitado').setMask();
				
			}else{
				$('#costo_solicitado').val('');
				$('.alert-box').removeClass('success');
				$('.alert-box').addClass('warning');
				$('.alert-box').html('<span>Advertencia:</span>&nbsp;Debe ingresar una cantidad');
				$('.alert-box').slideDown('slow');
			}
			
		});
		
		$('#btn_agregar_material').click(function(){
			$('.box-material').slideUp();
		 	$('.add-material').slideDown('slow');	
		});
		
		$('#btn-cancelar').click(function(){
			$('.add-material').slideUp();
		 	$('.box-material').slideDown('slow');	
		});
		
		
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
					var respuesta = confirm('\xBFRealmente desea agregar este material?')
					if (respuesta)
						form.submit();		
			}
		});
		
		/* Validacion del formulario agregar materiales */
		$("#frm_add_material").validate({
			rules:{
				usu_per:{
					required: true,
					remote: "/inventario/inventario/ajax_verificar_usu_per.php"
				}
			},
			messages: {
				usu_per: "x"
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente agregar este nuevo material?')
				if (respuesta)
					form.submit();
			}
		});
				
		
		$("#flex1").flexigrid({
			url: '/ajax/listMateriales.php?id=<?=$_POST['ide_per']?>',
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'id', width : 40, sortable : false, align: 'center'},
				{display: 'Material', name : 'material', width : 200, sortable : false, align: 'center'},
				{display: 'Cantidad', name : 'cantidad', width : 60, sortable : false, align: 'left'},
				{display: 'Costo', name : 'costo', width : 150, sortable : false, align: 'left'},
				{display: 'Estado', name : 'estado', width : 150, sortable : false, align: 'left'}				
			],
			buttons : [				
				{name: 'Borrar', bclass: 'delete', onpress : fn_borrar},
				{name: 'Exportar a Excel', bclass: 'excel', onpress : ExportarExcel}
			],
			/*searchitems : [		
				{display: 'No Documento', name : 'cedula', isdefault: true}
			],*/
			sortname: "id",
			sortorder: "asc",
			usepager: true,
			title: 'Lista de Materiales - Solicitud de Despacho', 
			rp: 15,
			showTableToggleBtn: true,
			width: 900,
			height: 250
		}); 
		
	});
	
	function fn_agregar(){ 
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_agregar_material.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "") {
					alert(data);
				}else{ 
					$('.alert-box').slideUp();
					$('#frm_per').reset();
					$("#flex1").flexReload();
				}
			}
		});
	};
	
	function fn_agregar_material(){
		var str = $("#frm_add_material").serialize();
		$.ajax({
			url: '/inventario/inventario/ajax_agregar.php',
			data: str,
			type: 'post',
			success: function(data){ $(".chosen-select").trigger("chosen:updated");
				if(data != "") {
					alert(data);
				}else{
					listChose();					
				}
			}
		});
	};
	
	function listChose(){
	
		$.getJSON('/ajax/choseMaterial.php', function (data) {
				var options = $('.chosen-select'); 
				$('.chosen-select').empty()
				$('.chosen-select').append('<option value="">Seleccione una opcion</option>');	
				
				$.each(data, function (i, v) {
					options.append($("<option></option>").val(v.id).text(v.label));
				});
				//$(".chosen-institucion").chosen();
				
				$(".chosen-select").trigger("chosen:updated");
				$('.add-material').slideUp();
		 		$('.box-material').slideDown('slow');
		});		
	
	}
	function fn_borrar(com, grid){
                
	  var conf = confirm('Delete ' + $('.trSelected', grid).length + ' items?')
	  if(conf){
		  $('.trSelected', grid).each(function() {
		  		  var id = $(this).attr('id');
				  id = id.substring(id.lastIndexOf('row')+3);
				  $.post('ajax_delete_material.php', { IdDelete: id}, function(){
						  // when ajax returns (callback), update the grid to refresh the data
						  $("#flex1").flexReload();
				  });
		  });    
	  }
	}
	
	function ExportarExcel(){
					var data='<table>'+$("#flex1").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
						$('body').prepend("<form method='post' action='/exporttoexcel.php' style='display:none' id='ReportTableData'><input type='text' name='tableData' value='"+data+"' ></form>");
						 $('#ReportTableData').submit().remove();
						 return false;
	}
	
	jQuery.fn.reset = function () {
	  $(this).each (function() { this.reset(); });
	}

</script>

 