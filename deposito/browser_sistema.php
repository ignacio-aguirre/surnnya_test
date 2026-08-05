<?php 
include("funciones.php");
session_start();
$tabla=$_GET["tipo"];
echo "<table id='brow' class='table table-bordered table-condensed'>";
if($tabla=="ACTIVIDADES"){
 $desde=fget("desde");
 $hasta=fget("hasta");
 echo "<tr class='bg-primary'><th>Fecha y hora</th><th>Acci&oacute;n</th><th>id<th>Referencia</th><th>Usuario</th></tr>";
 $reg=registros("select concat(registro_acciones.fecha,' ',registro_acciones.hora) as fyh, accion, comprobante,
 referencia, concat(apellido,', ',nombre) as descripcion from registro_acciones 
 left join usuarios on usuario=idusuarios 
 where registro_acciones.fecha between ".$desde." and ".$hasta." order by registro_acciones.fecha desc, registro_acciones.hora desc");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["fyh"]."</td><td>".$r["accion"]."</td><td>".$r["comprobante"]."</td><td>".$r["referencia"]."</td><td>".$r["descripcion"]."</td></tr>";
 };
echo "</table>";
};
?>

