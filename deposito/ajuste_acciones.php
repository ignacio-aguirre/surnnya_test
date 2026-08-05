<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Archivo Subido";
include("encabezado-test.php");
?>
<div class="container">
<h3>Se ha detectado un archivo para procesar</h3>
<h4>Procesar como Inventario</h4>
<p class="text-info">Las cantidades en el documento se comparan con el stock actual y se ajustan las que tienen diferencias y la cantidad informada es mayor que cero</p>
<button class="btn btn-info" onclick="proc_inventario()">Inventario</button>
<h4>Procesar como Ajuste</h4>
<p class="text-success">Las cantidades en el documento significan cantidades a sumar o restar seg&uacute;n el signo de la cantidad</p>
<button class="btn btn-success" onclick="proc_ajuste()">Ajuste</button>
<h4>Eliminar archivo subido</h4>
<p class="text-danger">Se elimina el archivo subido</p>
<button class="btn btn-danger" onclick="proc_eliminar()">Eliminar</button>
</div>
<script>
function proc_ajuste(){
  navega("ej_stock?tipo=AJUSTES_NUEVO");
}
function proc_inventario(){
  navega("ej_stock?tipo=INVENTARIO_NUEVO");
}
function proc_eliminar(){
 navega("ej_stock?tipo=AJUSTES_ARCH_ELIMINAR");
}
</script>
</body>