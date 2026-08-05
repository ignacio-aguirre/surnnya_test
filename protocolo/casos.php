<?php 
include("funciones.php");
session_start();
tranca();
$_SESSION['titulo']="Casos activos";
include("encabezado-test.php")?>
<script>
function uncaso(id){
navega("llevaauncaso?id="+id);
}
</script>
<div class="container" align="center">
<h1>Casos Activos</h1>
<?php if($_SESSION["sistema"]==1) echo "<a href='nuevocaso'><img width='20' height='20' src='imagenes/mas.png'>&nbsp;Agregar</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='casos_desactivados'><img width='20' height='20' src='imagenes/ver.svg'>&nbsp;Ver Casos Desactivados</a>";
?>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover table-condensed">
<tr class="info">
<th>Apellidos</th><th>Nombres</th><th>edad</th><th>Juzgado civil</th><th>DZ o Sector CDNNYA</th>
</tr>
<?php
$cas=registros("select idcasos,apellidos,nombres,edadcalc(fecha_nacimiento,edad,fecha_edad,null) as eda, juzgado, cdnnya from casos where activo=1 order by apellidos, nombres");

while($c=mysqli_fetch_assoc($cas)){

 echo si($_SESSION["simple"]=="1","<tr><td>","<tr onclick='uncaso(".$c["idcasos"].")'><td>"),$c["apellidos"],"</td><td>",$c["nombres"],"</td><td>",$c["eda"],
"</td><td>",$c["juzgado"],"</td><td>",$c["cdnnya"],"</td></tr>";
};
?>
</table>
</div>
</div>
<script src="js/generales.js"></script>
</body>
</html>
