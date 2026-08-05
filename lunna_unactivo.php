<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Consulta de Usuarios Activos";
include("encabezado-test.php");
$id=nget("id");
$r=un_registro("select * from lunna_activos where id=".$id);
?>
</div>
<div class="container">
<h3><?php echo $r["nombre"]?></h3>
<div class="row">
 <div class="col-md-4">CUIL <p class="text-primary"><strong><?php echo $r["cuil"]?></strong></p></div>
 <div class="col-md-4">Usuario SADE <p class="text-primary"><strong><?php echo $r["usuario"]?></strong></p></div>
 <div class="col-md-4">Email <p class="text-primary"><strong><?php echo $r["mail"]?></strong></p></div>
</div>
<hr>
<div class="row">
 <div class="col-md-4">Repartici&oacute;n <p class="text-primary"><strong><?php echo $r["reparticion"]?></strong></p></div>
 <div class="col-md-4">Sector <p class="text-primary"><strong><?php echo $r["sector"]?></strong></p></div>
 <div class="col-md-4">Perfil LUNNA <p class="text-primary"><strong><?php echo $r["perfil"]?></strong></p></div>
</div>
<h3>Multi reparticiones</h3>
A desarrollar
<h3>Accesos Directos</h3>
<div class="row">
 <div class="col-md-3"><button class="btn-primary" onclick='ntarea()'>Nueva Tarea</button></div>
 <div class="col-md-3"><button class="btn-secondary">Editar</button></div>
 <div class="col-md-3"><button class="btn-info">Historial de cambios</button></div>
 <div class="col-md-3"><button class="btn-dark">Registrar Inactivaci&oacute;n</button></div>
</div>
</div>
<script>
function ntarea(){
 navega("lunna_tareas_nueva?id=<?php echo $id?>");
}
</script>
</body>
</html>