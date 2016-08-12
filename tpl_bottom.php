			</div>

                <div style="clear:both"></div>

            </div>

        </div>

    </div>

    <div id="footer" class="labels1"></strong>Todos los derechos reservados en im&aacute;genes y contenido<br />

            <br />

              Desarrollado por:

              <strong><a href="http://www.signsas.com" target="_blank">SIGN SAS</a></strong><br />

    </div>
	
    <div style="font-size:12px; float:right;"><?=(!empty($_SESSION["ultimoAcceso"]))?$_SESSION["ultimoAcceso"]:''?></div>
    
</div>

<script type="text/javascript">

var Accordion1 = new Spry.Widget.Accordion("Accordion1", <?php echo (isset($_GET['tab'])) ? $_GET['tab'] : 0;?>);

</script>

</body>




</html>

