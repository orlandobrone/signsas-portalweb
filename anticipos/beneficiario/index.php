<?php  
	include "../../restrinccion.php";  
  	require_once "../../config.php";   

	define('URL_SECCION', URL_ANTICIPOS);

	define('SECCION', BENEFICIARIO);  
	require_once "../../tpl_top.php"; 
?>

<script type="text/javascript">

    $(document).ready(function () {

            var source =
            {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'string'},
					 { name: 'identificacion', type: 'string'},
					 { name: 'nombre', type: 'string'},
					 { name: 'num_cuenta', type: 'string'},
					 { name: 'entidad', type: 'string'},
					 { name: 'tipo_cuenta', type: 'string'},
					 
					 { name: 'contacto', type: 'string'},
					 { name: 'telefono', type: 'string'},
					 { name: 'regimen', type: 'string'},
					 { name: 'num_contrato', type: 'string'},
					 { name: 'tipo_persona', type: 'string'},
					 { name: 'correo', type: 'string'},
					 
					 { name: 'fecha_creacion', type: 'date'},	
					 { name: 'estado', type: 'string'},
					 { name: 'clinton', type: 'string'},
					 { name: 'sgss', type: 'string'},
					 { name: 'actividad', type: 'string'},
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

				//autorowheight: true,

               // autoheight: true,

				sortable: true,

                autoheight: true,

                columnsresize: true,

				virtualmode: true,

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},              

                columns: [

                  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox',width: 60},

                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width: 60},
				  
				  { text: 'Tipo Persona', datafield: 'tipo_persona', filtertype: 'number', filtercondition: 'starts_with',width: 80},
				  

				  { text: 'Identificación', datafield: 'identificacion', filtertype: 'number', filtercondition: 'starts_with',width: 90},

                  { text: 'Nombre', datafield: 'nombre', filtertype: 'textbox', filtercondition: 'starts_with',width: 100},

                  { text: 'Num Cuenta', datafield: 'num_cuenta', filtertype: 'number',cellsalign: 'right',width: 60},

                  { text: 'Entidad', datafield: 'entidad', filtertype: 'textbox',  cellsalign: 'right' ,width: 60},

				  { text: 'Tipo Cuenta', datafield: 'tipo_cuenta', filtertype: 'checkedlist',width: 60},
				  
				  
				  { text: 'Contacto', datafield: 'contacto', filtertype: 'textbox', filtercondition: 'starts_with',width: 60},
				  { text: 'Télefono/celular', datafield: 'telefono', filtertype: 'textbox', filtercondition: 'starts_with',width: 60},
				  { text: 'Régimen', datafield: 'regimen', filtertype: 'textbox', filtercondition: 'starts_with',width: 60},
				  { text: 'Correo', datafield: 'correo', filtertype: 'textbox', filtercondition: 'starts_with'},
				  { text: 'No Contrato', datafield: 'num_contrato', filtertype: 'textbox', filtercondition: 'starts_with',width: 60},
				  
				  { text: 'Fecha Creación', datafield: 'fecha_creacion', filtertype: 'date', filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd'},
				  
				  { text: 'Cliton', datafield: 'clinton', filtertype: 'none', filtercondition: 'starts_with',width: 60},
				  { text: 'SGSS', datafield: 'sgss', filtertype: 'none', filtercondition: 'starts_with',width: 60},
				  { text: 'Actividad', datafield: 'actividad', filtertype: 'none', filtercondition: 'starts_with',width: 60},
				  
				  { text: 'Estado', datafield: 'estado', filtertype: 'none', filtercondition: 'starts_with',width: 60}

                ]
            });

            $(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Beneficiarios');           

            });
			
			$('#excelExport2').click(function(){
				window.open('export_excel.php');
			});

        });

    </script>

    

    	<div id="cuerpo">

            <h1>BENEFICIARIOS</h1>       

             <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
             
			 <? if(in_array(193, $_SESSION['permisos'])): ?>
             	<input value="Agregar Beneficiario" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
             <? endif; ?>

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

             <!--<input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />-->
             
             <input type="button" value="Exportar Todo" id='excelExport2' class="btn_table" />

            </div>


            <div id="jqxgrid"></div>
          

            <div id="div_oculto" style="display: none;"></div>
            
            <p align="left">Modulo Beneficiarios Ver. 1.1.0</p>
            
            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->