<?php
include("Funciones.php");
session_start();
include("encabezado.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$prof=un_campo("select id from es_profesionales where usuario=".$_SESSION["glidusua"]);
if($prof=="") die("Tu usuario no tiene profesional asociado");
$p=un_registro("select * from es_profesionales where id=".$prof);
?>
</div>
<div class="container">
<strong>Mis solicitudes abiertas <?php echo $p["apellido"].", ".$p["nombre"]?></strong>
<div class='table-responsive'>
<table class='table table-bordered'>
<tr class="bg-primary" style="font-size:.8em"><th>Apellido y Nombre, edad</th><th>Dispositivo</th><th>Solicitud</th><th>Ult.Acci&oacute;n</th><th>Pr&oacute;xima<br>Acci&oacute;n</th><th>Opciones</th></tr>
<?php
   $sql="select es_participaciones.*, sujetos.*, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadc,
 dispositivos.nombre as dispositivo, (select max(fecha) from es_acciones where solicitud=es_participaciones.id and es_acciones.estado=2) as ulti,
  (select max(fecha) from es_acciones where fecha>=curdate() and solicitud=es_participaciones.id and estado=1) as prox 
  from es_participaciones left join sujetos on es_participaciones.legajo=sujetos.legajo 
  left join es_profesionales on profesional=es_profesionales.id 
  left join es_acciones on solicitud=es_participaciones.id and fecha=(select max(fecha) from es_acciones where solicitud=es_participaciones.id)
  left join dispositivos on dispositivos.id=es_acciones.dispositivo
 where fecha_rechazo is null and fecha_fin is null and es_participaciones.profesional=".$prof." order by dispositivos.nombre,apellidos, nombres, fecha_ingreso asc";
   $reg =registros($sql);
   $conta=0;
   while ($r = mysqli_fetch_assoc($reg)) {
      	$conta=$conta+1;
      	$lega=$r['legajo'];
      	$apyn=si($lega=="0","",$r["Apellidos"].", ".$r["Nombres"]." (".$r["edadc"].")");
      	$dispo=si($r["dispositivo"]=="",un_campo("select nombre from dispositivos where dispositivos.id=".$r["solicitante"]),$r["dispositivo"]);
        echo "<tr style='font-size:.80em;'><td>".$apyn."</td><td>".$dispo."</td><td>".ffec($r["fecha_ingreso"])."</td><td>".ffec($r["ulti"]).
        "</td><td>".ffec($r["prox"])."</td><td><btn class='btn-sm btn-warning' onclick='informe(".$r["id"].")'>Informe</btn>&nbsp;&nbsp;</td></tr>";
   };   
?>

</table>
<?php echo $conta . " Solicitudes abiertas asignadas a m&iacute;"?>
</div>

<script>
function accion(id){
 navega("es_accion_nueva?solicitud="+id);
}
function informe(id){
 navega("informe_solicitud_es?id="+id);
}

</script>
</body>

</html>