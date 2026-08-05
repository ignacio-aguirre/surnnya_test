<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
if (!isset($_GET['legajo'])) header ("Location: salir");
$legajo=nget("legajo")
?>
</div>
<div class="container">
<strong>Solicitudes Abiertas para <?php echo un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$legajo)?></strong>
<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr><th>Fecha</th><th>Solicitante</th><th>Profesi&oacute;n</th><th>Ult.Acci&oacute;n</th><th>Opciones</th></tr>
<?php
   $sql="select es_participaciones.*,
 dispositivos.nombre as solicitante, espe.deno as especialidad, (select max(fecha) from es_acciones where solicitud=es_participaciones.id) as ulti    
  from es_participaciones 
  left join dispositivos on dispositivos.id=es_participaciones.solicitante
  left join tablas espe on espe.tipo='ESESP' and espe.valo=es_participaciones.especialidad
 where fecha_inicio is not null and fecha_fin is null and legajo=".$legajo." order by fecha_ingreso asc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      $conta=$conta+1;
      $lega=$r['legajo'];
      echo "<tr><td>".ffec($r["fecha_ingreso"])."</td><td>".trim($r["solicitante"]." ".$r["solicitante_especificar"]).
  "</td><td>".$r["especialidad"]."</td>";
      echo "<td>".ffec($r["ulti"])."</td><td>";
      echo "<btn class='btn-sm btn-success' onclick='accion(".$r["id"].")'>+Acc</btn>&nbsp;";
      echo "<btn class='btn-sm btn-danger' onclick='finalizar(".$r["id"].")'>Fin</btn>&nbsp;";
      echo "<btn class='btn-sm btn-warning' onclick='informe(".$r["id"].")'>Informe</btn>&nbsp;";	
      echo "</td></tr>";

   };   
?>

</table>

</div>

<script>
function accion(id){
 navega("es_accion_nueva?solicitud="+id);
}
function finalizar(id){
 navega("es_estado?solicitud="+id+"&estado=cr");
}

function editar(id){
 navega("una_solicitud_es?id="+id);
}

function informe(id){
 navega("informe_solicitud_es?id="+id);
}

</script>
</body>

</html>