
<h2>Importaci&oacute;n Excel a Anticipos</h2>
		
<div class="span9">
    <div class="content-box">
        <div class="clear">				
            <input type="button" id="cerrar" class="btn btn-large clearfix" value="Cerrar" onClick="fn_cerrar()">		
            <input type="button" id="upload-btn" class="btn btn-large clearfix" value="Selecione un Archivo">
<span style="padding-left:5px;vertical-align:middle;"><i>XLS(120K tama&ntilde;o maximo)</i></span>
            <div id="errormsg" class="clearfix redtext">
            </div>	              
            <div id="pic-progress-wrap" class="progress-wrap" style="margin-top:10px;margin-bottom:10px;">
            </div>						
        	
        </div>
    </div>					
</div>

<script type="text/javascript" src="/excel/js/SimpleAjaxUploader.js"></script>
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
        url: '/excel/upload_file.php',
        progressUrl: '/excel/uploadProgress.php',
        name: 'uploadfile',
        multiple: true,
        maxUploads: 1,
        maxSize: 120,
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
			 	$.post('/excel/index.php',function(data){
					$('.content_table').html(data);
				})
			 
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

<div class="content_table"></div>
