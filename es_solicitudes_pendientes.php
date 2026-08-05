<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
?>
</div>
<div class="container">
<strong>Solicitudes Pendientes</strong>
<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr style="font-size:.9em;"><th>Fecha</th><th>Apellido y Nombre, edad</th><th>Solicitante</th><th>Profesi&oacute;n</th><th>Profesional</th><th>Opciones</th></tr>
<?php
   $sql="select es_participaciones.*, sujetos.*, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre as solicitante, espe.deno as especialidad,es_profesionales.apellido     
  from es_participaciones left join sujetos on es_participaciones.legajo=sujetos.legajo 
  left join dispositivos on dispositivos.id=es_participaciones.solicitante
  left join es_profesionales on es_participaciones.profesional=es_profesionales.id
  left join tablas espe on espe.tipo='ESESP' and espe.valo=es_participaciones.especialidad
 where fecha_inicio is null and fecha_rechazo is null order by apellidos,nombres,fecha_ingreso asc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      $conta=$conta+1;
      $lega=$r['legajo'];
      $apyn=si($lega=="0","",$r["Apellidos"].", ".$r["Nombres"]." (".$r["edadc"].")");
      echo "<tr style='font-size:.9em;'><td>".ffec($r["fecha_ingreso"])."</td><td>".$apyn."</td><td>".trim($r["solicitante"]." ".$r["solicitante_especificar"]).
  "</td><td>".$r["especialidad"]."</td><td>".$r["apellido"]."</td><td><btn class='btn-sm btn-success' onclick='accion(".$r["id"].")'>+Acc</btn>&nbsp;";
      if($r["profesional"]=="") {echo "<btn class='btn-sm btn-success' onclick='prof(".$r["id"].")'>Profesional</btn>&nbsp;";};
      echo "<btn class='btn-sm btn-info' onclick='nopert(".$r["id"].")'>NoPert</btn>&nbsp;";	
      echo "<btn class='btn-sm btn-warning' onclick='informe(".$r["id"].")'>Informe</btn>&nbsp;";	
      echo "</td></tr>";

   };   
?>

</table>
<?php echo $conta." solicitudes pendientes" ?>
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
function prof(id){
 navega("es_solicitud_profesional?id="+id);
}
</script>
</body>

</html>