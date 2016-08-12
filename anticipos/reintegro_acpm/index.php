<?php  include "../../restrinccion.php";  ?>

    <?php  require_once "../../config.php";   
	define('URL_SECCION', URL_ANTICIPOS);
	define('SECCION', REINTEGRO_ACPM); ?>   
	<?php require_once "../../tpl_top.php"; ?>
    
    <style>
	.sweet-overlay{ z-index:99999 !important; }
	.sweet-alert{ z-index:100000; }
	</style>
   
    <script type="text/javascript">
    $(document).ready(function () {
            var source =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'id_reintegro_anticipo', type: 'number'},
					 { name: 'id_aplicado_anticipo', type: 'number'},
					 { name: 'id_hito', type: 'number'},
					 { name: 'galones', type: 'number'},
					 { name: 'id_user', type: 'string'},
					 { name: 'fecha_creacion', type: 'date'},
					 { name: 'acciones', type: 'string'}
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
					if (data != null){
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

            $("#jqxgrid").jqxGrid({
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
                  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox', width:80 },
                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width:80},
				  { text: 'Anticipo Reintegro', datafield: 'id_reintegro_anticipo', filtertype: 'number', filtercondition: 'starts_with'},
                  { text: 'Anticipo Aplicado', datafield: 'id_aplicado_anticipo', filtertype: 'textbox', filtercondition: 'starts_with' },
				  //{ text: 'Hito Cargado', datafield: 'id_hito', filtertype: 'checkedlist'},
                  { text: 'Cant. Galones', datafield: 'galones', filtertype: 'number',cellsalign: 'right'},
                  { text: 'Fecha Creación', datafield: 'fecha_creacion', filtertype: 'date', filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd HH:mm:ss' },
				  { text: 'Responsable', datafield: 'id_user', filtertype: 'none',  cellsalign: 'right' }
				]
            });
			
            $(".btn_table").jqxButton({ theme: theme });
            $('#clearfilteringbutton').click(function () {
                $("#jqxgrid").jqxGrid('clearfilters');
            });
			$("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Beneficiarios');           
            });		
			
			$('#addreintegroWindow').jqxWindow({
					minHeight: '60%', minWidth: '60%', zIndex:100,
					resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false
			});
			
			$("#btnCodigo").click(function () {
				swal({   
					title: "Esta seguro?",   
					text: "Cambiara el codigo de ACPM, se aplicara para todo el inventario ?",   
					type: "warning",   
					showCancelButton: false,   
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "Si",   
					closeOnConfirm: true 
				},function(){   
					$.ajax({ 
						  type: 'POST',
						  dataType: 'json',
						  url: 'ajax_update_codigo.php',
						  data: { valueacpm:$('#valueacpm') }, 
						  success: function(data){
							  console.log(data);
							  //$("#jqxgrid_items").jqxGrid('updatebounddata', 'cells');
						  }											
					});		
				});
                       
            });		
  
        });
    </script>
    <style>
		#addreintegroWindow{ top:20px !important; }
	</style>
    
    	<div id="cuerpo">
            <h1>REINTEGRO DE ACPM <span style="color:#DC5052;display:none;">En Construcción</span></h1>       
            
             <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
             <? if(in_array(353,$_SESSION['permisos'])): ?>
             <input value="Agregar Reintegro" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <? endif; ?>
             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />
             <!--<input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />-->
            <?php
				$sql = "select valor from prestaciones where id=17";
				$per = mysql_query($sql);
				$rs_per = mysql_fetch_assoc($per);
			?>
            
            <!-- Código ACPM: <input name="valueacpm" id="valueacpm" value="<?=$rs_per['valor']?>"/>
             <input type="button" value="Cambiar" id="btnCodigo" />-->
            </div>
            
            <div id="jqxgrid"></div>
            
             <!--Ventana de formulario de nuevo reintegro-->
           <div id="addreintegroWindow">
                <div>
                    <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/fatcow/16/table_add.png" alt="" />
                    Formulario de Ingreso Reintegro
                </div>
                <div id="content_form_material" style="width:90%;">
                </div>
            </div>
                
            <div id="div_oculto" style="display: none;"></div>
           <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>
        </div>
    <?php require_once "../../tpl_bottom.php"; ?>

<!--    </body>
</html>-->