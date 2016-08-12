<?  header('Content-type: text/html; charset=iso-8859-1');
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	
	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("select * from po where id=%d",
		(int)$_POST['ide_per']
	);
	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen un P.O con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);
	$id_po= $rs_per['id'];
	
?>
<!--Hoja de estilos del calendario -->
<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">

<!-- librería principal del calendario -->
<script type="text/javascript" src="../../calendario/calendar.js"></script>

<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="../../calendario/calendar-es.js"></script>

<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

<style>
.alert-box { margin:0 !important; } 
</style>

<div style="position:relative;"  class="box-material">

<h1>Formato de Ingreso P.O</h1>
<p>Por favor ingrese los datos en el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
<input type="hidden" id="id_po" name="id_po" value="<?=$id_po?>" />
<table>
        <tbody>
        	<tr>        
                <td>No:</td>
                <td>
                 <input type="text" name="no" id="no" size="40" class="required" value="<?=$rs_per['no']?>"/>                
                </td>      
        	 <tr>
                <td>Fecha Inicio:</td>
                <td><input name="fecha_inicio" type="text" id="fecha_inicio" readonly="readonly required" value="<?=$rs_per['fecha_inicio']?>"/>
                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_inicio",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador"   // el id del botón que lanzará el calendario
					});
				</script>
                </td>
          </tr>
          <tr>
                <td>Fecha Final:</td>
                <td><input name="fecha_final" type="text" id="fecha_final" readonly="readonly required" value="<?=$rs_per['fecha_final']?>"/>
                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />
				<script type="text/javascript">
					Calendar.setup({
						inputField     :    "fecha_final",      // id del campo de texto
						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
						button         :    "lanzador2"   // el id del botón que lanzará el calendario
					});
				</script>
                </td>               
            </tr> 
           
            
            <tr>        
                <td>Valor Mantenimiento:</td>
                <td>
                 <input type="text" name="valor_mantenimiento" id="valor_mantenimiento" value="<?=$rs_per['valor_mantenimiento']?>" size="40" class="required money"/>                
                </td>
           </tr>
           <tr>     
                <td>Valor Suministro:</td>
                <td>
                 <input type="text" name="valor_suministro" id="valor_suministro" size="40" value="<?=$rs_per['valor_suministro']?>" class="required money"/>                
                </td> 
           </tr>
           <tr>     
                <td>Valor Total:</td>
                <td>
                 <input type="text" name="valor_total" id="valor_total" value="<?=$rs_per['valor_total']?>" size="40" class="required" readonly="readonly"/>                
                </td> 
           </tr>         
                      
        </tbody>
    </table>  
</form>

<div style="display:none;">
<h3>Agregar items</h3>
   
<p>Por favor ingrese los datos en el siguiente formulario</p>
	<form action="javascript: fn_agregar_item();" method="post" id="form_item">
    
            <input type="hidden" value="<?=$id_po?>" name="id_po"/>
            <table class="formulario">
                <tbody>
                    <tr>
                        <td>Proyectos:</td>
                        <td colspan="2">
                            <? $sqlMat = sprintf("SELECT id,nombre FROM proyectos ORDER BY id DESC");
                                    $perMat = mysql_query($sqlMat);
                                    $num_rs_per_mat = mysql_num_rows($perMat); ?>
                           <select class="chosen-select" tabindex="2" name="id_proyecto" id="id_proyecto">
                                <option value="">Seleccione una opci&oacute;n</option>
                                <? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?>
                                <option value="<? echo $rs_per_mat['id']; ?>"><?php echo $rs_per_mat['nombre']; ?></option>
                                <? } ?>
                            </select>
                        </td>
                       
                    </tr>  
                </tbody>                  
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <input name="agregar" type="submit" id="agregar" value="Agregar Item" class="btn_table"/>
                        </td>
                        <td colspan="2"><div class="alert-box"></div></td>
                    </tr>
                </tfoot>
            </table>
    </form>
</div>
	<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>
 
      
    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar(<?=$id_despacho?>);"  class="btn_table"/>                   
    </div>
</div>




<link rel="stylesheet" href="/js/chosen/chosen.css">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 

<script type="text/javascript">
$(document).ready(function () {
	
		    $(".money").maskMoney({ prefix:'$', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			
            var source =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'id_proyecto', type: 'string'},								
					 { name: 'acciones', type: 'string'}						 
                ],				
				cache: false,
			    url: 'ajax_data_items.php?id=<?=$id_po?>', 
				root: 'Rows',
				sortcolumn: 'id',
                sortdirection: 'desc',
				filter: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
				},
				sort: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
				},
				root: 'Rows',
				beforeprocessing: function(data)
				{		
					if (data != null)
					{
						source.totalrecords = data[0].TotalRows;					
					}
				}
				};		
				var dataadapter = new $.jqx.dataAdapter(source, {
					loadError: function(xhr, status, error)
					{
						alert(error);
					}
				}
				);

            var dataadapter = new $.jqx.dataAdapter(source);

            $("#jqxgrid2").jqxGrid({
                width: '100%',
				height: 260,
                source: dataadapter,
                showfilterrow: true,
                pageable: true,
                filterable: true,
                theme: theme,
				sortable: true,
                columnsresize: true,
				virtualmode: true,
				autorowheight: true,
                autoheight: true,
				rendergridrows: function(obj)
				{
					 return obj.data;      
				},      
				//fn_aprobar_allitems          
                columns: [
				  { text: '-', datafield: 'acciones', filtertype: 'none', width:'10%', cellsalign: 'center', sortable:false },
                  { text: 'ID Item', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox' },
                  { text: 'Proyecto', datafield: 'id_proyecto',  filtertype: 'textbox', filtercondition: 'starts_with' }
                ]
            });			
           
			//$("#excelExport").jqxButton({ theme: theme });
            //$('#clearfilteringbutton').jqxButton({ height: 25, theme: theme });
           /* $('#clearfilteringbutton').click(function () {

                $("#jqxgrid2").jqxGrid('clearfilters');
            });*/
			/*$("#excelExport").click(function () {
                $("#jqxgrid2").jqxGrid('exportdata', 'xls', 'Lista Items');           
            });*/
});
</script>      


<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		
		$(".chosen-select").chosen({width:"220px"}); 
		$('input').setMask();	
		$(".btn_table").jqxButton({ theme: theme });
		
		/* Validacion del formulario agregar materiales */
		$("#form_item").validate({
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
					var respuesta = confirm('\xBFRealmente desea agregar este item?')
					if (respuesta)
						form.submit();		
			}
		});
		
		/*function fn_agregar_item(){ 
			var str = $("#form_material").serialize();
			$.ajax({
				url: 'ajax_agregar_material.php',
				data: str,
				type: 'post',
				success: function(data){
					if(data != "") {
						alert(data);
					}else{ 
						$('.alert-box').slideUp();
						$('#form_material').reset();
						$("#jqxgrid2").jqxGrid('updatebounddata');
					}
				}
			});
		};*/
		$('.money').blur(function(){
			$.post('ajax_operacion.php',{valor_mantenimiento:$('#valor_mantenimiento').val(), valor_suministro:$('#valor_suministro').val()},function(data){
				$('#valor_total').val(data);
			});
		});
		
		/*--------------------------------------------------------------------------------------*/
		
		$('#modificar').click(function(){
			$("#frm_per").submit(); 
		});
		
		$("#frm_per").validate({
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente ingresar estos parametros?')
				if (respuesta)
					form.submit();
			}
		});
		
		
	});
	
	
	function replaceAll( text, busca, reemplaza ){
	  while (text.toString().indexOf(busca) != -1)
		  text = text.toString().replace(busca,reemplaza);
	  return text;
	}

	
	
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
				}
			},
			error: function(err) {
				alert(err);
			}
		});
	};
	
	
	function fn_agregar_item(){ 
		var str = $("#form_item").serialize();
		$.ajax({
			url: 'ajax_agregar_item.php',
			data: str,
			type: 'post',
			success: function(data){				
				$("#jqxgrid2").jqxGrid('updatebounddata');
			}
		}); 
	};
	
	function fn_eliminar_item(ide_per){
		var respuesta = confirm("Desea eliminar este item");
		if (respuesta){
			$.ajax({
				url: 'ajax_eliminar_item.php',
				data: 'id=' + ide_per,
				type: 'post',
				success: function(data){
					if(data!=""){
						alert(data);
					}
					$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
				}
			});
		}
	}
	
	
	jQuery.fn.reset = function () {
	  $(this).each (function() { this.reset(); });
	}

</script>