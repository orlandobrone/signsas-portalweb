<?  header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	
	$obj = new TaskCurrent;
	
	setlocale(LC_ALL,"es_ES");
	$mes = strtoupper(strftime("%B"));

?>

<!--Hoja de estilos del calendario -->
<link rel="stylesheet" type="text/css" media="all" href="../../calendario/calendar-blue.css" title="win2k-cold-1">
<!-- librería principal del calendario -->
<script type="text/javascript" src="../../calendario/calendar.js"></script>
<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="../../calendario/calendar-es.js"></script>
<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="../../calendario/calendar-setup.js"></script>

<h1>Agregando nuevo hito</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript:fn_agregar()" method="post" id="frm_per">
       
    <input type="hidden" id="estado" name="estado" value="PENDIENTE"  />

    <table class="formulario">

        <tbody>
			
            <?php if((int)$_SESSION['perfil'] != 5): 
				
					$sqlPry = "SELECT id_regional FROM usuario WHERE id = ".$_SESSION['id']; 
                    $qrPry = mysql_query($sqlPry);
					$rs_pai = mysql_fetch_assoc($qrPry);
					
					$idRegionales = explode(',',$rs_pai['id_regional']);
					
					$namesRegional = '';
					$i = 0;
					
					foreach($idRegionales as $item):
						
						$sqlR = "SELECT region FROM regional WHERE id = ".$item; 
                    	$resultR = mysql_query($sqlR);
						$rowR = mysql_fetch_assoc($resultR);
						
						if($i == 5):
							$salto = '<br/>';
							$i = 0;
						else:
							$salto = '';
							$i++;
						endif;
						
						$namesRegional .= $rowR['region'].','.$salto;
					endforeach;
			?>
        	<tr>
				
                <td>Regional</td>

                <td colspan="4" valign="baseline" width="300">
                	<?=$namesRegional?>
                <td>
           	</tr>
            <? endif; ?>
           
           	<tr>
                
                <td>Proyecto</td>

                <td>

                	<select name="proyec" id="proyec" class="required">

                    	<option value=""></option>

						<?
                            $sql = "select * from proyectos WHERE estado != 'ELIMINADO' order by id desc";
                            $pai = mysql_query($sql);

                            while($rs_pai = mysql_fetch_assoc($pai)){
								
								$centroCosto = $obj->getCentroCostoByProyecto($rs_pai['id']);
                        ?>
                            <option centro_costo="<?=$centroCosto?>" value="<?=$rs_pai['id']?>" <?=($mes == $rs_pai['mes'])?'':'disabled'?>><?=$rs_pai['nombre']?></option>
                        <? } ?>

					</select>
					  

                </td>

            </tr>

            <tr>

                <td>Nombre Hito</td>

                <td><input name="nombre" type="text" id="nombre" size="40" class="required"/></td>

            </tr>
			
            <tr>
            	  <td>Departamento:</td>
                  <td colspan="3">
						  <? $sqlPry = "SELECT * FROM ps_state"; 
                          $qrPry = mysql_query($sqlPry);
                          ?>
                          <select name="departamento" id="departamento" class="required chosen-select">
                              <option value=""></option>
							  <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>
                              <option value="<?=$rsPry['id']?>"><?=$rsPry['name']?></option>
                              <? } ?>
                          </select>
                  </td>            
             </tr>
            

            <tr>

            	  <td>Sitios:</td>

                  <td colspan="3">

                      <? $sqlPry = "SELECT * FROM sitios"; 

                      $qrPry = mysql_query($sqlPry);

                      ?>

                      <select name="sitios" id="sitios" class="required chosen-select">

                          <? while ($rsPry = mysql_fetch_array($qrPry)) { ?>

                          <option value="<?=$rsPry['id']?>"><?=$rsPry['direccion']?> - <?=$rsPry['nombre_rb']?> </option>

                          <? } ?>

                      </select>            

                  </td>            

            </tr>

            <tr>

                <td>Fecha de Inicio</td>

                <td><input name="fecini" type="text" id="fecini" size="40" class="required" style="width:250px;"/>

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecini",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr>

            <tr>

                <td>Fecha de Finalizaci&oacute;n</td>

                <td><input name="fecfin" type="text" id="fecfin" size="40" class="required" style="width:250px;"/>

                <img src="../../calendario/application.png" width="16" height="16" align="absmiddle" id="lanzador2" />

				<script type="text/javascript">

					Calendar.setup({

						inputField     :    "fecfin",      // id del campo de texto

						ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto

						button         :    "lanzador2"   // el id del botón que lanzará el calendario

					});

				</script></td>

            </tr>

            <tr>

                <td>Descripci&oacute;n</td>

                <td><input name="descri" type="text" id="descri" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>PO / TT</td>

                <td><input name="ot_cliente" type="text" id="ot_cliente" size="40" class="required" value="PENDIENTE" /></td>

            </tr>
            
            <tr>

                <td>Valor Cotizado Hito</td>

                <td><input name="valor_cotizado_hito" type="text" id="valor_cotizado_hito" size="40" class="required money"/></td>

            </tr>

             <?php //FGR

				$sqlfgr = "select count(1) as cuenta from opciones_perfiles where id_perfil = ".$_SESSION['perfil']." and opcion = 25";

				$paifgr = mysql_query($sqlfgr);

				$conteofgr=mysql_fetch_assoc($paifgr);

				

				if($conteofgr['cuenta']): ?>

                    <tr>

                        <td>PO1</td>

                        <td><input name="po" type="text" id="po" size="40" value="N/A"/></td>

                        <td>PO2</td>

                        <td><input name="po2" type="text" id="po2" size="40" value="N/A"/></td>

                    </tr>

                    <tr>

                        <td>GR1</td>

                        <td><input name="gr" type="text" id="gr" size="40" value="N/A"/></td>

                        <td>GR2</td>

                        <td><input name="gr2" type="text" id="gr2" size="40" value="N/A"/></td>

                    </tr>

                    <tr>

                        <td>#Factura1</td>

                        <td><input name="factura" type="text" id="factura" size="40" value="N/A"/></td>

                        <td>#Factura2</td>

                        <td><input name="factura2" type="text" id="factura2" size="40" value="N/A"/></td>

                    </tr>

       		 <?php endif; ?>
             
              <?php if($_SESSION['perfil'] == 19 || $_SESSION['perfil'] == 5): ?>
            
                    <tr>
                        <td>PO3</td>
                        <td><input name="po3" type="text" id="po3" size="40"  value="N/A"/></td>
                        <td>PO4</td>
                        <td><input name="po4" type="text" id="po4" size="40"  value="N/A"/></td>
                    </tr>            
                    
                    <tr>
                        <td>GR3</td>
                        <td><input name="gr3" type="text" id="gr3" size="40" value="N/A"/></td>
                        <td>GR4</td>
                        <td><input name="gr4" type="text" id="gr4" size="40" value="N/A"/></td>
                    </tr>
                    
                    <tr>
                        <td>#Factura3</td>
                        <td><input name="factura3" type="text" id="factura3" size="40" value="N/A"/></td>
                        <td>#Factura4</td>
                        <td><input name="factura4" type="text" id="factura4" size="40" value="N/A"/></td>
                    </tr>
                    
                    
                    <tr>
                        <td>F. Facturado 3</td>
                        <td>
                            <input name="fecha_facturado_3" class="datepicker" id="fecha_facturado_3" value="0000-00-00"/> 
                        </td>
                        <td>F. Facturado 4</td>
                        <td>
                            <input name="fecha_facturado_4" class="datepicker" id="fecha_facturado_4" value="0000-00-00"/> 
                        </td>
                    </tr>  
                    
                    <tr>
                        <td>Valor Facturado 3</td>
                        <td><input name="valorfacturado3" class="money" type="text" id="valorfacturado3" size="40" value=""/></td>
                        <td>Valor Facturado 4</td>
                        <td><input name="valorfacturado4" class="money" type="text" id="valorfacturado4" size="40" value=""/></td>
                    </tr>          
            
            <?php endif; ?>
            
             <tr>
                <td>Observaciones:</td>
                <td><textarea name="observaciones" cols="10" style="width:100%;"></textarea></td>
            </tr>         	

        </tbody>

        <tfoot>

             <tr>
            	<td colspan="2">
                	<ul class="form-errors">
                        
                    </ul>
                </td>
			 </tr>
             <tr>
                <td colspan="2">

                    <input name="agregar" type="submit" id="agregar" value="Agregar" class="btn_table"/>

                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" class="btn_table" onclick="fn_cerrar();" />

                </td>

            </tr>

        </tfoot>

    </table>
</form>
  
    <div id="eventWindow">
          <div>
              <img width="14" height="14" src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678117-window-system-16.png" alt="" />
              Atenci&oacute;n</div>
          <div>
              <div>
                  Por favor indique si el hito a crear esta en? 
                  <br /> 
                  a. Cotizaci&oacute;n, quedara en estado cotizado.<br />
                  b. Adjudicaci&oacute;n, quedara en estado pendiente.
              </div>
              <div>
                  <div style="float: right; margin-top: 15px;">
                      <input type="button" id="ok" class="btn_table" value="A" style="margin-right: 10px" />
                      <input type="button" id="cancel" value="B" class="btn_table"/>
                  </div>
              </div>
    	   </div>
    </div>
           


<link rel="stylesheet" href="/js/chosen/chosen.css">

<style>
.jqx-window-close-button{ display:none !important; };
.validClass{ background-color:none;  }
.errorClassInput{ background-color:#FFC1C1;  }
.form-errors li{ text-align:left; color:#FF7575; }
label[class=errorClassInput]{ display:none !important; }
</style>

<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script> 

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		$("#frm_per select").chosen({width:"250px"});
		$(".btn_table").jqxButton({ theme: theme });
		
		$(".money").maskMoney({ prefix:'$', allowNegative: true, thousands:'', decimal:',', affixesStay: false});
		
		$('#ok').click(function(){
			$('#estado').val('COTIZADO');
		});
		
		$("#proyec").change(function(){
			if($("option:selected", this).attr('centro_costo') == 6){
				$("#valor_cotizado_hito").val(1).attr('readonly','readonly');
				$("#valor_cotizado_hito").val('1,00');
			}else{ 
				$("#valor_cotizado_hito").val(0).removeAttr('readonly');
			}
			
		});
		
		$('#eventWindow').jqxWindow({
                maxHeight: 200, maxWidth: 280, minHeight: 30, minWidth: 250, height: 200, width: 270,
                resizable: false, isModal: true, modalOpacity: 0.3,
                okButton: $('#ok'), cancelButton: $('#cancel'),
                initContent: function () {
                    $('#ok').jqxButton({ width: '65px' });
                    $('#cancel').jqxButton({ width: '65px' });
                    $('#ok').focus();
                }
        });
		

		$("#frm_per").validate({
			ignore: '*:not([name])', // <-- option so that hidden elements are validated
			rules:{
				 proyec: {					
				 	required: true,
				 },
				 nombre:{
					 required: true,
				 }
			},	
			messages: {
				proyec: { required: "Se requiere proyecto" }, 
				nombre: { required: "Se requiere el nombre del hito" },
				departamento: { required: "Se requiere el departamento" },
				sitios: { required: "Se requiere el sitios" },
				fecini: { required: "Se requiere la Fecha de inicio" },
				fecfin: { required: "Se requiere la Fecha Final" },
				descri: { required: "Se requiere la descripci&oacute;n" },
				valor_cotizado_hito: { required: "Se requiere el valor cotizado" }    
			},
			errorClass: "errorClassInput",
			onkeyup: false,
			errorContainer: ".form-errors",	
			errorLabelContainer: ".form-errors ul",	
		    showErrors: function (errorMap, errorList){
				$.each(errorMap, function(index,value){					
					$("div .form-errors").append('<li>'+value+'.</li>');
				});
				this.defaultShowErrors();
            }, 
			errorPlacement: function errorPlacement(error, element){                     
                    //element.before(error); 
                    if (element.attr("name") == "proyec" || element.attr("name") == "departamento" || element.attr("name") == "sitios" ) {
                        $('#'+element.attr("name")+'_chosen a').css('border','1px solid red');
                    }
            },
			submitHandler: function(form) {
				$('.chosen-container').css('border','1px solid #aaa');
				var respuesta = confirm('\xBFDesea realmente agregar este nuevo hito?')
				if (respuesta){
					loaderSpinner(); 
					form.submit();
				}
			}
		});

		$( "#fecini" ).setMask('9999/99/99');
		$( "#fecfin" ).setMask('9999/99/99');
		//$("#valor_cotizado_hito").setMask();
	});

	

	function fn_agregar(){
		
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_agregar.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "") {
					alert(data);
				}else{
					fn_cerrar();	
					fn_buscar();
				}
				stoploaderSpinner();
			}

		});

	};

</script>