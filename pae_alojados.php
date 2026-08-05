<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
?>
</div>
<div class="container">
<form class="form-inline" onsubmit="return valida()" method="GET" action="pae_alojados_excel">
 <div class="form-group has-warning">
   <label class="label-form">Emitir al d&iacute;a:&nbsp;</label>
   <input class="form-control" id="fecha" name="fecha" size="10" maxlength="10" onblur="valida_fecha(this.id)" autofocus>
 </div>
 <input class="btn-success" type="submit" value="Excel">
</form>
</div>  	
</body>
<script>
function valida(){
valida_fecha("fecha");
if(document.getElementById("fecha").value=="") {return false;};
return true;
}
</script>
</html>