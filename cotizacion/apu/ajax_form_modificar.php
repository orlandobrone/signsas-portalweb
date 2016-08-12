<?  header('Content-type: text/html; charset=iso-8859-1');

	session_start();

	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";

	$sql = sprintf("SELECT * FROM apu WHERE id=%d",
		(int)$_POST['ide_per']
	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){
		echo "No existen APU con ese ID";
		exit;
	}
	
	$rs_per = mysql_fetch_assoc($per);


	$letters = array('.');
	$fruit   = array('');		
	

	$resultado = mysql_query("SELECT * FROM apu_costos WHERE apu_id =".$_POST['ide_per']) or die(mysql_error());

	$total = mysql_num_rows($resultado);

	/*while ($rows = mysql_fetch_assoc($resultado)):

	

	endwhile;*/

	

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

<style>
.list_combo{ display:none; }
</style>



<h1>Formato de APU</h1> 

<div style="width:100%;">

    <p>Por favor rellene el siguiente formulario</p>
    
    <form action="javascript: fn_modificar();" method="post" id="frm_per">
    	<input type="hidden"  name="action" value="edit" readonly="readonly" />
         <table>
            <tbody>
                 <tr>
                     <td>ID APU:</td>
                     <td>
                        <input type="text" id="id_apu" name="id_apu" value="<?=$rs_per['id']?>" readonly="readonly" />
                     </td>
                 </tr>
                 <tr>
                     <td>Descripci&oacute;n:</td>
                     <td>
                       <textarea name="descripcion" cols="30" rows="6"><?=$rs_per['descripcion']?></textarea>
                     </td>
                 </tr>
             </tbody> 
          </table> 
    </form>
</div>


<div style="width:100%;">
    <form action="javascript: fn_agregar_item();" method="post" id="frm_item">
    
        	<input type="hidden" id="id_apu" name="id_apu" value="<?=$rs_per['id']?>" />
    
         	<h3>Ingreso APU Costos</h3>
    
            <table>
                <tbody>      
                
                    <tr>
                        <td>Tipo Costo:</td>    
                        <td>   
                            <select name="tipo_costos" id="tipo_costos" class="chosen-select required">
                                <option value="">Seleccionar..</option>
                                <option value="1">Costo Item</option>
                                <option value="2">Costo Propio Cliente</option>
                                <option value="3">Costo Personal</option>
                            </select> 
                        </td>   
                           
                        <td>Costo:</td>    
                        <td>    
                            <select name="costo_id" id="costo_id" class="chosen-select required var_ordenes">
                                <option value="0">Seleccionar..</option>
                                <option value="1">1</option>
                            </select>       
                        </td>
                    </tr> 
                    
                    <tr><td>&nbsp;</td></tr>           	
    
                    <tr>
                       <td>Valor a la Fecha:</td>
                       <td>
                         <input type="text" name="valor_a_la_fecha" id="valor_a_la_fecha" class="required"  style="background:#CCC"/> 
                       </td>            
                    </tr> 
                    
                   <tr>
                        <td colspan="2"><input name="agregar" type="submit" id="agregar" value="Agregar Item" class="btn_table"/></td>
                   </tr>
    
                </tbody>   
         </table> 
     </form>


	<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>

</div>  
  


    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
    
          <?php if($_SESSION['modificar_anticipo'] == true ): ?>
    
           <input name="update" type="button" id="update" value="Actualizar" class="btn_table" /> 
    
          <?php endif; ?>                 
    
           <input name="btn_print" type="button" id="btn_print" value="Imprimir" class="btn_table" /> 
           <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();"  class="btn_table" />                  
    </div>



</div>



<script type="text/javascript">

$(document).ready(function () {

            var source =
            {
                 datatype: "json",
                 datafields: [
 						 { name: 'id', type: 'number'},
						 { name: 'tipo_costos', type: 'string'},
						 { name: 'valor_a_la_fecha', type: 'string'},
						 { name: 'fecha_ingreso', type: 'date'},
						 { name: 'costo_id', type: 'string'}						 

                ],
				updaterow: function (rowid, rowdata, commit) {

                    // synchronize with the server - send update command

                    // call commit with parameter true if the synchronization with the server is successful 

                    // and with parameter false if the synchronization failder.

                    commit(true);

                },
				cache: false,
			    url: 'ajax_list_items.php?id_apu=<?=$_POST['ide_per']?>',
				root: 'Rows',
				sortcolumn: 'id',
                sortdirection: 'desc',
				filter: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid2").jqxGrid('updatebounddata', 'filter');

				},

				sort: function()

				{

					// update the grid and send a request to the server.

					$("#jqxgrid2").jqxGrid('updatebounddata', 'sort');

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

                width: 640,

				height: 260,

                source: dataadapter,

				editable: true,

                showfilterrow: false,

                pageable: true,

                filterable: false,

                theme: theme,

				sortable: true,

                rowsheight: 25,

                columnsresize: true,

				virtualmode: true,

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},                

                columns: [ 

				  		  { text: '-', datafield: 'acciones', filtertype: 'none', width:40, cellsalign: 'center', editable: false },

						  { text: 'ID Item', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal', width: 60,  columntype: 'textbox', editable: false },

						  { text: 'Tipo Costo', datafield: 'tipo_costos', columntype: 'dropdownlist', filtertype: 'textbox', editable: false },

						  { text: 'Valor a la Fecha', datafield: 'valor_a_la_fecha', filtertype: 'none', width: 130, cellsalign: 'right' },

						  { text: 'Fecha Ingreso', datafield: 'fecha_ingreso', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },

						  { text: 'Costo ID', datafield: 'costo_id', filtertype: 'none', width: 130, cellsalign: 'right' }

                ]

            });			

            $("#jqxgrid2").on('cellendedit', function (event) {

                var args = event.args;
				var id = $("#jqxgrid2").jqxGrid('getcellvalue',args.rowindex, 'id');
				if(args.datafield == 'fecha'){
					var formattedDate = $.jqx.dataFormat.formatdate(args.value, 'yyyy-MM-dd');
					args.value = formattedDate
				}

		   		$.ajax({

					  type: 'POST',

					  dataType: 'json',

					  url: 'ajax_update_item.php',

					  data: {

						  		id_item: id,

								campo: args.datafield,

								valor: args.value

				      },

					  success: function(data){	

						  if (data.estado == true){ 

							 

						  }

					  }

				 });

		   

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

		

		$('#update').click(function(){ $("#frm_per").submit(); })	

		

		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente modificar estos parametros?')

				if (respuesta)

					form.submit();

			}

		});

		$("#frm_item").validate({
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

				var respuesta = confirm('\xBFDesea realmente agregar este item?')

				if (respuesta)

					form.submit();

			}

		});

		$('#btn_print').click(function(){

			$(".btn_actions, .agregar_item_content, #jqxgrid2").hide(); 			

			var gridContent = $("#jqxgrid2").jqxGrid('exportdata', 'html');

			$('#grid_html').html(gridContent);

			$("#content_form").printArea();

			fn_cerrar(); 

		});	

		

		

		$('#orden_trabajo').change(function(){ 

			var orden;

			$('#hitos').empty();

			var proyecto = $( "#orden_trabajo" ).val();			

			

			$.getJSON('ajax_list_hitos_orden.php', {id_proyecto:proyecto}, function (data) { 

					if(data != null){

						var options = $('#hitos');

						$('#hitos').empty();

						$('#hitos').append('<option value="">Seleccione..</option>');				

						

						$.each(data, function (i, v) { 

							options.append($("<option></option>").val(v.id).text(v.orden));

						});
						$("#hitos").trigger("chosen:updated");
					}else{ 
						alert('No se encontraron hitos para esta orden de trabajo');
						$('#hitos').empty();
						$('#hitos').append('<option value="">Seleccione..</option>');
						$("#hitos").trigger("chosen:updated");
					}

			});

		});

	});


	function replaceAll( text, busca, reemplaza ){

	  while (text.toString().indexOf(busca) != -1)

		  text = text.toString().replace(busca,reemplaza);

	  return text;

	}
	
	
	function fn_agregar_item(){ 

		  var str = $("#frm_item").serialize();	

		  $.ajax({
				type: 'POST',
				dataType: 'json',
				url: 'ajax_agregar_item.php', 
				data: str,
				success: function(data){	
					if (data.estado == true){ 
					   $("#jqxgrid2").jqxGrid('updatebounddata');
					}else{
						alert(data.message);
					}
				}
		  });

   }

</script>