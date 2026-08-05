<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
?>
</div>
<div class="container">
<strong>Solicitudes Abiertas</strong>
<button class="btn btn-success" onclick="aexcel()">Excel</button>
<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr><th>Fecha</th><th>Apellido y Nombre, edad</th><th>Solicitante</th><th>Profesi&oacute;n</th><th>Profesional Asignado</th><th>Ult.Acci&oacute;n</th><th>Opciones</th></tr>
<?php
   $sql="select es_participaciones.*, sujetos.*, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre as solicitante, espe.deno as especialidad, (select max(fecha) from es_acciones where solicitud=es_participaciones.id) as ulti, concat(apellido,', ',es_profesionales.nombre) as profes     
  from es_participaciones left join sujetos on es_participaciones.legajo=sujetos.legajo 
  left join dispositivos on dispositivos.id=es_participaciones.solicitante
  left join tablas espe on espe.tipo='ESESP' and espe.valo=es_participaciones.especialidad
  left join es_profesionales on profesional=es_profesionales.id 
 where fecha_inicio is not null and fecha_fin is null order by apellidos, nombres, fecha_ingreso asc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      $conta=$conta+1;
      $lega=$r['legajo'];
      $apyn=si($lega=="0","",$r["Apellidos"].", ".$r["Nombres"]." (".$r["edadc"].")");
      echo "<tr><td>".ffec($r["fecha_ingreso"])."</td><td>".$apyn."</td><td>".trim($r["solicitante"]." ".$r["solicitante_especificar"]).
  "</td><td>".$r["especialidad"]."</td><td>".$r["profes"]."</td>";
      echo "<td>".ffec($r["ulti"])."</td><td>";
      echo "<btn class='btn-sm btn-success' onclick='accion(".$r["id"].")'>+Acc</btn>&nbsp;";
      echo "<btn class='btn-sm btn-danger' onclick='finalizar(".$r["id"].")'>Fin</btn>&nbsp;";
      echo "<btn class='btn-sm btn-warning' onclick='informe(".$r["id"].")'>Informe</btn>&nbsp;";	
      if($_SESSION["glidusua"]==570||$_SESSION["glidusua"]==596) echo "<btn class='btn-sm btn-info' onclick='profesional(".$r["id"].")'>Profesional</btn>&nbsp;";	
      echo "</td></tr>";

   };   
?>

</table>
<?php echo $conta . " Solicitudes Abiertas"?>
</div>

<script>
function aexcel(){
 navega("es_solicitudes_abiertas_excel");
}

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
function profesional(id){
 navega("es_solicitud_profesional?id="+id+"&retorno=abiertas");
}

</script>
</body>

</html>