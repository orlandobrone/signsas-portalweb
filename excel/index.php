<script>
$(document).ready(function(){
	$('#subir').click(function(){
		$.get('/excel/insert_db.php',function(data){ 
			if(data != "") {
				alert(data);
			}else{
				fn_cerrar();	
				fn_buscar();
			}
		})
	});
	
	$('#cerrar').click(function(){
			fn_cerrar();	
	});
	
});
</script>

<div id="divContenedor">
            <?php
					//incluimos la clase
					require_once 'php/ext/PHPExcel-1.7.7/Classes/PHPExcel/IOFactory.php';
					
					//cargamos el archivo que deseamos leer
					$objPHPExcel = PHPExcel_IOFactory::load('uploads/importar_anticipos.xls');
					//obtenemos los datos de la hoja activa (la primera) 
					$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			?>
            <br/>
            <div style="clear:both;"></div>
            <h3>Registros Encontrados: <?=count($objHoja)-1?></h3>
            
            
            <div class="content_tables">
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
                    <?php foreach (array_slice($objHoja, 0,1) as $iIndice=>$objCelda):?>
								<th><?=$objCelda['A']?></th>
								<th><?=$objCelda['B']?></th>
                                <th><?=$objCelda['C']?></th>
                                <th><?=$objCelda['D']?></th>
                                <th><?=$objCelda['E']?></th>
                                <th><?=$objCelda['F']?></th>
                                <th><?=$objCelda['G']?></th>
                                <th><?=$objCelda['H']?></th>
                                <th><?=$objCelda['I']?></th>
                                <th><?=$objCelda['J']?></th>
                                <th><?=$objCelda['K']?></th>
                                <th><?=$objCelda['L']?></th>
                                <th><?=$objCelda['M']?></th>
                                <th><?=$objCelda['N']?></th>
                                <th><?=$objCelda['O']?></th>
                                <th><?=$objCelda['P']?></th>
                                <th><?=$objCelda['Q']?></th>
                                <th><?=$objCelda['R']?></th>	
                                <th><?=$objCelda['S']?></th>			
					<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
				
				<?php	
					//recorremos las filas obtenidas
					foreach (array_slice($objHoja,1) as $iIndice=>$objCelda) {
						//imprimimos el contenido de la celda utilizando la letra de cada columna
						echo '
							<tr>
								<td>'.$objCelda['A'].'</td>
								<td>'.$objCelda['B'].'</td>
								<td>'.$objCelda['C'].'</td>
								<td>'.$objCelda['D'].'</td>
								<td>'.$objCelda['E'].'</td>
								<td>'.$objCelda['F'].'</td>
								<td>'.$objCelda['G'].'</td>
								<td>'.$objCelda['H'].'</td>
								<td>'.$objCelda['I'].'</td>
								<td>'.$objCelda['J'].'</td>
								<td>'.$objCelda['K'].'</td>
								<td>'.$objCelda['L'].'</td>
								<td>'.$objCelda['M'].'</td>
								<td>'.$objCelda['N'].'</td>
								<td>'.$objCelda['O'].'</td>
								<td>'.$objCelda['P'].'</td>
								<td>'.$objCelda['Q'].'</td>	
								<td>'.$objCelda['R'].'</td>
								<td>'.$objCelda['S'].'</td>								
							</tr>
						';
					}
				?>
				</tbody>
				
			</table>
            
            </div>
</div>

<pre>
<?php //print_r(array_slice($objHoja,1));?>
</pre>

<div style="clear:both; height:20px;"></div>

<div class="span9">
    <div class="content-box">
        <div class="clear">						
            <input type="button" id="subir" class="btn btn-large clearfix" value="Subir">
        </div>
    </div>					
</div>