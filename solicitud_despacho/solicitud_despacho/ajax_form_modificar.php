<? header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){

		echo "Por favor no altere el fuente";

		exit;

	}



	include "../extras/php/basico.php";

	include "../../conexion.php";



	$sql = sprintf("select * from solicitud_despacho where id=%d",

		(int)$_POST['ide_per']

	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existen solicitudes de despacho con ese ID";

		exit;

	}

	

	$rs_per = mysql_fetch_assoc($per);

	$id_despacho = $rs_per['id'];



?>

<h1>Formato Solicitud de Despacho</h1>

<table>

        <tbody>

        	 <tr>

                <td style="font-weight:bold;">Fecha Solicitud:</td>

                <td><?=$rs_per['fecha_solicitud']?></td>

          </tr>

          <tr>

                <td style="font-weight:bold;">Fecha Entrega:</td>

                <td><?=$rs_per['fecha_entrega']?></td>

              

                <td style="font-weight:bold;">Prioridad:</td>

                <td><?=$rs_per['prioridad']?></td>

            </tr> 

            

            <tr>

            	<td colspan="2"><h3>Responsable de la Solicitud</h3></td>

            </tr>

            

            <tr>

            	<td style="font-weight:bold;">Regional:</td>

                <td>

                 <? 

				 	$sqlPry = "SELECT * FROM regional WHERE id =".$rs_per['id_regional']; 

                    $qrPry = mysql_query($sqlPry);

					$rsPry = mysql_fetch_array($qrPry);

                 	echo $rsPry['region'];

				 ?>

                </td> 

                <td colspan="2">

                	<div id="mensaje" class="alert" style="display:none;">Debe selecionar Regional y Centro Costos.</div>   

                </td>  

            </tr>

            <tr>        

                <td style="font-weight:bold;">Nombre:</td>

                <td><?=$rs_per['nombre_responsable']?></td>

                

                <td style="font-weight:bold;">Cedula:</td>

                <td><?=$rs_per['cedula_responsable']?></td> 

           </tr>         

           <tr> 

                <td style="font-weight:bold;">Centro Costo:</td>

                <td>

                    <? 

						$sqlPry = "SELECT * FROM linea_negocio WHERE id =".$rs_per['id_centrocostos'];

                    	$qrPry = mysql_query($sqlPry);

                        $rsPry = mysql_fetch_array($qrPry);

					?>

                    <?=$rsPry['codigo']?> - <?=$rsPry['nombre']?>

                </td>            

         

            	<td style="font-weight:bold;">Orden Trabajo:</td>

                <td>

                    <? 

						$sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto =".$rs_per['id_proyecto'];

                    	$qrPry = mysql_query($sqlPry);

                        $rsPry = mysql_fetch_array($qrPry);

					?>

                    <?=$rsPry['orden_trabajo'];?>

                </td>

           </tr> 

           <tr>

               <td style="font-weight:bold;">Hitos:</td>

               <td>                     

                	<? 

						$sqlPry = "SELECT nombre FROM hitos WHERE id =".$rs_per['id_hito'];

                    	$qrPry = mysql_query($sqlPry);

                        $rsPry = mysql_fetch_array($qrPry);

					?>

                    <?=$rsPry['nombre'];?>        

               </td> 

           </tr>

           

        </tbody>

    </table>  

	<br />

    <table>

            <tr>

              <td style="font-weight:bold;">Direcci&oacute;n de entrega</td>

              <td><?=$rs_per['direccion_entrega']?></td>

              <td style="font-weight:bold;">Nombre de quien recibe</td>

              <td><?=$rs_per['nombre_recibe']?></td>

            </tr>

            <tr>

              <td style="font-weight:bold;">Tel&eacute;fono / Celular</td>

              <td><?=$rs_per['celular']?></td>

              <td style="font-weight:bold;">Descripci&oacute;n:</td>

              <td><?=$rs_per['descripcion']?></td>

            </tr>   

    </table>   

</div>



<div id="jqxgrid2" style="margin-top:20px; margin-bottom:20px;"></div>



<div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

    <input name="cancelar" type="button" id="cancelar" value="Cerrar" onclick="fn_cerrar('');" class="btn_table"/>                   

</div>



<script type="text/javascript">

$(document).ready(function () {

	

			$(".btn_table").jqxButton({ theme: theme });

			

            var source =

            {

                 datatype: "json",

                 datafields: [

					 { name: 'codigo', type: 'string'},

					 { name: 'nombre_material', type: 'string'},

					 { name: 'cantidad', type: 'number'},

					 { name: 'costo', type: 'number'},	

					 { name: 'aprobado', type: 'string'},	

					 { name: 'observacion', type: 'string'},			

					 { name: 'acciones', type: 'string'}						 

                ],

				updaterow: function (rowid, rowdata, commit) {

                    // synchronize with the server - send update command

                    // call commit with parameter true if the synchronization with the server is successful 

                    // and with parameter false if the synchronization failder.

                    commit(true);

                },

				cache: false,

			    url: 'ajax_list_materiales.php?id=<?=$id_despacho?>',

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

                width: '100%',

				height: 260,

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

				rendergridrows: function(obj)

				{

					 return obj.data;      

				},                

                columns: [

				  { text: '-', datafield: 'acciones', filtertype: 'none', width:'10%', cellsalign: 'center', editable: false },

                  { text: 'C&oacute;digo', datafield: 'codigo', filtertype: 'none', filtercondition: 'equal',  columntype: 'textbox', editable: false, width:70 },

                  { text: 'Material', datafield: 'nombre_material',  filtertype: 'none', filtercondition: 'starts_with', editable: false },

				  { text: 'Cantidad', datafield: 'cantidad', filtertype: 'none', cellsalign: 'right', width:60 },

				  { text: 'Costo', datafield: 'costo', filtertype: 'none', cellsalign: 'right'},

				  { text: 'Observaci&oacute;n', datafield: 'observacion', filtertype: 'none',cellsalign: 'right'},

                  { text: 'Estado', datafield: 'aprobado', filtertype: 'none', cellsalign: 'right' }

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





