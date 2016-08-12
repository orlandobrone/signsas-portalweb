// JavaScript Document



$(document).ready(function(){

	//fn_buscar();

	$("#grilla tbody tr").mouseover(function(){

		$(this).addClass("over");

	}).mouseout(function(){

		$(this).removeClass("over");

	});

});



function fn_cerrar(idIngreso){
	
	if(idIngreso != ''){
		$.ajax({
				url: 'ajax_eliminar_idmercancia.php',
				data: 'id_ingreso=' + idIngreso,
				type: 'post',
				success: function(data){
					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
					
					/*$.unblockUI({ 
						onUnblock: function(){
							$("#div_oculto").html("");
						}
					}); */
					
					$('#eventWindow').jqxWindow('close');
				}
		});
	} 
	
	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');

};



function fn_mostrar_frm_agregar(){ 

	$("#content_form").load("ajax_form_agregar.php", function(){

		/*$.blockUI({

			message: $('#div_oculto'),

			css:{

				width: '660px',

				top: '2%',

				left: '24%',

				'max-height': '580px',

				'min-height': '580px',

				'overflow-y': 'scroll'	

			}

		});*/
		
		 $('#eventWindow').jqxWindow('open');

		

		//$("#jqxgrid").jqxGrid('updatebounddata', 'cells'); 

	});
	
	
	  

};



function fn_mostrar_frm_modificar(ide_per){

	$("#div_oculto").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){

		$.blockUI({

			message: $('#div_oculto'),

			css:{

				top: '20%'

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



function fn_eliminar(ide_per){

	var respuesta = confirm("Desea eliminar este ingreso de mercancia?");

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



function fn_buscar(){

	var str = $("#frm_buscar").serialize();

	$.ajax({

		url: 'ajax_listar.php',

		type: 'get',

		data: str,

		success: function(data){

			$("#div_listar").html(data);

		}

	});

}