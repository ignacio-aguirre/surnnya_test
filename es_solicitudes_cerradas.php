<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
?>
</div>
<div class="container">
<strong>Solicitudes Cerradas</strong>
<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr><th>Fecha</th><th>Apellido y Nombre, edad</th><th>Solicitante</th><th>Profesi&oacute;n</th><th>Fecha Cierre</th><th>Acciones</th><th>Opciones</th></tr>
<?php
   $sql="select es_participaciones.*, sujetos.*, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre as solicitante, espe.deno as especialidad , (select count(*) from es_acciones where solicitud=es_participaciones.id) as cant   
  from es_participaciones left join sujetos on es_participaciones.legajo=sujetos.legajo 
  left join dispositivos on dispositivos.id=es_participaciones.solicitante
  left join tablas espe on espe.tipo='ESESP' and espe.valo=es_participaciones.especialidad
 where fecha_fin is not null order by apellidos,nombres,fecha_fin";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      $conta=$conta+1;
      $lega=$r['legajo'];
      $apyn=si($lega=="0","",$r["Apellidos"].", ".$r["Nombres"]." (".$r["edadc"].")");
      echo "<tr><td>".ffec($r["fecha_ingreso"])."</td><td>".$apyn."</td><td>".trim($r["solicitante"]." ".$r["solicitante_especificar"]).
  "</td><td>".$r["especialidad"]."</td><td>".ffec($r["fecha_fin"])."</td><td>".$r["cant"]."</td><td>";
      echo "<btn class='btn-sm btn-warning' onclick='informe(".$r["id"].")'>Informe</btn>&nbsp;";	
      echo "</td></tr>";

   };   
?>

</table>
<?php echo $conta." solicitudes cerradas" ?>
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
function nopert(id){
 navega("es_estado?solicitud="+id+"&estado=np");
}

function informe(id){
 navega("informe_solicitud_es?id="+id);
}

</script>
</body>

</html>