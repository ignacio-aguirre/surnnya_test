<?php
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Vuelco de Datos en Excel";
include("encabezado.php");
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
?>
</div>
<div class="container">
<form class="form-inline" onsubmit="return false">
<div class="form-group has-warning">
<label class="label-form" for="anio">A&ntilde;o:</label>
<input class="form-control" id="anio" size="4" maxlength="4" value="<?php echo $anio?>" autofocus>
</div>
<div class="form-group has-warning">
<label class="label-form">Trimestre:</label>
<select class="form-control" id="trimestre"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select>
<script>
seleccionar("trimestre","<?php echo $trimestre?>");
</script>
</div>
<button class="btn-success" onclick="descargar()">Excel</button>
</form>
</div>
<script>
function descargar(){
anio=document.getElementById("anio").value;
trimestre=document.getElementById("trimestre").value;
navega("vuelco_do?anio="+anio+"&trimestre="+trimestre);
}
</script>
</html>
