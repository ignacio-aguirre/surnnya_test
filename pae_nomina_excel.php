<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Descarga de N&oacute;mina PAE en Excel";
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$al=$_SESSION['DiaHoy'];
?>
</div>
<div class="container">
<form class="form-inline" action='pae_excel' method="get" onsubmit="return valida_datos()">
<div class="form-group has-warning">
<label class="label-form" for="al">N&oacute;mina al</label>
<input class="form-control" size='8' maxlength='10' name='al' id='al' value="<?php echo $al?>" onblur='valida_fecha(this.id)'>
</div>
<button class='btn-success' type='submit'>Descargar</button>
</form>
</div>
<script type="text/javascript">

enfoca('fecha');

function valida_datos() {
return true;

}

</script>
</body>
</html>