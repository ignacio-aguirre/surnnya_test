<?php
include("Funciones.php");
session_start();
$id=$_GET["id"];
$_SESSION["prestacion"]="Intervenciones con la Familia ".un_campo("select descripcion from fv_familias where idfv_familias=".$id);
include("encabezado-test.php");
?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><td>Derivante</td><td>Expediente</td><td>Centro Zonal</td><td>Estado</td></tr>
<?php
$reg=registros("select deri.info,derivante_especificar, expediente,denominacion, estado_sol(20220101,curdate(), fecha_articulacion,fecha_rechazo,fecha_asignacion,fecha_baja,fecha_ingreso,fecha_cancelacion) as estado,
 fv_participaciones.id from fv_participaciones 
 left join sectores on efector=sectores.id 
 left join tablas deri on deri.tipo='CM' and deri.valo=derivante
 where fv_participaciones.familia=".$id." order by fecha_asignacion desc");
$altas=0;
while($r=mysqli_fetch_assoc($reg)){
   $altas=$altas+si($r["fecha_baja"]=="",1,0);	
   echo "<tr><td>".$r["info"].$r["derivante_especificar"]."</td><td>".$r["expediente"]."</td><td>".$r["denominacion"]."</td><td>".$r["estado"]."</td></tr>";
}; 
?>
</table>
</div>
</div>
</body>
</html>