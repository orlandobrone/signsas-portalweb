<?  header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
 
	include "../extras/php/basico.php";
	include "../../conexion.php";


	$sql = sprintf("select * from perfiles where id=%d",
		(int)$_POST['ide_per']
	);

	$per = mysql_query($sql);

	$num_rs_per = mysql_num_rows($per);

	if ($num_rs_per==0){

		echo "No existen perfiles con ese ID";

		exit;

	}


	$rs_per = mysql_fetch_assoc($per); 

?>


<h1>Modificando Perfil</h1>

<p>Por favor rellene el siguiente formulario</p>

<form action="javascript: fn_modificar();" method="post" id="frm_per">

	<input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    
   <? $qrPerfil = mysql_query("SELECT * FROM opciones_perfiles WHERE id_perfil = '" . $rs_per['id'] . "'") or die(mysql_error()); 

    $idOpciones = array();

    while ($rowsPerfil = mysql_fetch_array($qrPerfil)) $idOpciones[] = $rowsPerfil['opcion'];

    ?>
    
     <table class="formulario" style="width:100%">
          <tr>
              <td>Nombre</td>
              <td><input name="nombre" type="text" id="nombre" size="40" class="requisssred" value="<?=$rs_per['nombre']?>" /></td>
          </tr>
          <tr>
              <td>Descripci&oacute;n</td>
              <td><input name="descripcion" type="text" id="descripcion" size="40" class="required" value="<?=$rs_per['descripcion']?>" /></td>
          </tr>
          
           <? if(in_array(134, $_SESSION['permisos'])): ?>
           <tr>
            	<td>Cambio estado:</td>
                <td>
                	<select name="cambio_estado" id="cambio_estado">
                    	<option value="0" <?=($rs_per['estado']==0)?'selected':''?>>Activo</option>
                        <option value="1" <?=($rs_per['estado']==1)?'selected':''?>>Inactivo</option>
                    </select>
                </td>
            </tr>
            <? endif; ?>
    </table>

    
    <div class="jqxTabs">
        <ul style='margin-left: 20px;'>
            <li>Hitos</li>
            <li>Proyecto</li>
            <li>Anticipos</li>            
            <li>Asignaci&oacute;n</li>
            <li>Legalizaciones</li>
            <li>Documentaci&oacute;n</li>
            <li>Beneficiario</li>
            <li>T&eacute;cnico</li>
            <li>Veh&iacute;culos</li>
            
            <li>Inventario</li>
            <li>Ingreso Mercancia</li>
            <li>Solicitud Material</li>            
            <li>Salida Mercancia</li>
            
            <li>Reintegro</li>
            <li>Usuarios</li>
            <li>Perfil</li>
            
            <li>Reintegro ACPM</li>
            <li>Financiero</li>
            <li>Precio ACPM</li>
            <li>Hitos Upload</li>
            
            <li>Orden Servicio</li>            
            <li>Regionales</li>
            
            <li>Responsables</li>
            <li>Coordinadores</li>
        </ul>
        <div>
            <table class="formulario" style="width:100%">
            	 <tr>
                 	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="3" <? if (in_array(3, $idOpciones)) echo 'checked="checked"'; ?> /> Modulo Hitos
                    </td>
                 </tr>
                 <tr>
                	<td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="27" <? if (in_array(27, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Editor Principal
                	</td>
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="21" <? if (in_array(21, $idOpciones)) echo 'checked="checked"'; ?> />  Hitos->Editor Estado Fechas
                	</td>

                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="25" <? if (in_array(25, $idOpciones)) echo 'checked="checked"'; ?> />  Hitos->Editor GR FC
                	</td>
                </tr>                 
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="301" <? if (in_array(301, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Editor Cambio Estado
                    </td>      
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="302" <? if (in_array(302, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Editor Valor Facturado
                    </td> 
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="303" <? if (in_array(303, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Editor PO
                    </td>                
                </tr>
                
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="304" <? if (in_array(304, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Candado
                    </td>  
                    
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="305" <? if (in_array(305, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Modificar
                    </td>   
                    
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="306" <? if (in_array(306, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Eliminar
                    </td>    
                </tr>                
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="307" <? if (in_array(307, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Agregar
                    </td> 
                    
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="308" <? if (in_array(308, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Cerrar Hitos
                    </td>
                    
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="309" <? if (in_array(309, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Transferencia
                    </td> 
                </tr>
                <tr>
                	<td> 
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="310" <? if (in_array(310, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Autorizar
                   </td>
                   <td> 
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="311" <? if (in_array(311, $idOpciones)) echo 'checked="checked"'; ?> /> Hitos->Export Log Estados
                   </td>
                </tr>
            </table>
        </div>
        
        <div class="proyecto">
        	<table class="formulario" style="width:100%">
                <!--modulo de proyecto-->
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="1" <? if (in_array('1', $idOpciones)) echo 'checked="checked"'; ?>/>
                      	Modulo Proyectos
                    </td>
                </tr>
                <tr>
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="111" <? if (in_array('111', $idOpciones)) echo 'checked="checked"'; ?>/>                     
                         Proyecto->Eliminar
                    </td>
                
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="112" <? if (in_array('112', $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Proyecto->Modificar
                    </td>
                
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="113" <? if (in_array('113', $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Proyecto->Crear
                    </td>
                </tr>
        	</table>
        </div>
        
        <div class="anticipo">
        	 <table class="formulario" style="width:100%">
             	<tr>
                	<td>
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="18" <? if (in_array('18', $idOpciones)) echo 'checked="checked"'; ?> /> 
                      	Anticipos
                	</td>
                </tr>
        	 	<tr>
                	<td>
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="181" <? if (in_array(181, $idOpciones)) echo 'checked="checked"'; ?> /> 
                     	Anticipo->Eliminar 
                	</td>
                    <td>
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="182" <? if (in_array(182, $idOpciones)) echo 'checked="checked"'; ?> /> 
                     	Anticipo->Modificar 
                	</td>
                    <td>
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="183" <? if (in_array(183, $idOpciones)) echo 'checked="checked"'; ?> /> 
                     	Anticipo->Crear 
                	</td>            
                </tr>
                <tr>
                	<td>
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="184" <? if (in_array(184, $idOpciones)) echo 'checked="checked"'; ?> /> 
                     	Anticipo->Aprobar 
                	</td>
                    <td>
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="185" <? if (in_array(185, $idOpciones)) echo 'checked="checked"'; ?> /> 
                     	Anticipo->Cambio de estado 
                	</td>  
                </tr>
        	</table>
        </div>
        
        <div class="asignacion">
             <table class="formulario" style="width:100%">
                <!--modulo de asignacion--> 
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="30" <? if (in_array('30', $idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Asignaci&oacute;n
                    </td>
                </tr>               
                <tr>
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="3001" <? if (in_array(3001, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Asignaci&oacute;n->Eliminar
                    </td> 
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="3002" <? if (in_array(3002, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Asignaci&oacute;n->Modificar
                    </td> 
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="3003" <? if (in_array(3003, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Asignaci&oacute;n->Agregar
                    </td>                	
                </tr>
                <tr>
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="3004" <? if (in_array(3004, $idOpciones)) echo 'checked="checked"'; ?>/> 
                    	Asignaci&oacute;n->Cambio Estado
                    </td>   
                </tr>
             </table>
        </div>
        
        <div class="legalizacion"> 
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td>
                		<input name="opcion[]" type="checkbox" id="opcion[]" value="20" <? if (in_array(20, $idOpciones)) echo 'checked="checked"'; ?> /> 
                      	Modulo Legalizaci&oacute;n

                	</td>
                </tr>
				<tr>                   
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="202" <? if (in_array(202, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        Legalizaci&oacute;n->Agregar
                    </td>               	
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="203" <? if (in_array(203, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        Legalizaci&oacute;n->Aprobar
                    </td>
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="204" <? if (in_array(204, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        Legalizaci&oacute;n->Cambio de estado
                    </td>
                </tr>
           	</table>
        </div>
        
        <div class="documental">
             <table class="formulario" style="width:100%">
				  <tr>
                      <td>  
                            <input name="opcion[]" type="checkbox" id="opcion[]" value="36" <? if (in_array('36', $idOpciones)) echo 'checked="checked"'; ?>/> 
                            Modulo - Documental
                      </td>                  
                  </tr>
                  <tr>
                      <td>  
                            <input name="opcion[]" type="checkbox" id="opcion[]" value="361" <? if (in_array('361', $idOpciones)) echo 'checked="checked"'; ?>/> 
                            Documental - Modificaci&oacute;n
                      </td>
                      <td>  
                            <input name="opcion[]" type="checkbox" id="opcion[]" value="362" <? if (in_array('362', $idOpciones)) echo 'checked="checked"'; ?>/> 
                            Documental - Eliminaci&oacute;n
                      </td>
                      <td>
                            <input name="opcion[]" type="checkbox" id="opcion[]" value="363" <? if (in_array('363', $idOpciones)) echo 'checked="checked"'; ?>/> 
                            Documental - Aprobaci&oacute;n
                      </td>                                  
                  </tr>
                  <tr>
                  	  <td>
                      	   <input name="opcion[]" type="checkbox" id="opcion[]" value="364" <? if (in_array('364', $idOpciones)) echo 'checked="checked"'; ?>/> 
                            Documental - Cambio de Estado
                      </td>
                  </tr>
        	</table>
        </div>
        
        <div class="beneficiario">
        	<table class="formulario" style="width:100%">
                <!--modulo de beneficiarios-->
                <tr>
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="19" <? if (in_array(19, $idOpciones)) echo 'checked="checked"'; ?> /> 
                        Modulo Beneficiario
                    </td>
                </tr>
                <tr>
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="191" <? if (in_array(191, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Beneficiario->Eliminar
                    </td>                
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="192" <? if (in_array(192, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Beneficiario->Modificar
                    </td>
                    
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="193" <? if (in_array(193, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Beneficiario->Crear
                    </td>                	
                </tr>
                <tr>
                	<td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="194" <? if (in_array(194, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Beneficiario->Cambio Estado
                    </td>    
                    <td>
                        <input name="opcion[]" type="checkbox" id="opcion[]" value="195" <? if (in_array(195, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Beneficiario->Cambio Actividad
                    </td>    
                </tr>
        	</table>
        </div>
        
        <div class="tecnico">
        	<table class="formulario" style="width:100%">
            	<tr>
                  	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="29" <? if (in_array('29', $idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Funcionario/T&eacute;cnico
                    </td>
                </tr>
        	 	<tr>
                  	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="291" <? if (in_array(291, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        T&eacute;cnico->Eliminar
                     </td>  
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="292" <? if (in_array(292, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        T&eacute;cnico->Modificar
                     </td> 
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="293" <? if (in_array(293, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        T&eacute;cnico->Crear
                     </td>                 	 
                  </tr>
                  <tr>
                  	<td>
                  		<input name="opcion[]" type="checkbox" id="opcion[]" value="294" <? if (in_array(294, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        T&eacute;cnico->Cambio Estado
                  	</td>
                  </tr>
        	</table>
        </div>
        
        <div class="vehiculos">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="28" <? if (in_array(28, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Veh&iacute;culos
                    </td>
                </tr>
        	 	<tr>
                  	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="281" <? if (in_array(281, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Veh&iacute;culos->Eliminar
                     </td>
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="282" <? if (in_array(282, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Veh&iacute;culos->Modificar
                     </td>
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="283" <? if (in_array(283, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Veh&iacute;culos->Crear
                     </td>
                  </tr>
            </table>
        </div>
        
        <div class="inventario">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="8" <? if (in_array(8, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Inventario
                    </td>
                </tr>
        	 	<tr>
                  	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="81" <? if (in_array(81,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Inventario->Eliminar
                     </td>
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="82" <? if (in_array(82,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Inventario->Modificar
                     </td>
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="83" <? if (in_array(83,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Inventario->Crear
                     </td>
                  </tr>
            </table>
        </div>
        
        <div class="ingreso_mercancia">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="9" <? if (in_array(9, $idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Ingreso de Mercancia
                    </td>
                </tr>
        	 	<tr>
                  	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="91" <? if (in_array(91,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Ingreso Mercancia->Eliminar
                     </td>                     
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="92" <? if (in_array(92,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Ingreso Mercancia->Crear
                     </td>
                  </tr>
            </table>        
        </div>
        
        <div class="solicitud_material">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="10" <? if (in_array(10,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Solicitud de Material
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="101" <? if (in_array(101,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Solicitud de Material->Crear
                     </td>
                  </tr>
            </table>
        </div>      
       
        
        <div class="salida_mercancia">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="16" <? if (in_array(16,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Salida de Mercancia
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="161" <? if (in_array(161,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Salida Mercancia->Eliminar
                     </td>
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="162" <? if (in_array(162,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Salida Mercancia->Agregar Material
                     </td>  
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="163" <? if (in_array(163,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Salida Mercancia->Aprobar Materiales
                     </td>                    
                  </tr>
                  <tr>
                  	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="164" <? if (in_array(164,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Salida Mercancia->Cambio Estado
                     </td>
                  </tr>
            </table>        	
        </div>
        
        <div class="reintegros">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="34" <? if (in_array(34,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Reintegro
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="341" <? if (in_array(341,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Reintegro->Eliminar
                     </td>                    
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="342" <? if (in_array(342,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Reintegro->Crear
                     </td>                    
                </tr>
            </table>        	
        </div>
        
        <div class="usuarios">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="12" <? if (in_array(12,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Usuarios
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="121" <? if (in_array(121,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Usuarios->Eliminar
                     </td>  
                      <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="122" <? if (in_array(122,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Usuarios->Modificar
                     </td>                    
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="123" <? if (in_array(123,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Usuarios->Crear
                     </td>                    
                </tr>
                
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="124" <? if (in_array(124,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Usuarios->Cambio Estado
                     </td>   	
                </tr>
            </table>        	
        </div>
        
        <div class="perfiles">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="13" <? if (in_array(13,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Perfiles
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="131" <? if (in_array(131,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Perfiles->Eliminar
                     </td>  
                      <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="132" <? if (in_array(132,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Perfiles->Modificar
                     </td>                    
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="133" <? if (in_array(133,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Perfiles->Crear
                     </td>                    
                </tr>
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="134" <? if (in_array(134,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Perfiles->Cambio Estado
                     </td>   	
                </tr>
            </table>        	
        </div>        
       
        <div class="reintegro_acpm">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="35" <? if (in_array(35,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Reintegro ACPM
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="351" <? if (in_array(351,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Reintegro ACPM->Eliminar 
                     </td>                                   
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="353" <? if (in_array(353,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Reintegro ACPM->Crear
                     </td>                    
                </tr>
            </table>        	
        </div>
        
        <div class="financiero">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="26" <? if (in_array(26,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Financiero
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="261" <? if (in_array(261,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Financiero->Eliminar 
                     </td>    
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="262" <? if (in_array(262,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Financiero->Modificar 
                     </td>                                   
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="263" <? if (in_array(263,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Financiero->Crear
                     </td>                    
                </tr>
            </table>        	
        </div>
        
        <div class="precio_acpm">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="38" <? if (in_array(38,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Precios ACPM
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="381" <? if (in_array(381,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Precios ACPM->Eliminar 
                     </td>    
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="382" <? if (in_array(382,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Precios ACPM->Subir Archivo 
                     </td>                                   
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="383" <? if (in_array(383,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Precios ACPM->Crear
                     </td>                    
                </tr>
            </table>        	
        </div>
        
        <div class="hitos_upload">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="37" <? if (in_array(37,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Hitos Upload
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="371" <? if (in_array(371,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Hitos Upload->Eliminar 
                     </td>    
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="372" <? if (in_array(372,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Hitos Upload->Subir Archivo 
                     </td>                                   
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="373" <? if (in_array(373,$idOpciones)) echo 'checked="checked"'; ?>/> 
                       Hitos Upload->Aplicar Script
                     </td>                    
                </tr>
            </table>        	
        </div>   
        
        <div class="orden_servicio">
        	<table class="formulario" style="width:100%">
                <!--modulo de OS-->
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="40" <? if (in_array(40, $idOpciones)) echo 'checked="checked"'; ?>/>
                      	Modulo Orden Servicio
                    </td>
                </tr>
                <tr>
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="401" <? if (in_array(401, $idOpciones)) echo 'checked="checked"'; ?>/>                     
                         OS->Eliminar
                    </td>
                
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="402" <? if (in_array(402, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         OS->Modificar
                    </td>
                
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="403" <? if (in_array(403, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         OS->Crear
                    </td>
                </tr>
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="404" <? if (in_array(404, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         OS->Aprobar
                    </td> 
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="405" <? if (in_array(405, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         OS->Cambio Estado
                    </td>
                </tr>
        	</table>
        </div>     
        
        <div class="regionales">
        	<table class="formulario" style="width:100%">
            	<tr>
                	<td colspan="2">
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="39" <? if (in_array(39,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Modulo Regional
                    </td>
                </tr>
        	 	<tr>                  	               
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="391" <? if (in_array(391,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Regional->Eliminar
                     </td>  
                      <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="392" <? if (in_array(392,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Regional->Modificar
                     </td>                    
                     <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="393" <? if (in_array(393,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Regional->Crear
                     </td>                    
                </tr>
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="394" <? if (in_array(394,$idOpciones)) echo 'checked="checked"'; ?>/> 
                        Regional->Cambio Estado
                     </td>   	
                </tr>
            </table>        	
            
            <table class="formulario" style="width:100%">
        	  	<?php 
			  		 $sqlReg = "SELECT * FROM regional ORDER BY id ASC"; 
                     $qrReg = mysql_query($sqlReg);
					 $fila = 0;

					 while ($rsReg = mysql_fetch_array($qrReg)) { 

					    $checkeado = '';

						$values='10'.$rsReg['id'];

						if(in_array($values, $idOpciones))

							$checkeado = 'checked="checked"';

					 	if($fila == 0){
                     		echo '<tr><td><input name="opcion[]" type="checkbox" id="opcion[]" value="10'.$rsReg['id'].'" '.$checkeado.' />'.$rsReg['region'].'</td>';

							$fila++;
						}else {
							echo '<td><input name="opcion[]" type="checkbox" id="opcion[]" value="10'.$rsReg['id'].'" '.$checkeado.' />'.$rsReg['region'].'</td></tr>';
							$fila=0;
						} 
					} 
				?>
              </table>
        </div>
        
        <div class="responsables">
        	<table class="formulario" style="width:100%">
                <!--modulo de OS-->
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="42" <? if (in_array(42, $idOpciones)) echo 'checked="checked"'; ?>/>
                      	Modulo Responsables
                    </td>
                </tr>
                <tr>
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="421" <? if (in_array(421, $idOpciones)) echo 'checked="checked"'; ?>/>                     
                         Responsables->Eliminar
                    </td>
                
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="422" <? if (in_array(422, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Responsables->Modificar
                    </td>
                
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="423" <? if (in_array(423, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Responsables->Crear
                    </td>
                </tr>
                <tr>                	
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="424" <? if (in_array(424, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Responsables->Cambio Estado
                    </td>
                </tr>
        	</table>
        </div>     
        
        
        <div class="coordinadores">
        	<table class="formulario" style="width:100%">
                <!--modulo de OS-->
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="43" <? if (in_array(43, $idOpciones)) echo 'checked="checked"'; ?>/>
                      	Modulo Coordinadores
                    </td>
                </tr>
                <tr>
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="431" <? if (in_array(431, $idOpciones)) echo 'checked="checked"'; ?>/>                     
                         Coordinadores->Eliminar
                    </td>
                
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="432" <? if (in_array(432, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Coordinadores->Modificar
                    </td>
                
                    <td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="433" <? if (in_array(433, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Coordinadores->Crear
                    </td>
                </tr>
                <tr>
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="434" <? if (in_array(434, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Coordinadores->Aprobar
                    </td> 
                	<td>
                    	<input name="opcion[]" type="checkbox" id="opcion[]" value="435" <? if (in_array(435, $idOpciones)) echo 'checked="checked"'; ?>/> 
                         Coordinadores->Cambio Estado
                    </td>
                </tr>
        	</table>
        </div>     
        
    </div>
    

    <table class="formulario" style="width:100%">

        <tbody>
        
           
            <tr>

                  <tr>

                    

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="2" <? if (in_array('2', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Costos</td>

                     

                  </tr>

                  <tr>

                    

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="4" <? if (in_array('4', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Tareas</td>

                      <td><input name="opcion[]" type="checkbox" id="opcion[]" value="5" <? if (in_array('5', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Ingresos

</td>

                  </tr>

                 

                  <tr>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="6" <? if (in_array('6', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Clientes

</td>

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="7" <? if (in_array('7', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Proveedores

</td>

					
                  </tr>

                  <tr>


                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="11" <? if (in_array('11', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Cotizaciones

</td>

                  </tr>

                  

                  <tr>

                    
					<td><input name="opcion[]" type="checkbox" id="opcion[]" value="14" <? if (in_array('14', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Reportes

</td>

                  </tr>

                  <tr>

                    

                    <td><input name="opcion[]" type="checkbox" id="opcion[]" value="15" <? if (in_array('15', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Comercial

</td>

                  </tr>              

                 

                

                 <tr>

                   
                     <td>

                   	<input name="opcion[]" type="checkbox" id="opcion[]" value="23" <? if (in_array('23', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      P.O

				    </td>
                    
                </tr>

                

                <tr>

					<td>

                	<input name="opcion[]" type="checkbox" id="opcion[]" value="24" <? if (in_array('24', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Ingresos

                	</td>
                    
                    <td>

                	<input name="opcion[]" type="checkbox" id="opcion[]" value="31" <? if (in_array('31', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      Facturas

                	</td>
                    

                </tr>
                <tr>
                	<td>

                		<input name="opcion[]" type="checkbox" id="opcion[]" value="37" <? if (in_array('37', $idOpciones)) echo 'checked="checked"'; ?> /> 

                      	Herramientas Admin

                	</td>
                  
                </tr>
                

            </tr>

    
        </tbody>

        <tfoot>

            <tr>

                <td colspan="2">
					<? if(in_array(132,$_SESSION['permisos'])): ?>
                    <input name="modificar" type="submit" id="modificar" value="Modificar" />
					<? endif; ?>
                    <input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />

                </td>

            </tr>

        </tfoot>

    </table>

</form>

<script language="javascript" type="text/javascript">

	$(document).ready(function(){

		
		$("#frm_per").validate({

			submitHandler: function(form) {

				var respuesta = confirm('\xBFDesea realmente modificar a este cliente?')

				if (respuesta)

					form.submit();

			}

		}); 

		$('#telefo').setMask('(999) 999-9999');

		$('#celula').setMask('(999) 999-9999');

	});

	

	function fn_modificar(){

		var str = $("#frm_per").serialize();

		$.ajax({

			url: 'ajax_modificar.php',

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