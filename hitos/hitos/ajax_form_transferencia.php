<?  header('Content-type: text/html; charset=iso-8859-1');
	
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
	include "../extras/php/basico.php";
	include "../../conexion.php";
	
	//$obj = new TaskCurrent;	
	
	$resultado = mysql_query("SELECT * FROM linea_negocio WHERE 1") or die(mysql_error());
	$total = mysql_num_rows($resultado);

	if($total > 0):
		while($row = mysql_fetch_assoc($resultado)):
			$list .= "'".$row['codigo'].'-'.utf8_encode($row['nombre'])."',";
		endwhile;
	endif;
?>

<style>
	form#frm_per input{ width:150px; }
</style>

<h1>Transferencia Hito #<?=$_POST['ide_per']?></h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="id_hito" name="id_hito" value="<?=$_POST['ide_per']?>" />
    <table class="formulario">
        <tbody>
        	<tr>
                <td>Anticipos con relacion al Hito: </td>
                <td>
                	<div id="jqxWidget">
                        <div id="jqxdropdownbutton">
                            <div style="border-color: transparent;" id="jqxgrid_anti"></div>
                        </div>
                        <input type="hidden" name="id_anticipo_select" id="id_anticipo_select"/>
                        <input type="hidden" name="id_centrocosto" id="id_centrocosto"/>
                    </div> 
                </td>
            </tr>
            
            <tr>
                <td>Transferir al Hito:</td>
                <td>
                	<div id="jqxWidget_2">
                        <div id="jqxdropdownbutton_2">
                            <div style="border-color: transparent;" id="jqxgrid_anti_2"></div>
                        </div>
                        <input type="hidden" name="id_hito_transferir" id="id_hito_transferir"/>
                    </div> 
                </td>
            </tr>
        </tbody>
       
    </table>
    
    <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
    		
			<input name="modificar" type="submit" id="modificar" value="Transferir" class="btn_table"/>
          
            <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" class="btn_table"/>
    </div>
</form>

<style>
.validClass{ background-color:none;  }
.errorClassInput{ background-color:#FFC1C1;  }
.form-errors li{ text-align:left; color:#FF7575; }
label[class=errorClassInput]{ display:none !important; }
</style>

<link rel="stylesheet" href="/js/chosen/chosen.css">
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript">
$(document).ready(function(){
  
  	$("#frm_per select").chosen({width:"250px"});
  	$(".btn_table").jqxButton({ theme: theme });
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
			 { name: 's.cedula_consignar', type: 'string'},
			 { name: 'id_centrocosto', type: 'number' }
		],
		cache: false,
		url: 'ajax_data_anticipos.php?id_hito=<?=$_POST['ide_per']?>',
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
			{ text: 'ID ANTICIPO', datafield: 's.id', filtertype: 'textbox', filtercondition: 'equal',  width: 80,  columntype: 'textbox' },
						
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
		  
		  $("#id_anticipo_select").val(row['s.id']); 
		  $("#id_centrocosto").val(row['id_centrocosto']);
		  
		  $("#jqxdropdownbutton").jqxDropDownButton('setContent', dropDownContent);
		  $("#jqxdropdownbutton").jqxDropDownButton('close');				
	});
  
  	
	
	// Grilla de anticipos 2 select box
	var source_anticipos2 =
	{
		 datatype: "json",
		 datafields: [
			 { name: 'id', type: 'integer'},
			 { name: 'id_proyecto', type: 'string'},
			 { name: 'nombre', type: 'string'},
			 { name: 'estado', type: 'string'},
			 { name: 'autorizado', type: 'string'},
			 { name: 'fecha_inicio', type: 'date'},
			 { name: 'fecha_final', type: 'date'},

			 { name: 'fecha_inicio_ejecucion', type: 'date'},
			 { name: 'fecha_ejecutado', type: 'date'},
			 { name: 'fecha_informe', type: 'date'},
			 { name: 'fecha_liquidacion', type: 'date'},
			 { name: 'fecha_facturacion', type: 'date'},
			 { name: 'fecha_facturado', type: 'date'},					
			 { name: 'ot_cliente', type: 'string'}, /*FGR*/
			 { name: 'po', type: 'string'}, /*FGR*/
			 { name: 'gr', type: 'string'}, /*FGR*/
			 { name: 'factura', type: 'string'}, /*JOB*/
			 { name: 'po2', type: 'string'}, /*FGR*/
			 { name: 'gr2', type: 'string'}, /*FGR*/
			 { name: 'factura2', type: 'string'}, /*JOB*/
			 { name: 'valor_cotizado_hito', type: 'string'}, /*FGR*/
			 { name: 'factor', type: 'number'}, /*FGR*/
			 { name: 'cliente', type: 'string'}, 
		],
		cache: false,
		url: 'ajax_data.php',
		sortcolumn: 'id',
		sortdirection: 'desc',
		pagesize: 7,
		filter: function(){
			// update the grid and send a request to the server.
			$("#jqxgrid_anti_2").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			// update the grid and send a request to the server.
			$("#jqxgrid_anti_2").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
		beforeprocessing: function(data){		
			if (data != null){
				source_anticipos2.totalrecords = data[0].TotalRows;					
			}
		}};		
  
	var dataadapter_2 = new $.jqx.dataAdapter(source_anticipos2, {
		loadError: function(xhr, status, error){
			alert(error);
		}
	});
	
	
	$("#jqxdropdownbutton_2").jqxDropDownButton({ width: 250, height: 25});
  	$("#jqxgrid_anti_2").jqxGrid({
		  width: 580,
		  height: 80,
		  source: dataadapter_2,
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
			{ text: 'ID HITO', datafield: 'id',  filtertype: 'textbox', filtercondition: 'equal',  width: 80,  columntype: 'textbox'  },

			{ text: 'Proyecto', datafield: 'id_proyecto', filtertype: 'textbox', width: 120 },
  
			{ text: 'Nombre Hito', datafield: 'nombre', filtertype: 'textbox', filtercondition: 'starts_with', width: 120 },
			
			{ text: 'Factor', datafield: 'factor', filtertype: 'textbox', filtercondition: 'starts_with', width: 60 },
  
			{ text: 'Estado', datafield: 'estado', filtertype: 'checkedlist', filtercondition: 'equal', width: 70, filteritems: ['PENDIENTE', 'EN EJECUCION', 'EJECUTADO', 'LIQUIDADO', 'INFORME ENVIADO', 'EN FACTURACION', 'FACTURADO', 'CANCELADO', 'DUPLICADO', 'PAGADO', 'ADMIN', 'COTIZADO', 'AUTORIZADO']  },
			
			{ text: 'Autorizado', datafield: 'autorizado', filtertype: 'none', filtercondition: 'starts_with', width: 60 },
			
			{ text: 'Cliente', datafield: 'cliente', filtertype: 'none', filtercondition: 'starts_with', width: 120 },
			
			{ text: 'Adición Cotizado', datafield: 'adicion_cotizado', filtertype: 'none', width: 80, cellsformat: 'c2',cellsalign: 'right' },
  
			{ text: 'Fecha Inicio', datafield: 'fecha_inicio', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },
  
			{ text: 'Fecha Final', datafield: 'fecha_final', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },
			
			{ text: 'Días Hitos', datafield: 'dias_hito',  filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox'  },
  
			{ text: 'Fecha Ini. Ejecución', datafield: 'fecha_inicio_ejecucion', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },
  
			{ text: 'Fecha Ejecutado', datafield: 'fecha_ejecutado', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },
  
			{ text: 'Fecha Informe', datafield: 'fecha_informe', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },
  
			{ text: 'Fecha Liquidación', datafield: 'fecha_liquidacion', filtertype: 'date', filtercondition: 'equal', width: 100, cellsformat: 'yyyy-MM-dd'  },
  
			{ text: 'Fecha Facturación', datafield: 'fecha_facturacion', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },
  
			{ text: 'Fecha Facturado', datafield: 'fecha_facturado', filtertype: 'date', filtercondition: 'equal', width: 80, cellsformat: 'yyyy-MM-dd' },
  
			{ text: 'OT Cliente', datafield: 'ot_cliente', filtertype: 'textbox',  cellsalign: 'left',width: 80}, /*FGR*/
  
			{ text: 'PO', datafield: 'po', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*FGR*/
  
			{ text: 'GR', datafield: 'gr', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*FGR*/
  
			{ text: 'Factura', datafield: 'factura', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*JOB*/
  
			{ text: 'PO2', datafield: 'po2', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*FGR*/
  
			{ text: 'GR2', datafield: 'gr2', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*FGR*/
  
			{ text: 'Factura2', datafield: 'factura2', filtertype: 'textbox',  cellsalign: 'left', width: 80}, /*JOB*/
			
			{ text: 'Valor Cotizado Hito', datafield: 'valor_cotizado_hito', filtertype: 'textbox',  cellsalign: 'left', width: 100, cellsformat: 'c2',cellsalign: 'right'}, /*FGR*/
		  ]
	});
	
	$("#jqxgrid_anti_2").on('rowselect', function (event) {
		  
		  var args = event.args;
		  var row = $("#jqxgrid_anti_2").jqxGrid('getrowdata', args.rowindex);
		  
		  var dropDownContent = '<div style="position: relative; margin-left: 3px; margin-top: 5px;">' + row['id'] +'</div>';
		 
		  $("#id_hito_transferir").val(row['id']); 
		  
		  $("#jqxdropdownbutton_2").jqxDropDownButton('setContent', dropDownContent);
		  $("#jqxdropdownbutton_2").jqxDropDownButton('close');				
	});
  
});

function fn_modificar(){
	
  var str = $("#frm_per").serialize();
  $.ajax({
	  url: 'ajax_transferir.php',
	  data: str,			
	  type: 'get',
	  dataType: 'json',
	  success: function(data){
		  console.log(data) 
		  if(!data.estado){				
			  swal("Error", data.message, "error");
		  }else{
			  fn_cerrar();	
		  }
	  }
  });
};
</script>