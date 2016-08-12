<?php  include "../../restrinccion.php";  ?>


    <?php require_once "../../config.php"; 
		  require_once "../../restrinccion.php"; 

	define('URL_SECCION', URL_HITOS_UPLOAD);

	define('SECCION', UPLOAD); ?>

	<?php require_once "../../tpl_top.php"; ?>

    <script src="/js/masknoney/jquery.maskMoney.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function () {

            var source = {
                 datatype: "json",
                 datafields: [
					 { name: 'id', type: 'number'},
					 { name: 'id_hito', type: 'number'},
					 { name: 'cant_galones', type: 'number'},					 
					 { name: 'po', type: 'string'},
					 { name: 'gr', type: 'string'},
					 { name: 'factura', type: 'string'},
					 { name: 'valor_facturado', type: 'number'},
					 { name: 'fecha_facturado', type: 'date'},
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

                  { text: 'ID', datafield: 'id', filtertype: 'number', filtercondition: 'equal',   columntype: 'textbox',width:90 },

                  { text: '-', datafield: 'acciones', filtertype: 'textbox',pinned: true, width:60},

				  { text: 'ID Hito', datafield: 'id_hito', filtertype: 'textbox', filtercondition: 'starts_with'},

                  { text: 'Cant Galones', datafield: 'cant_galones', filtertype: 'none', filtercondition: 'starts_with' },
				  
				  { text: 'PO', datafield: 'po', filtertype: 'none', filtercondition: 'starts_with',width:120 },
				  
				  { text: 'GR', datafield: 'gr', filtertype: 'none', filtercondition: 'starts_with' ,width:120},
				  
				  { text: 'Factura', datafield: 'factura', filtertype: 'none', filtercondition: 'starts_with' },
				  
				  { text: 'Valor Facturado', datafield: 'valor_facturado', filtertype: 'textbox', filtercondition: 'starts_with', cellsformat: 'c2',cellsalign: 'right' },	
				  			  
				  { text: 'Fecha Facturado', datafield: 'fecha_facturado', cellsformat: 'yyyy-MM-dd' }

                ]

            });

            $(".btn_table").jqxButton({ theme: theme });

            $('#clearfilteringbutton').click(function () {
                $("#jqxgrid").jqxGrid('clearfilters');
            });

			$("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Conceptos');           
            });

			$('#excelExport2').click(function(){
				window.open("/financiero/financiero/export_excel.php");
			});
			$('#downloadExample').click(function(){
				window.open("/financiero/preciosacpm/listahitos.xls");
			});
			
			$('#btnUpdateHitos').click(function(){
				
				swal({   
						title: "Esta seguro?",   
						text: "Al aceptar se haran cambios a los hitos de la grilla actual",   
						type: "warning",   
						showCancelButton: true,   
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Si",   
						closeOnConfirm: true 
				},function(res){   
					if(res){
					
						$.ajax({
							url: 'ajax_modificar.php',
							dataType: 'json', // Notice! JSONP <-- P (lowercase)
							type: 'post',
							success: function(data){
								if(data.estado) {
									swal({   
											title: "Exitoso",   
											text: "Los cambios a los hitos fueron exitosos, revisar",   
											type: "success",   
											showCancelButton: false,   
											confirmButtonColor: "#DD6B55",   
											confirmButtonText: "Ok, revisare",   
											closeOnConfirm: false 
									});
								}else{
									swal({   
											title: "Uppsss!",   
											text: "Hubó un error al actualizar los hitos, llamar al tecnico",   
											type: "success",   
											showCancelButton: false,   
											confirmButtonColor: "#DD6B55",   
											confirmButtonText: "Ok, lo llamare",   
											closeOnConfirm: false 
									});
								}
							},
							error: function(err) {
								alert(err);
							}
				
						});
					}					
				});
			});
			
			$('#btnClearHitos').click(function(){
				swal({   
						title: "Esta seguro?",   
						text: "Al aceptar borrara la tabla temporal update hitos",   
						type: "warning",   
						showCancelButton: true,   
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Si",   
						closeOnConfirm: true 
				},function(res){   
					if(res){
					
						$.ajax({
							url: 'ajax_clear.php',
							dataType: 'json', // Notice! JSONP <-- P (lowercase)
							type: 'post',
							success: function(data){
								if(data.estado) {									
									$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
								}
							},
							error: function(err) {
								alert(err);
							}
				
						});
					}					
				});
			});
			
	
        });

    </script>

    

    <div id="cuerpo">

            <h1>HITOS UPLOAD</h1>       

            <div style="background:#ECECEC; margin-bottom:15px;border:1px solid #CCC;padding:10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; width:96%; margin-top:20px;">

             <input value="Reiniciar Filtros" id="clearfilteringbutton" type="button" class="btn_table" />
             
             <input value="Bajar Formato" id="downloadExample" type="button" class="btn_table" />
             
             <input value="Aplicar Script" id="btnUpdateHitos" type="button" class="btn_table" />
              
             <input value="Limpiar Tabla" id="btnClearHitos" type="button" class="btn_table" />

          <!--   <input type="button" value="Exportar a Excel" id='excelExport' class="btn_table" />

             <input type="button" value="Exportar Todo" id='excelExport2' class="btn_table" />-->
             
           
             	<label>Importar Excel</label>
                
                <input type="button" id="upload-btn" class="btn btn-large clearfix" value="Selecione un Archivo">
    
    			<span style="padding-left:5px;vertical-align:middle;"><i>XLS(120K tama&ntilde;o maximo)</i></span>
    
                <div id="errormsg" class="clearfix redtext"></div>
                
                <div id="pic-progress-wrap" class="progress-wrap" style="margin-top:10px;margin-bottom:10px;"></div>          
            </div>


            <div id="jqxgrid"></div>

            
            <div id="div_oculto" style="display: none;"></div> 

            <p align="right">Desarrollado por: <strong>Signsas</strong><br /><a href="http://www.signsas.com" target="_blank">www.signsas.com</a></p>

        </div>

    <?php require_once "../../tpl_bottom.php"; ?>


<script type="text/javascript" src="../../excel/js/SimpleAjaxUploader.js"></script>
<script>
function safe_tags( str ) {

  return String( str )

           .replace( /&/g, '&amp;' )

           .replace( /"/g, '&quot;' )

           .replace( /'/g, '&#39;' )

           .replace( /</g, '&lt;' )

           .replace( />/g, '&gt;' );

}



  var btn = document.getElementById('upload-btn'),

      wrap = document.getElementById('pic-progress-wrap'),

      picBox = document.getElementById('picbox'),

      errBox = document.getElementById('errormsg');

	

  var uploader = new ss.SimpleUpload({

        button: btn,
        url: '../../excel/upload_hito_file.php',
        progressUrl: '../../excel/uploadProgress.php',
        name: 'uploadfile',
        multiple: false,
        maxUploads: 1,
        maxSize: 1200,
        allowedExtensions: ['xls'],
        accept: 'xls',
        hoverClass: 'btn-hover',
        focusClass: 'active',
        disabledClass: 'disabled',
        responseType: 'json',
        onExtError: function(filename, extension) {

          alert(filename + ' is not a permitted file type.'+"\n\n"+'Only XLS.');

        },

        onSizeError: function(filename, fileSize) {

          alert(filename + ' is too big. (120K max file size)');

        },        

        onSubmit: function(filename, ext) {            

           var prog = document.createElement('div'),

               outer = document.createElement('div'),

               bar = document.createElement('div'),

               size = document.createElement('div');

                       

            prog.className = 'prog';

            size.className = 'size';

            outer.className = 'progress progress-striped active';

            bar.className = 'progress-bar progress-bar-success';

            

            outer.appendChild(bar);

            prog.innerHTML = '<span style="vertical-align:middle;">'+safe_tags(filename)+' - </span>';

            prog.appendChild(size);

            prog.appendChild(outer);

            wrap.appendChild(prog); // 'wrap' is an element on the page

            

            this.setProgressBar(bar);

            this.setProgressContainer(prog);

            this.setFileSizeBox(size);      

            

            errBox.innerHTML = '';

            btn.value = 'Selecione un archivo';

          },		

        startXHR: function() {

          // Dynamically add a "Cancel" button to be displayed when upload begins

          // By doing it here ensures that it will only be added in browses which 

          // support cancelling uploads

          var abort = document.createElement('button');

            

            wrap.appendChild(abort);

            abort.className = 'btn btn-small btn-info';

            abort.innerHTML = 'Cancel';



            // Adds click event listener that will cancel the upload

            // The second argument is whether the button should be removed after the upload

            // true = yes, remove abort button after upload

            // false/default = do not remove

            this.setAbortBtn(abort, true);              

        },          

        onComplete: function(filename, response) {

            if (!response) {

              errBox.innerHTML = 'Unable to upload file';

              return;

            }     

            if (response.success === true) {

			 	//picBox.innerHTML = '<img src="/code/ajaxuploader/view-img.php?file=' + encodeURIComponent(response.file) + '">';

			 	/*$.post('/excel/index.php',function(data){

					$('.content_table').html(data);

				})*/
				
				//$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
				setTimeout(function(){
					$("#clearfilteringbutton").trigger('click');
				},800);
			 

            } else {

              if (response.msg)  {

                errBox.innerHTML = response.msg;

              } else {

                errBox.innerHTML = 'Unable to upload file';

              }

            }

          }

	});



</script>			


<!--    </body>

</html>-->