<? header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";	

	$sql = sprintf("INSERT INTO `apu` (`id`,`estado`)
					VALUES (NULL, 'draft');");


	if(!mysql_query($sql)){
		echo "Error al insertar una nueva APU:\n$sql"; 
		exit;
	}	

	$id_apu = mysql_insert_id();

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

table{ table-layout: fixed;word-wrap: break-word; }

</style>


<h1>Formato de APU</h1> 

<div style="width:100%;">

    <p>Por favor rellene el siguiente formulario</p>
    
    <form action="javascript: fn_modificar();" method="post" id="frm_per">
         <table>
            <tbody>
                 <tr>
                     <td>ID APU:</td>
                     <td>
                        <input type="text" id="id_apu" name="id_apu" value="<?=$id_apu?>" readonly="readonly" />
                     </td>
                 </tr>
                 <tr>
                     <td>Descripci&oacute;n:</td>
                     <td>
                       <input type="text" name="descripcion" id="descripcion" />
                     </td>
                 </tr>
             </tbody> 
          </table> 
    </form>
</div>

<div style="width:100%;">
    <form action="javascript: fn_agregar_item();" method="post" id="frm_item">
    
        	<input type="hidden" id="id_apu" name="id_apu" value="<?=$id_apu?>" />
    
         	<h3>Ingreso APU Costos</h3>
    
            <table>
                <tbody>      
                
                    <tr>
                        <td>Tipo Costo:</td>    
                        <td>   
                            <select name="tipo_costo" id="tipo_costo" class="chosen-select required">
                                <option value="">Seleccionar...</option>
                                <option value="1">Costo Item</option>
                                <option value="2">Costo de Personal</option>
                                <option value="3">Costo Propio Cliente</option>
                                
                            </select> 
                        </td>   
                           
                        <td>Costo:</td>    
                        <td>    
                            <select name="costo_id" id="costo_id" class="chosen-select required var_ordenes">
                                <option value="0">Seleccionar...</option>
                                <option value="1">Prueba</option>
                            </select>       
                        </td>
                    </tr> 
                    
                    <tr><td>&nbsp;</td></tr>           	
    
                    <tr>
                       <td>Valor a la Fecha:</td>
                       <td>
                         <input type="text" name="valor_a_la_fecha" value="3000" id="valor_a_la_fecha" class="required" readonly="readonly" style="background:#CCC"/> 
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

    <input name="modificar" type="submit" id="modificar" value="Guardar" class="btn_table" />

    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar(<?=$id_anticipo?>);"  class="btn_table"/>                   

</div>



<script type="text/javascript">

$(document).ready(function () {
	
            var source =
            {
                 datatype: "json",
                 datafields: [
 						 { name: 'id', type: 'number'},
						 { name: 'tipo_costo', type: 'string'},
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
			    url: 'ajax_list_items.php?id=<?=$id_apu?>',
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
                width: 640,
				height: 260,
                source: dataadapter,
				editable: true,
                showfilterrow: false,
                pageable: true,
                filterable: false,
                theme: theme,
				sortable: true,
                rowsheight: 40,
                columnsresize: true,
				virtualmode: true,
				rendergridrows: function(obj)
				{
					 return obj.data;      
				},                
				columns: [

						 // { text: '-', datafield: 'acciones', filtertype: 'none', width:40, cellsalign: 'center', editable: false },

						  { text: 'ID Item', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal', width: 60,  columntype: 'textbox', editable: false },

						  { text: 'Tipo Costo', datafield: 'tipo_costo', columntype: 'dropdownlist', filtertype: 'textbox', editable: false },

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

});

</script>      



<script language="javascript" type="text/javascript">

$(document).ready(function(){

		

		$(".chosen-select").chosen({width:"220px"}); 

		$('input').setMask();	

		$(".btn_table").jqxButton({ theme: theme });

		

		$('#modificar').click(function(){

			$("#frm_per").submit(); 

		});

		

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

		

		$('#prioridad').blur(function(){

			var variable = $(this).val().toUpperCase();

			$(this).val(variable);

		})

		

		

		$('#cedula_consignar').change(function(){

			var nombre, banco, tipocuenta, numcuenta;

			$( "#cedula_consignar option:selected" ).each(function() {

			  nombre = $( this ).attr('nombre');

			  banco = $( this ).attr('entidad');

			  tipocuenta = $( this ).attr('tipocuenta');

			  numcuenta = $( this ).attr('numcuenta');

			});

			$('#beneficiario').val(nombre);

			$('#banco').val(banco);

			$('#tipo_cuenta').val(tipocuenta);

			$('#num_cuenta').val(numcuenta);

		});

		

		$('#nombre_responsable').change(function(){

			var cedula;

			$( "#nombre_responsable option:selected" ).each(function() {

			  cedula = $( this ).attr('cedula');

			});

			$('#cedula_responsable').val(cedula);

		});

		

	});

	

	

	function replaceAll( text, busca, reemplaza ){

	  while (text.toString().indexOf(busca) != -1)

		  text = text.toString().replace(busca,reemplaza);

	  return text;

	}



	

	$('.anticipo').blur(function(){

		var total = 0;

		$('.anticipo').each(function( index ) {

			var val = replaceAll($( this ).val(),".","");

			total += parseFloat(val);

		});

		

		$('#total_anticipo').val(total+',00').setMask(); 

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

					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

				}

			},

			error: function(err) {

				alert(err);

			}

		});

	};

	

	function fn_agregar_item(){ 

		  var str = $("#frm_item").serialize();	

          var value1, value2, value3, value11, value22;

		

		  $.ajax({

			type: 'POST',

			dataType: 'json',

			url: 'ajax_agregar_item.php', 

			data: str,

			success: function(data){	

				if (data.estado == true){ 

				   $("#total_anticipo, #test_total").val(data.total_anticipo);

				   $("#jqxgrid2").jqxGrid('updatebounddata');

				   

				   value1 = 0;

				   value11 = replaceAll($("#valor_hito").val(),".","");

				   value1 += parseFloat(value11);

				   

                   if($("#v_cotizado").val().length == 0)

				       value2 = 0;

                   else{

					   value2 = 0;

				   	   value22 = replaceAll($("#v_cotizado").val(),".","");

				       value2 += parseFloat(value22);

                       value2 = parseFloat($("#v_cotizado").val().replace('.','').replace(',','.'));

				   }

                                   

                   value3 = value1+value2;

				   $("#v_cotizado").val(value3.toString());

				   

				}else{

					alert(data.message);

				}

			}

	   });

   }

</script>