<?  header('Content-type: text/html; charset=iso-8859-1');

	include "../../conexion.php";
	
	$resultado = mysql_query("SELECT * FROM linea_negocio WHERE 1") or die(mysql_error());
	$total = mysql_num_rows($resultado);

	if($total > 0):
		while($row = mysql_fetch_assoc($resultado)):
			$list .= "'".$row['codigo'].'-'.utf8_encode($row['nombre'])."',";
		endwhile;
	endif;	
?>
<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario" style="width:98%;">

        <tbody>

           <tr>
                <td>Lista Anticipos:</td>
           </tr>
           <tr>
                <td>
                    <div id="jqxWidget">
                        <div id="jqxdropdownbutton">
                            <div style="border-color: transparent;" id="jqxgrid_anti"></div>
                        </div>
                    </div> 
                </td>                
            </tr>
            <tr>
            	<td>
                	 <input type="button" value="Seleccionar para Reintegro" id="btnEditar" class="btn_table" />
                </td>
            </tr>
            <tr>
                <td colspan="4">
                	<div style="border-color: transparent;" id="jqxgrid_items"></div>
                </td>
			</tr>
            
            <tr>
            	<td>
                	ID Anticipo: <input type="text" name="id_anticipo" id="id_anticipo" readonly/>
                </td>
                <td>
                	Total Galones: <input type="text" name="CantGalones" id="CantGalones" readonly/>
                </td>
            </tr>           

        </tbody>   
    </table> 
 	
    <div style="clear:both;background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

        <input name="agregar" type="submit" id="agregar" value="Reintegrar" class="btn_table"/>
  
        <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>
  
    </div>
    
</form>


<script language="javascript" type="text/javascript">

var totalGal = 0;

$(document).ready(function(){

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
			var respuesta = confirm('\xBFDesea realmente agregar este reintegro?')
			if (respuesta)
				form.submit();
		}
	});
	
	
	// Grilla de anticipos select box
	var source_anticipos =
	{
		 datatype: "json",
		 datafields: [
			 { name: 's.id', type: 'number'},
			 { name: 's.estado', type: 'string'},
			 { name: 's.int_estado', type: 'number'},
			 { name: 's.fecha', type: 'date'},
			 { name: 's.prioridad', type: 'string'},
			 { name: 's.id_ordentrabajo', type: 'string'},
			 { name: 's.nombre_responsable', type: 'string'},
			 { name: 's.cedula_responsable', type: 'number'},
			 { name: 's.id_centroscostos', type: 'string'},
			 { name: 's.v_cotizado', type: 'string'},
			 { name: 's.total_anticipo', type: 'number'},
			 { name: 's.beneficiario', type: 'string'},
			 { name: 's.num_cuenta', type: 'string'},
			 { name: 's.fecha_creacion', type: 'date'},
			 { name: 's.fecha_aprobado', type: 'date'},
			 { name: 's.valor_giro', type: 'string'},
			 { name: 'prioridad_text', type: 'string'},
			 { name: 's.cedula_consignar', type: 'string'}	
		],
		cache: false,
		url: 'ajax_data_anticipos.php',
		sortcolumn: 's.id',
		sortdirection: 'desc',
		pagesize: 7,
		filter: function(){
			// update the grid and send a request to the server.
			$("#jqxgrid_anti").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			// update the grid and send a request to the server.
			$("#jqxgrid_anti").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
		beforeprocessing: function(data){		
			if (data != null){
				source_anticipos.totalrecords = data[0].TotalRows;					
			}
		}};		
  
	var dataadapter_inv = new $.jqx.dataAdapter(source_anticipos, {
		loadError: function(xhr, status, error){
			alert(error);
		}
	});
	
	
	$("#jqxdropdownbutton").jqxDropDownButton({ width: 250, height: 25});
  	$("#jqxgrid_anti").jqxGrid({
		  width: 580,
		  height: 80,
		  source: dataadapter_inv,
		  showfilterrow: true,
		  pageable: true,
		  filterable: true,
		  theme: theme,
		  autorowheight: true,
		  autoheight: true,
		  sortable: true,
		  autoheight: true,
		  columnsresize: true,
		  virtualmode: true,
		  showstatusbar: false,
		  rendergridrows: function(obj){
			   return obj.data;      
		  },              
		  columns: [
			{ text: 'ID', datafield: 's.id', filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox' },
						
			{ text: 'Estado', datafield: 's.estado', filtertype: 'checkedlist', filtercondition: 'equal', width: 80,  filteritems: ['APROBADO', 'NO REVISADO', 'RECHAZADO', 'REVISADO'] },

			{ text: 'Fecha', datafield: 's.fecha', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },

			{ text: 'Prioridad', datafield: 's.prioridad', filtertype: 'checkedlist', filtercondition: 'equal', width: 50, filteritems: ['CRITICA', 'ALTA', 'MEDIA', 'BAJA', 'VINCULADO', 'GIRADO', 'RETORNO', 'REINTEGRO'] },

			{ text: 'Prioridades', datafield: 'prioridad_text', hidden: true},	

			{ text: 'OT', datafield: 's.id_ordentrabajo', filtertype: 'textbox', width: 100 },
			
			{ text: 'Nombre Responsable', datafield: 's.nombre_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width: 140 },

			{ text: 'Cedula Responsable', datafield: 's.cedula_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width:90},

			{ text: 'Centro Costo', datafield: 's.id_centroscostos', filtertype: 'checkedlist', width:100, filteritems: [<?=$list?>] },

			/*{ text: 'Valor Cotizado', datafield: 's.v_cotizado', filtertype: 'none', width:80},*/

			{ text: 'Total Anticipo', datafield: 's.total_anticipo', columntype: 'numberinput', filtertype: 'textbox', cellsformat: 'c2',cellsalign: 'right', filtercondition: 'starts_with',width:80},
			
			{ text: 'Cedula Beneficiario', datafield: 's.cedula_consignar', filtertype: 'textbox', filtercondition: 'starts_with', width:80},

			{ text: 'Beneficiario', datafield: 's.beneficiario', filtertype: 'textbox',  filtercondition: 'starts_with'},

			{ text: 'Banco', datafield: 's.num_cuenta', filtertype: 'textbox',  filtercondition: 'starts_with'},

			{ text: 'Valor Giro', datafield: 's.valor_giro', hidden: true},	

			{ text: 'Fecha Creado', datafield: 's.fecha_creacion', filtertype: 'date', filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' },
			
			{ text: 'Fecha Aprobado', datafield: 's.fecha_aprobado', filtertype: 'date', filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' }
		  ]
	  });
	  
	  $("#jqxgrid_anti").on('rowselect', function (event) {
		  
		  var args = event.args;
		  var row = $("#jqxgrid_anti").jqxGrid('getrowdata', args.rowindex);
		  
		  var dropDownContent = '<div style="position: relative; margin-left: 3px; margin-top: 5px;">' + row['s.id'] +'</div>';
		  
		  /*$("#idsalida").val(row['id']); 
		  $("#idhito").val(row['id_hito']); 
		  */		  
		  $("#id_anticipo").val(row['s.id']); 
		  getItemHitosById(row['s.id']);		  
		  
		  $("#jqxdropdownbutton").jqxDropDownButton('setContent', dropDownContent);
		  $("#jqxdropdownbutton").jqxDropDownButton('close');				
	});
	
	//Grid items anticipo
	$("#jqxgrid_items").jqxGrid({
		  width: '100%',
		  autoheight: true,
		  showfilterrow: true,
		  editable: false,
		  pageable: false,
		  filterable: true, 
		  theme: theme,
		  sortable: false,
		  columnsresize: true,
		  virtualmode: true,
		  autorowheight: true,
		  showstatusbar: true,
		  statusbarheight: 50,
		  //autoheight: true,
		  enabletooltips: false,		  
		  rendergridrows: function(obj){
			   return obj.data;      
		  },                
		  columns: [
		  		  { text: 'ID Item', datafield: 'i.id', filtertype: 'textbox', filtercondition: 'equal', width: 60,  columntype: 'textbox', editable: false },	
				  	  
		   		  { text: 'ID Hito', datafield: 'idHitos', filtertype: 'textbox', filtercondition: 'equal', width: 60,  columntype: 'textbox', editable: false },

                  { text: 'Hito', datafield: 'id_hitos', filtertype: 'none', width: 150, editable: false },
				  
				  { text: 'Galones', datafield: 'cant_galones', filtertype: 'none', width:100, cellsalign: 'right', editable: false}, 

				  { text: 'Valor ACPM', datafield: 'valor_galon', filtertype: 'none', width: 100, cellsalign: 'right', cellsformat: 'c2', editable: false },
				                  
				  { text: 'Total Costo', datafield: 'total_hito', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2', editable: false },

                  { text: 'Galones Reintegrar', datafield: 'reintegro_galones', filtertype: 'none', width: 130, cellsalign: 'right', editable: true }
		  ]
	  });	
	  
	  
	  /*Modulo de la grilla de salida de mercancia seleccionada*/
	  function getItemHitosById(idanticipo){
		
		var seturl = 'ajax_list_items_anticipo.php?id='+idanticipo; 
		
		var source_items = {
			datatype: "json",
			datafields: [
				 { name: 'i.id', type: 'number'},
				 { name: 'idHitos', type: 'number'},					 
				 { name: 'id_hitos', type: 'string'},
				 { name: 'valor_galon', type: 'number'},
				 { name: 'cant_galones', type: 'number'},
				 { name: 'total_hito', type: 'number'},
				 { name: 'reintegro_galones', type: 'number'}
			],
			updaterow: function (rowid, rowdata, commit) {
				// synchronize with the server - send update command
				// call commit with parameter true if the synchronization with the server is successful 
				// and with parameter false if the synchronization failder.
				commit(true);
			},
			cache: true,
			url: seturl,
			sortcolumn: 'i.id',
			sortdirection: 'desc',
			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid_items").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid_items").jqxGrid('updatebounddata', 'sort');
			},
			root: 'Rows',
			beforeprocessing: function(data)
			{		
				if (data != null){
					source_items.totalrecords = data[0].TotalRows;					
				}
			}};		

			var dataadapter_items = new $.jqx.dataAdapter(source_items, {
				loadError: function(xhr, status, error){
					alert(error);
				}
			});	
			 // update data source.			
			$("#jqxgrid_items").jqxGrid({ source: dataadapter_items });						
		}
	  
		$("#jqxgrid_items").on('cellendedit', function(event) {
		   	var args = event.args;
		   	var totalGal = 0;	
		   	var rows = $('#jqxgrid_items').jqxGrid('getrows');
			var cant_galones = $("#jqxgrid_items").jqxGrid('getcellvalue',args.rowindex,'cant_galones');
			
			if(args.value <= cant_galones){
				$.each(rows,function(index,value){
					if(index != args.rowindex)
						totalGal += value.reintegro_galones;
				});				
				totalGal += parseInt(args.value);
				$('#CantGalones').val(totalGal);
			}else{
				$("#jqxgrid_items").jqxGrid('setcellvalue',args.rowindex, 'cant_salida_gal', 0);
				alert('La cantidad de galones de salida supera a la cantidad');
			}
		   
	  	});	
		
		$('#btnEditar').click(function(){
			swal({   
				title: "Esta seguro?",   
				text: "Estas seguro, de seleccionar este anticipo para reintegro de ACPM ?",   
				type: "warning",   
				showCancelButton: false,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Si",   
				closeOnConfirm: true 
			},function(){   
				$("#jqxgrid_items").jqxGrid({ editable: true });
				$("#jqxdropdownbutton").jqxDropDownButton({ disabled: true });
			});
		});	
		
});

	

function fn_agregar(){
	
	var str = $("#frm_per").serialize();	
	//loaderSpinner();  
	
	$.ajax({
		url: 'ajax_agregar.php',
		data: str,
		type: 'POST',
		dataType: 'json',
		success: function(data){
			if(!data.estado) {				
				swal({   
					title: "Oops",   
					text: data.msj,   
					type: "error",   
					showCancelButton: false,   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "Ok, entendido!",   
					closeOnConfirm: true 
				});
				//alert(data);
			}else{	
						
				var rows = $('#jqxgrid_items').jqxGrid('getrows');	
				var arrayData = new Array();
				$.each(rows,function(index,value){
					arrayData.push({ 'idhito':value.idHitos,
									 'idanticipo':$("#id_anticipo").val(),
									 'valor_galon':value.valor_galon,
									 'total_hito':value.total_hito,
									 'galr':value.reintegro_galones
									});
				});
				
				//console.log(arrayData)
				$.ajax({ 
					  type: 'POST',
					  dataType: 'json',
					  url: 'ajax_add_inventario_item.php',
					  data: {datos:arrayData, idreintegro:data.idreintegro, idanticipogirado:data.idanticipogirado}, 
					  success: function(data){
						  if(data.estado){
							  $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
							  $('#addreintegroWindow').jqxWindow('close'); 	
							 //stoploaderSpinner();
						  }
					  }											
				});					
				//$('#addreintegroWindow').jqxWindow('close'); 				
			}
		}

	});
};

</script>