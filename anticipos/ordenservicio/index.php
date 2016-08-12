<?php  

	include "../../restrinccion.php";  
	include "../../conexion.php";
	require_once "../../config.php"; 

	define('URL_SECCION', URL_ANTICIPOS); 
	define('SECCION', ORDENSERVICIO); 
	
	require_once "../../tpl_top.php"; 
	
	
	
	$resultado = mysql_query("SELECT * FROM linea_negocio WHERE 1") or die(mysql_error());
	$total = mysql_num_rows($resultado);
	
	$list = '';
	while($row = mysql_fetch_assoc($resultado)):
		$list .= "'".$row['id'].'.'.utf8_encode($row['nombre'])."',";
	endwhile;

	
	/*$obj = new TaskCurrent;
	echo $obj->getTotalAcumuladoOSByIdent(72187080);*/
?>

    <script src="/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
    
    <!--Hoja de estilos del calendario -->
	<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">
	<!-- librería principal del calendario -->
	<script type="text/javascript" src="../../calendario/calendar.js"></script>
	<!-- librería para cargar el lenguaje deseado -->
	<script type="text/javascript" src="../../calendario/calendar-es.js"></script>
	<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>


	<link href="/excel/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/excel/css/excel.css">

    <style>
		.jqx-grid-content{ z-index:10; }
		input[alt=porcentaje]{ text-align:right; }
	</style>

    <link rel="stylesheet" href="/js/chosen/chosen.css">

	<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 

    <script type="text/javascript">

    $(document).ready(function () {   

			
            var source =
            {
                 datatype: "json",
                 datafields: [

					 { name: 'id', type: 'number'},
					 { name: 'fecha_create', type: 'date'},
					 { name: 'fecha_inicio', type: 'date'},
					 { name: 'fecha_terminado', type: 'date'},
					 
					 { name: 'estado', type: 'string'},
					 
					 { name: 'id_regional', type: 'string'},
					 { name: 'nombre_responsable', type: 'string'},
					 { name: 'cedula_responsable', type: 'number'},

					 { name: 'id_centroscostos', type: 'string'},
					 { name: 'id_ordentrabajo', type: 'string'},
					 
					 { name: 'cedula_contratista', type: 'number'},
					 { name: 'nombre_contratista', type: 'string'},
					 { name: 'telefono_contratista', type: 'string'},
					 { name: 'direccion_contratista', type: 'string'},

					 { name: 'contacto_contratista', type: 'date'},
					 { name: 'regimen_contratista', type: 'date'},
					 { name: 'correo_contratista', type: 'string'},
					 { name: 'poliza_contratista', type: 'string'},
					 
					 { name: 'valor_total', type: 'number'},
					 
					 { name: 'acciones', type: 'string'}
                ],
				cache: false,
				async: false,
			    url: 'ajax_data.php',
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

			

			

            var ordersSource =

            {

				datatype: "json",

                datafields: [

					 { name: 'i.id', type: 'number'},

					 { name: 'idHitos', type: 'number'},

					 { name: 'acpm', type: 'number'},

					 { name: 'valor_transporte', type: 'number'},

					 { name: 'toes', type: 'number'},	
					 
					 { name: 'viaticos', type: 'number'},	
					 
					 { name: 'mular', type: 'number'},	
					 
					 { name: 'anticipos_anteriores', type: 'string'},		
					 
					 { name: 'valor_cotizado_hito', type: 'string'},

					 { name: 'acciones', type: 'string'}					 

                ],

				cache: false, 	

				async: false,

			    url: 'ajax_list_items.php',

				root: 'Rows',

                sortcolumn: 'i.id',

                sortdirection: 'desc'

            };

            var ordersDataAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

			

            orders = ordersDataAdapter.records;

            var nestedGrids = new Array();

            // create nested grid.

            var initrowdetails = function (index, parentElement, gridElement, record) {

                var id = record.uid.toString();
				var id_os = record['id'];				
				
				if(id_os[0]=='<')
					id_os = $(id_anticipo).text(); //FGR

                var grid = $($(parentElement).children()[0]);

			    nestedGrids[index] = grid;

                var ordersSource =
				{
					datatype: "json",
					datafields: [
						 { name: 'i.id', type: 'number'},
						 { name: 'idHitos', type: 'string'},
						 
						 { name: 'po_ticket', type: 'string'},
						 { name: 'descripcion', type: 'string'},
						 { name: 'cantidad', type: 'number'},
						 
						 { name: 'valor_unitario', type: 'number'},
						 { name: 'total', type: 'number'},
						 { name: 'forma_pago', type: 'string'},
						 //{ name: 'valor_hito', type: 'string'}, 
					],
					cache: false,
					url: 'ajax_list_items.php?id='+id_os,
					root: 'Rows',
					sortcolumn: 'i.id',
					sortdirection: 'desc'
				};
                var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

                if (grid != null) { 

                    grid.jqxGrid({

                        source: nestedGridAdapter, 
						width: '95%', 
						height: 200,						
                        columns: [

						 // { text: '-', datafield: 'acciones', filtertype: 'none', width:40, cellsalign: 'center', editable: false },

							{ text: 'Hito', datafield: 'idHitos',  filtertype: 'textbox', filtercondition: 'starts_with',  width: 150, editable: false },
							
							{ text: 'p_O/Tiket', datafield: 'po_ticket', filtertype: 'none', width: 120, cellsalign: 'right'},
							
							{ text: 'Descripcion', datafield: 'descripcion', filtertype: 'none', width: 80, cellsalign: 'right'},
							
							{ text: 'Cantidad', datafield: 'cantidad', filtertype: 'none', width: 100, cellsalign: 'right',cellsformat: 'c2'},	 
							
							{ text: 'Valor Unitario', datafield: 'valor_unitario', filtertype: 'none', width:130, cellsalign: 'right', cellsformat: 'c2' },
							
							{ text: 'Total', datafield: 'total', filtertype: 'none', width: 130, cellsalign: 'right',cellsformat: 'c2' },
							
							{ text: 'Forma Pago', datafield: 'forma_pago', filtertype: 'none', width: 130, cellsalign: 'right' } 				 
						  
						]

                    });
                }
            }
			
		   var initrowdetails2 = function (index, parentElement, gridElement, record) {

				var id = record.uid.toString();
				var id_hito = record['idHitos'];
				
				console.log(id_hito); 
				
				var grid = $($(parentElement).children()[0]);

			    nestedGrids[index] = grid;

                var ordersSource = {
					datatype: "json",
					datafields: [
						 { name: 'id_anticipo', type: 'number'},						 
						 { name: 'valor_transporte', type: 'number'},
						 { name: 'toes', type: 'number'},
						 { name: 'viatico', type: 'number'},
						 { name: 'mular', type: 'number'},
						 { name: 'total', type: 'number'},
						 
						 { name: 'acpm', type: 'number'},
						 { name: 'cant_galones', type: 'number'},
						 { name: 'valor_galon', type: 'number'}
					],
					cache: false,
					url: 'ajax_view_hito.php?idhito='+id_hito,
					root: 'Rows',
					sortcolumn: 'i.id',
					sortdirection: 'desc'
				};
                var nestedGridAdapter = new $.jqx.dataAdapter(ordersSource, { autoBind: false });

                if (grid != null) { 

                    grid.jqxGrid({

                        source: nestedGridAdapter, 
						width: '95%', 
						height: 200,
                        columns: [
						  { text: 'ID Anticipo', datafield: 'id_anticipo', filtertype: 'none', width:120,cellsalign: 'right'},

						  { text: 'Valor Transporte', datafield: 'valor_transporte', filtertype: 'none', width:120,cellsalign: 'right', cellsformat: 'c2'},

						  { text: 'TOES', datafield: 'toes', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  { text: 'Viaticos', datafield: 'viaticos', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
						  { text: 'Trasn. Mular', datafield: 'mular', filtertype: 'none', width: 120,cellsalign: 'right',cellsformat: 'c2' },
						  
				  		  { text: 'Valor Gal. ACPM', datafield: 'valor_galon', filtertype: 'none', width: 120, cellsalign: 'right',cellsformat: 'c2'  },
						  
						  { text: 'Cant. Galones', datafield: 'cant_galones', filtertype: 'none', width: 80, cellsalign: 'right' },
						  
						  { text: 'Total ACPM', datafield: 'acpm', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },
						  
						  
						  { text: 'Total', datafield: 'total', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },
						]

                    });
                }
		   }

			

           // var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid").jqxGrid(
            {
                width: '100%',
				height: 500,
                source: dataadapter,
                showfilterrow: true,
                pageable: true,
                filterable: true,
                theme: theme,
				sortable: true,
                columnsresize: true,
				virtualmode: true,	
				pagesize: 20,
				pagesizeoptions: [10, 20, 50, 100, 150, 250, 500],
				rowdetails: true,
				initrowdetails: initrowdetails,
                rowdetailstemplate: { rowdetails: "<div id='grid' style='margin: 10px;'></div>", rowdetailsheight: 220, rowdetailshidden: true },

				rendergridrows: function(obj)
				{
					 return obj.data;      
				},                  

                columns: [

				  { text: 'ID', datafield: 'id', filtertype: 'textbox', filtercondition: 'equal',  width: 40,  columntype: 'textbox' },
				  
				  { text: 'Estado', datafield: 'estado', filtertype: 'textbox', filtercondition: 'equal',  width: 80,  columntype: 'textbox' },

                  { text: 'Acciones', datafield: 'acciones', filtertype: 'none', width:150, pinned: true, cellsalign: 'left' },

                  { text: 'Fecha Creación', datafield: 'fecha_create', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },
				  { text: 'Fecha Inicio', datafield: 'fecha_inicio', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },
				  { text: 'Fecha Terminado', datafield: 'fecha_terminado', filtertype: 'date', filtercondition: 'equal', width: 70, cellsformat: 'yyyy-MM-dd' },	
				  
				  { text: 'Valor Total', datafield: 'valor_total', filtertype: 'none', width: 120, cellsformat: 'c2',cellsalign: 'right' },			  

				  
				  { text: 'Regional', datafield: 'id_regional', filtertype: 'none',  filtercondition: 'starts_with', width: 140 },
				  
				  { text: 'Nombre Responsable', datafield: 'nombre_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width: 140 },
				  { text: 'Cedula Responsable', datafield: 'cedula_responsable', filtertype: 'textbox',  filtercondition: 'starts_with', width:90},
				  
				  
				  { text: 'Centro Costo', datafield: 'id_centroscostos', filtertype: 'checkedlist', width:100, filteritems: [<?=$list?>] },

				  { text: 'OT', datafield: 'id_ordentrabajo', filtertype: 'textbox', width: 70 },
				  
				  
				  /*{ text: 'Valor Cotizado', datafield: 's.v_cotizado', filtertype: 'none', width:80},*/

				  /*{ text: 'Total Anticipo', datafield: 's.total_anticipo', columntype: 'numberinput', filtertype: 'textbox', cellsformat: 'c2',cellsalign: 'right', filtercondition: 'starts_with',width:80},*/
				  				  
				  { text: 'Cedula Contratista', datafield: 'cedula_contratista', filtertype: 'textbox', filtercondition: 'starts_with', width:80},
				  { text: 'Nombre Contratista', datafield: 'nombre_contratista', filtertype: 'textbox',width:80},
				  { text: 'Télefono/Celular', datafield: 'telefono_contratista', filtertype: 'textbox'},	
				  { text: 'Dirección', datafield: 'direccion_contratista', filtertype: 'textbox'},		
				  { text: 'Poliza Contratista', datafield: 'poliza_contratista', filtertype: 'none'}			  
			    ]

            });

			$(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

					$('#jqxgrid').jqxGrid('hidecolumn', 'acciones'); 

					$('#jqxgrid').jqxGrid('showcolumn', 's.valor_giro');  

				setTimeout(function(){    

                	$("#jqxgrid").jqxGrid('exportdata', 'xls', 'Anticipos_<?=date('m-d-Y')?>');   

				},1000);

				setTimeout(function(){

					$('#jqxgrid').jqxGrid('showcolumn', 'acciones');

					/*$('#jqxgrid').jqxGrid('hidecolumn', 'prioridad_text');  

					$('#jqxgrid').jqxGrid('hidecolumn', 's.valor_giro'); */  

				},3000);
            });

			
			$('.excelExport2').live('click',function(){				
				var id = $(this).attr('value');
				window.open("/anticipos/ordenservicio/export_pdf.php?ide_per="+id);
			});
			
			$('#excelExport3').click(function(){
				var fecini = $('#fecini_e').val();
				var fecfin = $('#fecfin_e').val();
				window.open("/anticipos/ordenservicio/export_excel_all.php?fecini="+fecini+"&fecfin="+fecfin);
			});
			
			
			//Aprobar servicio
			$('.aprobar_os').live('click',function(){				
				var id = $(this).attr('value');
				swal({   
					title: "Esta seguro?",   
					text: "Aprobaras esta Orden servicio No. "+id+", se enviara un correo al responsable y contratista!",   
					type: "warning",   
					showCancelButton: true,   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "Si!",   
					cancelButtonText: "No, cancelar plx!",   
					closeOnConfirm: false,   
					closeOnCancel: true 
				}, function(isConfirm){  
				 
					  if (isConfirm) {  					  
						  $.ajax({
							  url: 'ajax_aprobar_os.php',
							  data: {id_orden: id},
							  type: 'GET',
							  dataType: 'json',	
							  success: function(data) {
								  if(data.estado){
								  	swal("Aprobado", "Se enviaron los correos al responsable y contratista.", "success");   				
							 	  	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');	
								  }else{
									  swal("Húbo un error!", data.message, "error");   				
								  }
							  }					
						  });
					  } 
				});
			});
    });

</script>

    
<div id="cuerpo">

            <h1>ORDEN DE SERVICIO <span style="color:#FF0000; display:none;">En matenimiento</span></h1>           

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
				 <? if(in_array(403, $_SESSION['permisos'])): ?>
                 <input value="Agregar Orden Servicio" type="button" id="btn_add_anticipo" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table"/>
				 <? endif; ?>
                 <!--<input type="button" value="Importar de Excel" onclick="fn_importar_excel()" class="btn_table" />-->
				 
                 <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" /> 
                 <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />
           
                 <label style="margin-left:5px;">Exportar desde: </label>
                 <input name="fecini" type="text" id="fecini_e" size="9" readonly />
    
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador_e" />
    
                    <script type="text/javascript">
    
                        Calendar.setup({
    
                            inputField     :    "fecini_e",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador_e"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                    
                 <label>Hasta: </label>   
                 <input name="fecfin" type="text" id="fecfin_e" size="9" readonly />
    
                    <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2_e" />
     
                    <script type="text/javascript">
     
                        Calendar.setup({
    
                            inputField     :    "fecfin_e",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador2_e"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                    
                 <input type="button" value="Exportar a Excel Todo" id="excelExport3" class="btn_table" />

            </div>

            <div id="jqxgrid"></div>

            <div id="div_oculto" style="display: none;"></div>
			
            <p align="left">Módulo Orden Servicio Ver. 1.1.1</p>
            
            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

    </div>

    <?php require_once "../../tpl_bottom.php"; ?>

    <!--</body>

</html>-->