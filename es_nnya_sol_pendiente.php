<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
?>
</div>
<div class="container">
<strong>NNYA con Solicitudes Pendientes</strong>
<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr><th>Apellido y Nombre</th><th>Edad</th><th>RIB</th><th>Opciones</th></tr>
<?php
   $sql="select sujetos.legajo, apellidos, nombres, rib_anio,rib_numero, rib_reparticion, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,null,null) as edc from sujetos 
 where sujetos.legajo in (select distinct es_participaciones.legajo from es_participaciones where fecha_inicio is null and fecha_rechazo is null)
 order by apellidos, nombres ";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      $conta=$conta+1;
  echo "<tr><td>".$r["apellidos"].", ".$r["nombres"]."</td>";
      echo "<td>".$r["edc"]."</td><td>".rib($r["rib_anio"],$r["rib_numero"],$r["rib_reparticion"])."</td><td>";
      echo "<btn class='btn-sm btn-success' onclick='accion(".$r["legajo"].")'>Solicitudes</btn>&nbsp;";
      echo "</td></tr>";
   };   
?>

</table>

</div>

<script>
function accion(legajo){
 navega("es_solpend_legajo?legajo="+legajo);
}
</script>
</body>

</html>