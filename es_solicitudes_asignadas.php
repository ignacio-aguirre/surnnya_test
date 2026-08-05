<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$idusua=$_SESSION["glidusua"];
if($idusua!=570 && $idusua!=596 && $idusua!=1) {die("sin permiso de acceso");};
?>
</div>
<div class="container">
<strong>Solicitudes Abiertas y Asignadas</strong>
<div class='table-responsive'>
<table class='table table-striped table-bordered'>
<tr style="font-size:.80em"><th>Profesional</th><th>Apellido y Nombre, edad</th><th>Dispositivo</th><th>Solicitud</th><th>Ult.Acci&oacute;n</th></tr>
<?php
   $sql="select es_participaciones.*, sujetos.*, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre as dispositivo, (select max(fecha) from es_acciones where solicitud=es_participaciones.id) as ulti, concat(apellido,', ',es_profesionales.nombre) as profes      
  from es_participaciones left join sujetos on es_participaciones.legajo=sujetos.legajo 
  left join es_profesionales on es_participaciones.profesional=es_profesionales.id 
  left join es_acciones on solicitud=es_participaciones.id and fecha=(select max(fecha) from es_acciones where solicitud=es_participaciones.id)
  left join dispositivos on dispositivos.id=es_acciones.dispositivo
 where fecha_rechazo is null and fecha_fin is null and es_participaciones.profesional>0 order by apellido, es_profesionales.nombre, dispositivos.nombre,apellidos, nombres, fecha_ingreso asc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
       $conta=$conta+1;
       $lega=$r['legajo'];
       $apyn=si($lega=="0","",$r["Apellidos"].", ".$r["Nombres"]." (".$r["edadc"].")");
       $dispo=si($r["dispositivo"]=="",un_campo("select nombre from dispositivos where dispositivos.id=".$r["solicitante"]),$r["dispositivo"]);
       echo "<tr style='font-size:.80em'><td>".$r["profes"]."</td><td>".$apyn."</td><td>".$dispo."</td><td>".ffec($r["fecha_ingreso"])."</td><td>".ffec($r["ulti"]);
       echo "</td></tr>";
   };   
?>

</table>
<?php echo $conta . " Solicitudes a programar"?>
</div>

<script>
function programar(id){
 navega("es_solicitud_programar?id="+id);
}
function calendario(id){
 navega("es_calendario?prof="+id);
}

</script>
</body>

</html>