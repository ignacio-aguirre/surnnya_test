<?php 
include("funciones.php");
session_start();
tranca();?>
<html lang="es">
<head>
<title>Casos Desactivados</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../bootstrap-3.3.6-dist/css/bootstrap.min.css">
</head>
<body>
<script>
function uncaso(id){
navega("llevaauncaso?id="+id);
}
</script>
<div class="container" align="right">
<a href="menu"><img width="20" height="20" src="imagenes/menu.png">Men&uacute;</a>&nbsp;&nbsp;<a href="salir"><img width="20" height="20" src="imagenes/flecha.png">Salir</a>
</div>
<div class="container" align="center">
<h1>Casos Desactivados</h1>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-stripped table-bordered table-hover table-condensed">
<tr class="info">
<th>Apellidos</th><th>Nombres</th><th>edad</th><th>Reactivar</th>
</tr>
<?php
$cas=registros("select idcasos,apellidos,nombres,edadcalc(fecha_nacimiento,edad,fecha_edad,null) as eda from casos where activo=0 order by apellidos, nombres");
while($c=mysqli_fetch_assoc($cas)){
// echo "<tr onclick='uncaso(".$c["idcasos"].")'><td>",$c["apellidos"],"</td><td>",$c["nombres"],"</td><td>",$c["eda"],"</td><td>","<a href='reactivacaso?id=".$c["idcasos"]."'><img width='20' height='20' src='imagenes/mas.png'></a></td></tr>";

 echo "<tr><td>",$c["apellidos"],"</td><td>",$c["nombres"],"</td><td>",$c["eda"],"</td><td>","<a href='reactivacaso?id=".$c["idcasos"]."'><img width='20' height='20' src='imagenes/mas.png'></a></td></tr>";
};
?>
</table>
</div>
</div>
<script src="../bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="../bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="js/generales.js"></script>
</body>
</html>
