// JavaScript Document
var calcularImpuesto = null;

$(document).ready(function(){
	
	var win = '';
	var valorTmp = 0;
	var mainDemoContainer = $('body');			
	var offset = mainDemoContainer.offset();
	
	$('input[alt=porcentaje]').inputmask({'mask':"9{0,2}.9{0,2}", greedy: false});
	$('input[name=ica]').inputmask({'mask':"9{0,2}.9{0,3}", greedy: false});
	
	$('#eventWindow').jqxWindow({
		minHeight: '250px', minWidth: '370px', zIndex:3600,
		resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false
		//position: { x: offset.left + 200, y: offset.top + 10}	
	});
	 
	$('#eventWindowForm').jqxWindow({
		minHeight: '70%', minWidth: '70%', zIndex:3500,
		resizable: true, isModal: true, modalOpacity: 0.3,autoOpen: false,
		position: { x: offset.left + 200, y: offset.top + 10}
	});

	$('.openimpuesto').live('click',function(){
		
		valorTmp = 0;
		$('.content_form input[type=text]').val(0);
		$('.content_form input[type=checkbox]').prop('checked',false);
		
		$('.content_iva, .content_ica, .content_rtefuente, .content_acpm').hide();
		
		win = $(this).attr('window');
		if(win == 'acpm'){ 
			$('.content_acpm').show();
		}else{
			$('.content_acpm input').val(0);
			$('.content_acpm').hide();
		}
		$('#eventWindow').jqxWindow('open'); 
	});
	
	$('#cancelarImp').click(function(){
		$('#eventWindow').jqxWindow('close');	
	});	
	
	$('.content_form input:checkbox').live('change',function(){

		var valorNeto = parseInt($('#valor_neto_total').val());
		
		if($(".iva").is(':checked')){ 
			var totaliva = valorNeto * iva;
			$('.content_iva').show();			
			$('input[name=iva]').val(totaliva);
		}else{
			$('.content_iva').hide();  
			$('input[name=iva]').val(0);
		}			
		
		if($('.ica').is(':checked')){  
			$('.content_ica').show(); 
		}else{
			$('.content_ica').hide();
			$('input[name=ica]').val(0);
		}
		
		if($('.rtefuente').is(':checked')){  
			$('.content_rtefuente').show(); 
		}else{
			$('.content_rtefuente').hide();
			$('input[name=rtefuente]').val(0);
		}				
		calcularImpuesto();		
	});
	
	calcularImpuesto = function(){
		
		var valorNeto = parseInt($('#valor_neto_total').val());
		var valorIca = 0;
		var valorRte = 0;
		var TotalIva = 0;
		
		if($('.ica').is(':checked')){  
			var ica = $('input[name=ica]').val();
			valorIca = parseInt(valorNeto * (ica/1000));
			console.log('ICA:'+valorIca);
		}
		
		if($('.rtefuente').is(':checked')){  
			var rtefuente = $('input[name=rtefuente]').val();
			valorRte = parseInt(valorNeto * (rtefuente/100));
			console.log('rteFuente:'+valorRte);
		}
		
		if($(".iva").is(':checked')){   
			TotalIva = valorNeto * iva;
			$('input[name=iva]').val(TotalIva);	 		
		}
		
		var totalNeto = ((valorNeto + TotalIva) - valorIca) - valorRte;
		if(valorNeto == '')
			totalNeto = 0;
			
		valorTmp = totalNeto;
		$('input[name=totalconimpuesto]').val(totalNeto);	
		
		return true;	
	}
	
	$('#calcular').live('click',function(){
		calcularImpuesto();	
	});
	
	$('#colocar').live('click',function(){
		
		if(calcularImpuesto()){	
			//$('input[name=imp_'+win+']').val($('.content_form form').serializeArray());
			$('.'+win+' .inputhidden').remove();
			
			$.each($('.content_form form').serializeArray(),function(index,data){
				if(data.value != 0)
					$('.'+win).append('<input type="hidden" class="inputhidden" name="'+win+"_"+data.name+'" value="'+data.value+'"/>');
			});
			
			console.log(valorTmp);
			
			$('.'+win+' .openimpuesto').val(valorTmp);
			$('#eventWindow').jqxWindow('close');
		}
	});

});



function fn_cerrar(idanticipo){	

	/*$.ajax({
		url: 'ajax_eliminar_trash.php',
		data: {id_anticipo: idanticipo},
		type: 'POST',
		dataType: 'json'		
	});
	*/
	$('#eventWindow').jqxWindow('close');
	$('#eventWindowForm').jqxWindow('close');
	
	$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
		}
	}); 
	
	setTimeout(function(){
		$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
	},800);

};



function fn_mostrar_frm_agregar(){
	loaderSpinner();
	$("#content_form").load("ajax_form_agregar.php", function(){
		$('#eventWindowForm').jqxWindow('open');
		stoploaderSpinner();
	});
};

function fn_mostrar_frm_aprobar(ide_ant){
	loaderSpinner();
	$("#div_oculto").load("ajax_form_aprobar.php", {ide_ant: ide_ant}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '460px',
				top: '2%',
				left: '24%',
				'max-height': '580px',
				'overflow-y': 'scroll'		
			}
		}); 
		stoploaderSpinner();
	});
};


function fn_mostrar_frm_modificar(ide_per){
	
	loaderSpinner();
	$("#content_form").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){
		$('#eventWindowForm').jqxWindow('open');
		stoploaderSpinner();
	});
	
	/*loaderSpinner();
	$("#div_oculto").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '660px',
				top: '2%',
				left: '24%',
				'max-height': '580px',
				'overflow-y': 'scroll'		
			}
		}); 
		stoploaderSpinner();
	});*/
};


function fn_mostrar_legalizaciones(ide_per){

	$("#div_oculto").load("ajax_view_legalizaciones.php", {ide_per: ide_per}, function(){

		$.blockUI({
			message: $('#div_oculto'),
			css:{
				width: '860px',
				top: '2%',
				left: '16%',
				'max-height': '580px',
				'overflow-y': 'scroll'		
			}
		}); 
	});
};



function fn_paginar(var_div, url){

	var div = $("#" + var_div);

	$(div).load(url);

	/*

	div.fadeOut("fast", function(){

		$(div).load(url, function(){

			$(div).fadeIn("fast");

		});

	});

	*/

}





function fn_importar_excel(){

	$("#div_oculto").load("/excel/form_upload.php", function(){

		$.blockUI({

			message: $('#div_oculto'),

			css:{

				width: '950px',

				top: '10%',

				left: '17%'

			}

		}); 

	});

};



function fn_eliminar(ide_per){

	var respuesta = confirm("Desea eliminar este anticipo?");

	if (respuesta){

		$.ajax({

			url: 'ajax_eliminar.php',

			data: 'id=' + ide_per,

			type: 'post',

			success: function(data){

				if(data!="")

					alert(data);

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

			}

		});

	}

}

function fn_noeliminar(ide_per){
	alert('No se puede eliminar el anticipo #'+ide_per+', esta amarrado a una legalizacion aprobada')
}

 

 

function fn_eliminar_item(ide_per, idanticipo){

	var respuesta = confirm("Desea eliminar el item selecionado del anticipo?");

	if (respuesta){
		
		$.ajax({
			url: 'ajax_eliminar_item.php',
			data: {id: ide_per, id_anticipo: idanticipo},
			type: 'POST',
			dataType: 'json',
			success: function(data){	

				if (data.estado == true){
				   $("#total_anticipo").val(data.total_anticipo);
				   $("#jqxgrid2").jqxGrid('updatebounddata');
				   //$("#jqxgrid_invacpm").jqxGrid('updatebounddata');
				}else{
					alert(data.message);
				}
			}
		});

	}

}



function fn_export_anticipo(idanticipo){

	

		window.open("/anticipos/anticipo/email_anticipo.php?ide_per="+idanticipo);

	

		/*$.ajax({

			url: 'email_anticipo.php',

			data: {ide_per: idanticipo},

			type: 'GET',

			dataType: 'json',

			success: function(data){				

				if (data.estado == false){				

					window.open("/anticipos/anticipo/email_anticipo.php?ide_per"+idanticipo);

				}

			}

		});*/



}



function fn_buscar(){

	/*var str = $("#frm_buscar").serialize();

	$.ajax({

		url: 'ajax_listar.php',

		type: 'get',

		data: str,

		success: function(data){

			$("#div_listar").html(data);

		}

	});*/

}



function fn_aprobar_anticipo(idAnticipo){

	/*var respuesta = confirm('\xBFDesea realmente cambiar el estado a aprobado?')

	if (respuesta){		

		$.post('ajax_aprobar_anticipo.php',{id:idAnticipo},function(data){			

			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

		});

	}*/ //FGR
	
	fn_mostrar_frm_aprobar(idAnticipo);

}



