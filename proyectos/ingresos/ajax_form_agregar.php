<?  header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	
	$sql = sprintf("INSERT INTO `ingresos` (id, estado) VALUES (NUll, 'draft');");

	if(!mysql_query($sql)){
		echo "Error al insertar un nuevo Ingreso:\n$sql"; 
		exit;
	}
	
	$id_ingreso = mysql_insert_id();
	
	//$id_ingreso = 1;
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
table.formulario {
margin: 0px !important;
}
</style>

<div style="position:relative;"  class="box-material">
<h1>Formato de Ingreso</h1>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
<input type="hidden" id="id_ingreso" name="id_ingreso" value="<?=$id_ingreso?>" />
<input type="hidden" id="id_po2" name="id_po"/>
<table>
        <tbody>
        	<tr>
            	<td>Proyecto:</td>
                <td>
                  <? 	$sqlMat = sprintf("SELECT * FROM proyectos ORDER BY id DESC");
                        $perMat = mysql_query($sqlMat);
                        $num_rs_per_mat = mysql_num_rows($perMat); 
				   ?>
                   <select class="chosen-select" name="id_proyecto" id="id_proyecto">
                        <option value="">Seleccione...</option>
                        <? while ($rs_per_mat = mysql_fetch_assoc($perMat)) { ?>
                        <option value="<?=$rs_per_mat['id']; ?>"><?=$rs_per_mat['nombre'];?></option>
                        <? } ?>
                    </select>
                </td>
                <td>Cliente:</td>
                <td>
                   <select class="chosen-select" name="id_cliente" id="id_cliente">
                        <option value="">Seleccione...</option>
                    </select>
                </td>
                
            </tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
                <td>Saldo MT</td>
                <td>Saldo SM</td>
            </tr>    
            
            <tr>
                <td>P.O:</td>
                <td>
                   <select class="chosen-select" tabindex="2" id="id_po">
                        <option value="">Seleccione...</option>
                    </select>
                </td>
                
                <td>
                 <input type="text" name="saldo_mt" id="saldo_mt" size="20" readonly="readonly"/>                
                </td>
                <td>
                 <input type="text" name="saldo_sm" id="saldo_sm" size="20" readonly="readonly"/>                
                </td>
               
            </tr>      
            
        	<tr>        
                <td>GR:</td>
                <td>
                 <input type="text" name="gr" id="gr" size="40"/>                
                </td>
            </tr>     
        </tbody>
    </table>  
</form>

<h3>Agregar items</h3>
   
<form action="javascript: fn_agregar_item();" method="post" id="form_item">
    	    <input type="hidden"  id="id_proyecto2" name="id_proyecto"/>
            <input type="hidden"  value="<?=$id_ingreso?>" name="id_ingreso"/>
            <input type="hidden" name="saldo_mt" id="saldo_mt2" readonly="readonly"/>                
            <input type="hidden" name="saldo_sm" id="saldo_sm2" readonly="readonly"/>                
            
            <table class="formulario">
                <tbody>
                	<tr>
                    	<td>Hitos</td>
                        <td>Descripci&oacute;n</td>
                	</tr>
                    <tr>
                        <td>
                           <select class="chosen-select" tabindex="2" name="id_hitos" id="id_hitos"></select>
                        </td>
                        <td>
                         <input type="text" name="descripcion_hito" id="descripcion_hito" size="40" class="required"/>                		</td>
                    </tr>     
                        
                    <tr>
                        <td>Fecha Terminaci&oacute;n hito:</td>
                        <td>Valor:</td>
                   </tr>
                   <tr>
                        <td><input name="fecha_term_hito" type="text" id="fecha_term_hito" readonly="readonly required" />
                        <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField     :    "fecha_term_hito",      // id del campo de texto
                                ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                button         :    "lanzador"   // el id del botón que lanzará el calendario
                            });
                        </script>
                		</td>
                        <td>
                         	<input type="text" name="valor" id="valor" size="40"  class="money required"/>                
                        </td>
                        <td>
                            <input name="agregar" type="submit" id="agregar" value="Agregar Item" class="btn_table"/>
                        </td>
                    </tr> 
                    <tr>
                    	<td>
                        	<div id="mensaje" style="display:none; color:#C30;"></div>
                        </td>
                    </tr>                
                
            </table>
    </form>
	<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>
      
    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
        <input name="modificar" type="submit" id="modificar" value="Guardar" class="btn_table" />
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar(<?=$id_despacho?>);"  class="btn_table"/>                   
    </div>
</div>




<link rel="stylesheet" href="/js/chosen/chosen.css">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 

<script type="text/javascript">
$(document).ready(function () {
	
			$('#id_proyecto').change(function(){
				$.getJSON('ajax_list_po.php',{id_proyecto:$(this).val()},function(data){
						var options = $('#id_po');
						$('#id_po').empty();						
						$('#id_po').append('<option>Seleccione..</option>');
										
						if(data.estate == 'true'){	
							$.each(data.rows, function (i, v) { 
								options.append($("<option valor_m="+v.mt+"  valor_s="+v.sm+"></option>").val(v.value).text(v.label));
							});
						}else{
							alert(data.mensaje);
						}
						$("#id_po").trigger("chosen:updated");
				});
				
				$.getJSON('ajax_list_clientes.php',{id_proyecto:$(this).val()},function(data){
						var options = $('#id_cliente');
						$('#id_cliente').empty();						
						$('#id_cliente').append('<option>Seleccione..</option>');
										
						if(data.estate == 'true'){	
							$.each(data.rows, function (i, v) { 
								options.append($("<option></option>").val(v.value).text(v.label));
							});
						}else{
							alert(data.mensaje);
						}
						$("#id_cliente").trigger("chosen:updated");
				});
				
			});
			
			
			$('#id_po').change(function(){
				$('#id_po2').val($(this).val());
				
				var valor_m = $('#id_po option:selected').attr('valor_m');
				var valor_s = $('#id_po option:selected').attr('valor_s');
				
				$('#saldo_mt, #saldo_mt2').val(valor_m);
				$('#saldo_sm, #saldo_sm2').val(valor_s);
			});
			
			
			
			$('#id_ordentrabajo').change(function(){
				$('#id_ordentrabajo2').val($(this).val());
			})
	
		    $(".money").maskMoney({ prefix:'$', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			
            var source =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'id_hito', type: 'number'},
					 { name: 'id_hitos', type: 'string'},
					 { name: 'descripcion_hito', type: 'string'},
					 { name: 'fecha_term_hito', type: 'date'},
					 { name: 'valor', type: 'string'},								
					 { name: 'acciones', type: 'string'}						 
                ],				
				cache: false,
			    url: 'ajax_data_items.php?id=<?=$id_ingreso?>', 
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
				height: 220,
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
				pagesize: 5,
				rendergridrows: function(obj)
				{
					 return obj.data;      
				},      
				//fn_aprobar_allitems          
                columns: [
				  { text: '-', datafield: 'acciones', filtertype: 'none', width:'10%', cellsalign: 'center', sortable:false, width:50 },
                  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', width:50 },
				  { text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', filtercondition: 'equal',  columntype: 'textbox', width:50 },
				  { text: 'Nombre Hito', datafield: 'id_hitos', filtertype: 'textbox',  filtercondition: 'starts_with' },
				  { text: 'Descripci&oacute;n', datafield: 'descripcion_hito', filtertype: 'textbox',  filtercondition: 'starts_with' },
				  { text: 'Fecha Terminaci&oacute;n', datafield: 'fecha_term_hito', filtertype: 'date', filtercondition: 'equal', width: 90, cellsformat: 'yyyy-MM-dd' },
                  { text: 'Valor', datafield: 'valor',  filtertype: 'textbox', filtercondition: 'none', width:100 }
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
		
		
		$('#id_proyecto').change(function(){ 
			var orden;
			$('#id_proyecto2').val($('#id_proyecto').val()); 
			
			$.getJSON('/anticipos/anticipo/ajax_list_hitos_orden.php', {id_proyecto:$(this).val()}, function (data) { 
					if(data != null){
						var options = $('#id_hitos');
						$('#id_hitos').empty();
						$('#id_hitos').append('<option value="">Seleccione..</option>');				
						
						$.each(data, function (i, v) { 
							options.append($("<option></option>").val(v.id).text(v.orden));
						});
						
						$("#id_hitos").trigger("chosen:updated");
						
					}else{ 
						alert('No se encontraron hitos para esta orden de trabajo');
						$('#id_hitos').empty();
						$('#id_hitos').append('<option value="">Seleccione..</option>');
						$("#id_hitos").trigger("chosen:updated");
					
					}
			});
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
		var saldo_mt2 = $('#saldo_mt2').val();
		var saldo_sm2 = $('#saldo_sm2').val();
		
		if(saldo_mt2 != '' && saldo_sm2 != ''){
			var str = $("#form_item").serialize();
			$.ajax({
				url: 'ajax_agregar_item.php',
				data: str,
				type: 'post',
				success: function(data){
					var obj = jQuery.parseJSON( data ); 
					if(obj.estado == true){
						$('#id_po').attr('disabled','disabled');
						$("#id_po").trigger("chosen:updated");
						$('#saldo_mt, #saldo_mt2').val(obj.saldo_mt);
						$('#saldo_sm, #saldo_sm2').val(obj.saldo_sm);	
						$("#jqxgrid2").jqxGrid('updatebounddata');
					}else{
						$('#mensaje').html(obj.mensaje).slideDown();
					}
				}
			}); 
		}else{
			$('#mensaje').html('Debe seleccionar un P.O').slideDown();
		}
		
		setTimeout(function(){ $('#mensaje').slideUp(); },3000);
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