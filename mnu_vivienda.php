<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Opciones Vivienda";
include("encabezado-test.php");
$legajo=nget("legajo");
$apynom=un_campo("select concat(apellidos,', ',nombres) as apy from sujetos where legajo=".$legajo);
?>
<div class="container" align="center">
<script>
function vivienda(legajo){
 navega("suje_cons_vivienda?legajo="+legajo);
}
function ingreso(legajo){
 navega("alpre_ingreso?legajo="+legajo);
}
</script>
<p class="text-dark"><?php echo $apynom?></p>
<br><br><br>
<button class="btn btn-success" onclick="vivienda('<?php echo $legajo?>')">VIVIENDA</button>
<br><br><br>
<button class="btn btn-info" onclick="ingreso('<?php echo $legajo?>')">INGRESO a Dispositivo de Pre Egreso</button>
</div>
</body>