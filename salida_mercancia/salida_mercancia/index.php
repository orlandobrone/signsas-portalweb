<?php  include "../../restrinccion.php";  ?>


    <?php require_once "../../config.php"; 

	define('URL_SECCION', URL_SALIDA_MERCANCIA);

	define('SECCION', SALIDA_MERCANCIA); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <script>

     $(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'string'},

					 { name: 'nombre_responsable', type: 'string'},

					 { name: 'descripcion', type: 'string'},

					 { name: 'direccion_entrega', type: 'string'},

					 { name: 'nombre_recibe', type: 'string'},

					 { name: 'fecha_solicitud', type: 'date'},

					 { name: 'fecha_entrega', type: 'date'},

					 { name: 'fecha', type: 'date'},

					 { name: 'celular', type: 'string'},

					 { name: 'acciones', type: 'string'},
					 { name: 'id_proyecto', type: 'string'},
					 { name: 'id_hito', type: 'string'},
					 { name: 'totalizador', type: 'number'}

                ],

				cache: false,

			    url: 'ajax_data.php',

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



            // var dataadapter = new $.jqx.dataAdapter(source);



            $("#jqxgrid").jqxGrid(

            {

                width: '100%',

                source: dataadapter,

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

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},              

                columns: [

                  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox', width: 40 },
				  { text: 'OT', datafield: 'id_proyecto', filtertype: 'textbox', filtercondition: 'starts_with', width: 90 },
				  { text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', filtercondition: 'starts_with', width: 90 },


                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true,  width: 100, sortable:false},

				  { text: 'Nombre Responsable', datafield: 'nombre_responsable', filtertype: 'textbox', filtercondition: 'starts_with'},

                  { text: 'Descripción', datafield: 'descripcion', filtertype: 'textbox', filtercondition: 'starts_with' },

                  { text: 'Dirección Entrega', datafield: 'direccion_entrega', filtertype: 'textbox',cellsalign: 'center',width: 130},

				  { text: 'Nombre Recibe', datafield: 'nombre_recibe', filtertype: 'textbox',cellsalign: 'left'},
				  
				  { text: 'Total', datafield: 'totalizador', filtertype: 'none', cellsalign: 'right', cellsformat:'c2',width: 90},

				  { text: 'PBX/Celular', datafield: 'celular', filtertype: 'textbox',cellsalign: 'left', width: 90},

				  { text: 'Fecha Solicitud',datafield: 'fecha_solicitud' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90},

				  /*{ text: 'Fecha Entrega',  datafield: 'fecha_entrega' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90},*/

				  { text: 'Fecha Registro', datafield: 'fecha' ,filtertype: 'date', filtercondition: 'equal', cellsformat: 'yyyy-MM-dd',width: 90}

                ]

            });

            $(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Solicitud Mercancia');           

            });

			$('#excelExport2').click(function(){
				
				var inicio,fin;				
				finicio = $('#fecini2').val();
				ffin = $('#fecfin2').val();		
						
				window.open("/salida_mercancia/salida_mercancia/export_excel.php?fecini="+finicio+"&fecfin="+ffin);
			});
			
		
			
			var mainDemoContainer = $('body');
			
			var offset = mainDemoContainer.offset();
			
			$('#eventWindow').jqxWindow({
                minHeight: '90%', minWidth: '95%', zIndex:18032,
                resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false
            });
			
			$('#addmaterialWindow').jqxWindow({
               minHeight: 272, minWidth: 660, resizable: true, isModal: false,
     		   isModal: false ,autoOpen: false, showCollapseButton: true, zIndex:19000,
			   position: { x: offset.left + 600, y: offset.top + 50}
            });
        });

		function fn_export_mercancia(id){
			window.open("/salida_mercancia/salida_mercancia/export_pdf.php?ide_per="+id);
		}

  	</script>

    <style>
    	table.formulario td, table.formulario th {
			padding: 3px !important;	
		}
    </style>

    	<div id="cuerpo">

           <h1>SOLICITUD DE MERCANCIA <span style="color:#F00; display:none;">EN MANTENIMIENTO</span></h1>

           <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

             <label style="margin-left:5px;">Exportar desde: </label>
             <input name="fecini" type="text" id="fecini2" size="20" readonly />
    		 <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador3" />
    
                    <script type="text/javascript">
    
                        Calendar.setup({
    
                            inputField     :    "fecini2",      // id del campo de texto
    
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
    
                            button         :    "lanzador3"   // el id del botón que lanzará el calendario
    
                        });
    
                    </script> 
                    
                <label>Hasta: </label>   
                <input name="fecfin" type="text" id="fecfin2" size="20" readonly />
    
                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador4" />
  
                 <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "fecfin2",      // id del campo de texto
                        ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                        button         :    "lanzador4"   // el id del botón que lanzará el calendario
                    });
                 </script>                  

             	<input type="button" value="Exportar Todo" id='excelExport2' class="btn_table" /> 

           </div>

           <div id="jqxgrid"></div>

           <div id="div_oculto" style="display: none;"></div>
           
           <div id="eventWindow">
               <div>
                    <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
                    Formulario de Salida de Mercancia
                </div>
                <div id="content_form"></div>
            </div>
            
            
            <div id="addmaterialWindow">
                <div>
                    <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
                    Formulario de Ingreso Materiales
                </div>
                <div id="content_form_material" style="width:90%;">
                	
                    <form action="javascript: fn_agregar_material();" method="post" id="form_material">
                    
                        <h3>Agregar Materiales</h3>
                        <p>Por favor rellene el siguiente formulario</p>
            
                        <input type="hidden" value="" name="id_despacho" id="id_despacho"/>
                        <input type="hidden" value="0" name="cantidadPendiente" id="cantidadPendiente"/>
            
                        <table class="formulario">
            
                            <tbody>
                                <tr>
                                    <td>Material</td>
                                    <td>
                                        <? 
											$sqlMat = sprintf("SELECT * FROM inventario ORDER BY nombre_material ASC");
                                            $perMat = mysql_query($sqlMat);
                                            $num_rs_per_mat = mysql_num_rows($perMat); 
										?>
            
                                           <select class="chosen-select" tabindex="2" name="material" id="material">
                                                <option value="">Seleccione una opci&oacute;n</option>
                
                                                <? while ($rs_per_mat = mysql_fetch_assoc($perMat)): ?>
                
                                                <option value="<? echo $rs_per_mat['id']; ?>"><?php echo $rs_per_mat['codigo'].'-'.$rs_per_mat['nombre_material']; ?></option>
                
                                                <? endwhile; ?>
                
                                            </select>
            
                                    </td>
            
                                    <td>Presupuesto</td>
                                    <td>
                                        <input name="presupuesto" type="text" id="presupuesto" size="40" class="required" alt="integer" style="text-align: right;width: 155px; ">
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
            
                                    <td><textarea id="descripcion" name="descripcion" cols="50" rows="3" style="width: 203px;" disabled="disabled"></textarea></td>
            
                                    <td>Observaci&oacute;n:</td>
            
                                    <td><textarea id="observacion" name="observacion" cols="50" rows="3" style="width: 203px;"></textarea></td>
            
                                </tr>
            
                               
            
                            </tbody>
            
                            <tfoot>
            
                                <tr>
            
                                    <td colspan="2">
            
                                        <input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>
            
                                    </td>
            
                                    
            
                                    <td colspan="2"><div class="alert-box"></div></td>
            
                                </tr>
            
                            </tfoot>
            
                        </table>
                    
                    </form>
                </div>
            </div>
           
           
          
          <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

        <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->