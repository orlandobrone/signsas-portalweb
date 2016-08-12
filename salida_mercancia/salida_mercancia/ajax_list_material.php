<? header('Content-type: text/html; charset=iso-8859-1');
	include "../../conexion.php";
	include "../../funciones.php";
	if(empty($_POST['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}
?>

<!-- librería grilla --> 
<script type="text/javascript" src="/js/flexigrid.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/js/flexigrid.css" title="win2k-cold-1">

<style>
	.aprobar{ background:url('https://cdn1.iconfinder.com/data/icons/fatcow/16/accept.png') no-repeat; }
	.desaprobar{ background:url('https://cdn1.iconfinder.com/data/icons/fugue/icon_shadowless/cross_circle.png') no-repeat; }
	.excel{  background:url('https://cdn1.iconfinder.com/data/icons/fatcow/16/page_white_excel.png') no-repeat; }
</style>

<h1>Lista de Materiales</h1>

<table id="flex1" style="display: none"></table>
<br />
<input name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />

<?php if(!aprobadoDesapacho($_POST['ide_per'])): ?>
<input name="aceptar" type="button" id="aceptar" value="Aceptar" onclick="fn_aprobarAll(<?=$_POST['ide_per']?>,<?=$_POST['id_proyecto']?>);"  style="margin-bottom:20px;"/>

<?php else: ?>
	Esta lista de desapacho ya fue aprobada.<br />
<?php endif; ?>



<script language="javascript" type="text/javascript">
$(document).ready(function(){
		
	$("#flex1").flexigrid({
			url: '/ajax/listMateriales.php?id=<?=$_POST['ide_per']?>',
			dataType: 'json',
			colModel : [
				{display: 'ID', name : 'id', width : 40, sortable : false, align: 'center'},
				{display: 'Material', name : 'material', width : 200, sortable : false, align: 'center'},
				{display: 'Cantidad', name : 'cantidad', width : 60, sortable : false, align: 'left'},
				{display: 'Costo', name : 'costo', width : 150, sortable : false, align: 'left'},
				{display: 'Estado', name : 'estado', width : 80, sortable : false, align: 'left'}					
			],
			buttons : [				
				{name: 'Aprobar', bclass: 'aprobar', onpress : fn_aprobar},
				{name: 'Desaprobar', bclass: 'desaprobar', onpress : fn_desaprobar},
				{name: 'Exportar a Excel', bclass: 'excel', onpress : ExportarExcel}
			],
			/*searchitems : [		
				{display: 'No Documento', name : 'cedula', isdefault: true}
			],*/
			sortname: "id",
			sortorder: "asc",
			usepager: true,
			title: 'Lista de Materiales - Salida de Mercancia',
			useRp: true,
			rp: 15,
			showTableToggleBtn: true,
			width: 600,
			height: 300
		}); 
		
	});
	
	
	function fn_aprobar(com, grid){
                
	  var conf = confirm('Aprobar ' + $('.trSelected', grid).length + ' items?')
	  if(conf){
		  $.each($('.trSelected', grid),
			  function(key, value){ 
				  $.post('ajax_aprobar.php', { IdMaterial: value.firstChild.innerText}, function(){
						  // when ajax returns (callback), update the grid to refresh the data
						  $("#flex1").flexReload();
				  });
		  });    
	  }
	}
	
	
	function fn_desaprobar(com, grid){
                
	  var conf = confirm('Desaprobar ' + $('.trSelected', grid).length + ' items?')
	  if(conf){
		  $.each($('.trSelected', grid),
			  function(key, value){ 
				  $.post('ajax_desaprobar.php', { IdMaterial: value.firstChild.innerText}, function(){
						  // when ajax returns (callback), update the grid to refresh the data
						  $("#flex1").flexReload();
				  });
		  });    
	  } 
	}
	
	function fn_aprobarAll(idDespacho,idProyecto){
		  var conf = confirm('\xBFDesea completar esta operaci\xF3n?')
		  if(conf){
				$.post('ajax_aprobarAll.php', { id:idDespacho, id_proyecto:idProyecto}, function(data){ 
						if(data != 'Guardado'){
							alert(data);
						}else{
							fn_cerrar();
						}
				});
		  }
	
	}
	
	function ExportarExcel(){
					var data='<table>'+$("#flex1").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
						$('body').prepend("<form method='post' action='/exporttoexcel.php' style='display:none' id='ReportTableData'><input type='text' name='tableData' value='"+data+"' ></form>");
						 $('#ReportTableData').submit().remove();
						 return false;
	}
	

</script>