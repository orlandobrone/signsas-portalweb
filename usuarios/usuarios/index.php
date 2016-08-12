<?php  include "../../restrinccion.php";  ?>

    <?php require_once "../../config.php"; 

	define('URL_SECCION', URL_USUARIOS);

	define('SECCION', USUARIOS); ?>

	<?php require_once "../../tpl_top.php"; ?>

	<script type="text/javascript">

    $(document).ready(function () {

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'id', type: 'string'},

					 { name: 'nombres', type: 'string'},

					 { name: 'usuario', type: 'string'},

					 { name: 'email', type: 'string'},

					 { name: 'codigo_perfil', type: 'string'},

					 { name: 'fecha', type: 'date'},
					 
					 { name: 'id_regional', type: 'string'},

					 { name: 'acciones', type: 'string'},
					 
					 { name: 'estado', type: 'string'}

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

				});



            // var dataadapter = new $.jqx.dataAdapter(source);

			<?php
				$cadena = '';
				$sqlr = "SELECT region FROM regional WHERE 1";
				$resultr = mysql_query($sqlr);
				while($rowsr = mysql_fetch_assoc($resultr)):
					$cadena .=	"'".$rowsr['region']."',";
				endwhile;
				
				$cadena = substr($cadena, 0, -1); 
			?>

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

                  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox' },

                  { text: '-', datafield: 'acciones', filtertype: 'none',pinned: true, width:50},

				  { text: 'Nombres', datafield: 'nombres', filtertype: 'number', filtercondition: 'starts_with'},

                  { text: 'Usuario', datafield: 'usuario', filtertype: 'textbox', filtercondition: 'starts_with' },

				  { text: 'Email', datafield: 'email', filtertype: 'textbox', filtercondition: 'starts_with', width:200 },

                  { text: 'Código Perfil', datafield: 'codigo_perfil', filtertype: 'number',cellsalign: 'right'},
				  
				  { text: 'Regional', datafield: 'id_regional', filtertype: 'checkedlist', filteritems: [<?=$cadena?>], cellsalign: 'right'},
				  
				  { text: 'Estado', datafield: 'estado', filtertype: 'string'},

                  { text: 'Fecha de Registro', datafield: 'fecha', filtertype: 'date',filtercondition: 'equal', width: 110, cellsformat: 'yyyy-MM-dd'}

                ]

            });

            $(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {

                $("#jqxgrid").jqxGrid('clearfilters');

            });

			$("#excelExport").click(function () {

                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Beneficiarios');           

            });

        });

    </script>

    

    <div id="cuerpo"> 
        <h1>USUARIOS <span style="color:#FF0000; display:none;">En matenimiento</span></h1>       

         <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">
		 
         <? if(in_array(123,$_SESSION['permisos'])): ?>
         <input value="Agregar Usuario" type="button" onclick="javascript: fn_mostrar_frm_agregar();" class="btn_table" />
         <? endif; ?>

         <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />

         <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />

        </div>

        

        <div id="jqxgrid"></div>

        

        

        <div id="div_oculto" style="display: none;"></div>

        <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

    </div>

    <?php require_once "../../tpl_bottom.php"; ?>



<!--    </body>

</html>-->