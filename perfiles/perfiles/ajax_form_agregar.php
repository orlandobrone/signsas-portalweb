<? 
	include "../../conexion.php";

/**
POR ESTANDAR DE PROGRAMACION INTERNACIONAL EN EL BUEN MANEJO E INTEGRACION DE  BASES DE DATOS SE RECOMIENDA MODIRICAR ESTA PESTAÑA
PARA QUE LA INFORMACION SEA CARGADA DESDE UNA TABLA LLAMADA LA OPCIONES LA CUAL DEBE ESTAR INTEGRADA CON LA TABLA OPCIONES-PERFILES

LA ORGANIZACION ACTUAL DEL ID DEL PERFIL Y LA DESCRIPCION PERFIL ES LA SIGUIENTE:

1 - PROYECTOS
2 - COSTOS 
3 - HITOS
4 - TAREAS
5 - INGRESOS
6 - CLIENTES
7 - PROOVEDORES
8 - INVENTARIO
9 - INGRESO DE MERCANCIA
10 - SOLICITUD DE DESPACHO
11 - COTIZACIONES
12 - USUARIOS 
13 - PERFILES
14 - REPORTES
15 - COMERCIAL
16 - SALIDA COMERCIAL
17 - ASIGNACION
18 - ANTICIPOS
19 - BENEFICIARIO
20 - LEGALIZACION
22 - ANTICIPO-MODIFICAR
23 - P.O
24 - INGRESOS
25 - HITOS->EDITOR GR - FR
26 - FINANCIERO
28 - ASIGNACION -> VEHICULOS
29 - ASIGNACION -> FUNCIONARIO/TECNICO
30 - ASIGNACION
31 - FACTURAS
32 - ANTICIPOS-APROBAR
33 - LEGALIZACION-APROBAR
34 - REGIONAL Y RESPONSABLE
301 - Hitos->Editor Cambio Estado
302 - Hitos->Editor Valor Facturado
303 - Hitos->Editor PO

EL ID DE LA REGIONAL SE CONTRUYE CON EL NUMERO 10 + EL ID DE LA TABLA
**/

?>

<h1>Agregando nuevo Perfil</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_agregar();" method="post" id="frm_per">

    <table class="formulario" style="width:100%">

        <tbody>

            <tr>

                <td>Nombre </td>

                <td><input name="nombre" type="text" id="nombre" size="40" class="required" /></td>

            </tr>

            <tr>

                <td>Descripci&oacute;n</td>

                <td><input name="descripcion" type="text" id="descripcion" size="40" class="required" /></td>

            </tr>

            <tr>

                <td align="left" valign="top">Opciones</td>

                <td>

                <table style="width:100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="1" />

                      Proyectos</td>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="2" /> 

                      Costos</td>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="3" /> 

                      Hitos</td>

                  </tr>

                  <tr>

                    

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="4" /> 

                      Tareas</td>

					<td><input name="opcion[]" type="checkbox" id="opcion[]" value="5" /> 

                      Ingresos</td>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="16" />

Salida de Mercancia</td>

                  </tr>

                  <tr>

                    

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="8" /> 

                      Inventario</td>

					 <td><input name="opcion[]" type="checkbox" id="opcion[]" value="6" /> 

                      Clientes</td>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="7" /> 

                      Proveedores</td>

                  </tr>

                  <tr>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="9" /> 

                      Ingreso de Mercancia

</td>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="10" /> 

                      Solicitud de Despacho</td>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="11" /> 

                      Cotizaciones</td>

                  </tr>

                  <tr>

                      <td><input name="opcion[]" type="checkbox" id="opcion[]" value="12" /> 

                      Usuarios</td>



                      <td><input name="opcion[]" type="checkbox" id="opcion[]" value="13" /> 

                      Perfiles</td>
                      
                      <td><input name="opcion[]" type="checkbox" id="opcion[]" value="34" /> 

                      Regional Y Responsables</td>

                  </tr>

                  <tr>

                   

                     <td><input name="opcion[]" type="checkbox" id="opcion[]" value="14" /> 

                      Reportes</td>

                     <td><input name="opcion[]" type="checkbox" id="opcion[]" value="15" /> 

                      Comercial</td>

                     <td><input name="opcion[]" type="checkbox" id="opcion[]" value="17" /> 

                      Asignaci&oacute;n</td>

                  </tr>

                  <tr>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="18" /> 

                      Anticipos</td>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="19" /> 

                      Beneficiario</td>

					<td><input name="opcion[]" type="checkbox" id="opcion[]" value="20" /> 

                      Legalizaci&oacute;n

                    </td>

                  </tr>
                  

                  <tr>

                      <td><input name="opcion[]" type="checkbox" id="opcion[]" value="23" /> 

                        P.O

                      </td>

                      <td><input name="opcion[]" type="checkbox" id="opcion[]" value="24" /> 

                        Ingresos

                     </td>

                     <td><input name="opcion[]" type="checkbox" id="opcion[]" value="25" /> 

                        Hitos->Editor GR - FR

                     </td>
                  </tr>
                  
                  <tr>
                      <td>
                          <input name="opcion[]" type="checkbox" id="opcion[]" value="301"  /> Hitos->Editor Cambio Estado
                      </td>      
                      <td>
                          <input name="opcion[]" type="checkbox" id="opcion[]" value="302"  /> Hitos->Editor Valor Facturado
                      </td> 
                      <td>
                          <input name="opcion[]" type="checkbox" id="opcion[]" value="303" /> Hitos->Editor PO
                      </td>                
                  </tr>
                  
                  <tr>
                  	  <td><input name="opcion[]" type="checkbox" id="opcion[]" value="26" /> 

                        Financiero

                     </td>
                     <td><input name="opcion[]" type="checkbox" id="opcion[]" value="31" /> 

                        Facturas

                     </td>
                  </tr>
                  
                  <tr>
                  	<td><input name="opcion[]" type="checkbox" id="opcion[]" value="30"/> 

                         Asignaci&oacute;n->Asignaci&oacute;n

                    </td>
                	<td><input name="opcion[]" type="checkbox" id="opcion[]" value="28"/> 

                        Asignaci&oacute;n->Veh&iacute;culos

                     </td>
                  	<td><input name="opcion[]" type="checkbox" id="opcion[]" value="29"/> 

                         Asignaci&oacute;n->Funcionario/T&eacute;cnico

                     </td>
                  </tr>
                  
                    <tr>
                        <td>
    
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="22"  /> 
    
                         Anticipo->Modificar 
    
                        </td>
                    
                        <td>
    
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="32" /> 
    
                         Anticipo->Aprobar 
    
                        </td>    
                        
                        <td>
    
                         <input name="opcion[]" type="checkbox" id="opcion[]" value="33" /> 
    
                         Legalizaci&oacute;n->Aprobar
    
                        </td>                	
                  </tr>
                  
                  <?php $sqlReg = "SELECT * FROM regional ORDER BY id ASC"; 

                     $qrReg = mysql_query($sqlReg);

					 $fila = 0;

					 while ($rsReg = mysql_fetch_array($qrReg)) { 

					 	if($fila == 0){

                     		echo '<tr><td><input name="opcion[]" type="checkbox" id="opcion[]" value="10'.$rsReg['id'].'" />'.$rsReg['region'].'</td>';

							$fila++;

						}

						else {

							echo '<td><input name="opcion[]" type="checkbox" id="opcion[]" value="10'.$rsReg['id'].'" />'.$rsReg['region'].'</td></tr>';

							$fila=0;

						}

					                       

					 ?>

                     <? } ?> 

                  

                </table></td>

            </tr>

        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">

                    <input name="agregar" type="submit" id="agregar" value="Agregar" />

                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />

                </td>

            </tr>

        </tfoot>
    </table>
</form>


<script language="javascript" type="text/javascript">

	$(document).ready(function(){

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

				var respuesta = confirm('\xBFDesea realmente agregar a este nuevo perfil?')

				if (respuesta)

					form.submit();

			}

		});

		$('#telefo').setMask('(999) 999-9999');

		$('#celula').setMask('(999) 999-9999');

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

			}

		});

	};

</script>