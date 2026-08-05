<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$prof=un_campo("select id from es_profesionales where usuario=".$_SESSION["glidusua"]);
if($prof=="") die("Tu usuario no tiene profesional asociado");
$p=un_registro("select * from es_profesionales where id=".$prof);
?>
</div>
<div class="container">
<strong>Solicitudes Abiertas a Autoasignar  <?php echo $p["apellido"].", ".$p["nombre"]?> </strong>
<div class='table-responsive'>
<table class='table table-bordered'>
<tr class="bg-primary"><th>Fecha</th><th>Apellido y Nombre, edad</th><th>Solicitante</th><th>Ult.Acci&oacute;n</th><th>Opciones</th></tr>
<?php
   $sql="select es_participaciones.*, sujetos.*, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre as solicitante, (select max(fecha) from es_acciones where solicitud=es_participaciones.id) as ulti, concat(apellido,', ',es_profesionales.nombre) as profes      
  from es_participaciones left join sujetos on es_participaciones.legajo=sujetos.legajo 
  left join dispositivos on dispositivos.id=es_participaciones.solicitante
  left join es_profesionales on profesional=es_profesionales.id 
 where fecha_rechazo is null and fecha_fin is null and es_profesionales.id is null and especialidad=".$p["profesion"]." order by apellidos, nombres, fecha_ingreso asc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      $conta=$conta+1;
      $lega=$r['legajo'];
      $apyn=si($lega=="0","",$r["Apellidos"].", ".$r["Nombres"]." (".$r["edadc"].")");
      echo "<tr><td>".ffec($r["fecha_ingreso"])."</td><td>".$apyn."</td><td>".trim($r["solicitante"]." ".$r["solicitante_especificar"])."</td>";
      echo "<td>".ffec($r["ulti"])."</td><td>";
      echo "<btn class='btn-sm btn-warning' onclick='informe(".$r["id"].")'>Informe</btn>&nbsp;";	
      echo "<btn class='btn-sm btn-info' onclick='profesional(".$r["id"].",".$prof.")'>Autoasignar</btn>&nbsp;";	
      echo "</td></tr>";

   };   
?>

</table>
<?php echo $conta . " Solicitudes Abiertas"?>
</div>

<script>

function informe(id){
 navega("informe_solicitud_es?id="+id);
}
function profesional(id,prof){
 navega("es_solicitud_autoasignar?id="+id+"&profesional="+prof);
}

</script>
</body>

</html>