<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Informe Solicitud a Gabinete de Salud";
include("encabezado.php");
$solicitud=nget("id");
$r=un_registro("select * from es_participaciones where id=".$solicitud);

?>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-4">
	Fecha Solicitud <strong> <?php echo ffec($r["fecha_ingreso"])?></strong>
   </div>
   <div class="col-md-4">
	Tipo de Acci&oacute;n Solicitada <strong> <?php echo si($r["alcance"]=="1","Intervenci&oacute;n","Institucional")?></strong>
   </div>
   <div class="col-md-4">
	Dispositivo Solicitante <strong> <?php echo si($r["solicitante"]=="-1",$r["solicitante_especificar"],un_campo("select nombre from dispositivos where dispositivos.id=".$r["solicitante"]))?></strong>
   </div>

 </div>
 <div class="row">
   <div class="col-md-4">
	Profesi&oacute;n <strong> <?php echo un_campo("select deno from tablas where tipo='ESESP' and valo=".$r["especialidad"]);?></strong>
   </div>
   <div class="col-md-4"><strong>
     <?php
      if($r["legajo"]>0){
        echo "NNYA ".un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$r["legajo"]);
      }else{
      echo "No asociada a un NNYA";};
      ?></strong>
   </div>
   <div class="col-md-4">
	Profesional <strong> <?php echo un_campo("select concat(apellido,', ',nombre) from es_profesionales where id=".nulea($r["profesional"]));?></strong>
   </div>

 </div>
 <h4>Historial de Cambios de Estado</h4>
 <div class="table-responsive">
	<table class="table">
	<tr class="bg-primary"><th>Fecha</th><th>Motivo</th><th>Estado</th></tr>
	<?php
	echo "<tr><td>".ffec($r["fecha_ingreso"])."</td><td>Solicitud</td><td>Pendiente</td></tr>";
	if($r["fecha_rechazo"]!=""){
  	 echo "<tr><td>".ffec($r["fecha_rechazo"])."</td><td></td><td>No Pertinente</td></tr>";
        };
	if($r["fecha_inicio"]!=""){
  	 echo "<tr><td>".ffec($r["fecha_inicio"])."</td><td>Primera Atenci&oacute;n</td><td>Abierta</td></tr>";
        };
	if($r["fecha_fin"]!=""){
  	 echo "<tr><td>".ffec($r["fecha_fin"])."</td><td>".$r["motivo_estado"]."</td><td>Cerrada</td></tr>";
        };


	?>
	</table>
 </div>
 <h4>Historial de Acciones</h4>
 <div class="table-responsive">
	<table class="table">
	<tr class="bg-primary"><th>Fecha</th><th>Dipositivo</th><th>Profesi&oacute;n</th><th>Tipo Acci&oacute;n</th><th>Modalidad</th><th>Observaciones</th><th>Estado</th><th></th></tr>
        <?php
         $sql="select es_acciones.*, dispositivos.nombre, prof.deno as profe, tipos.deno as tipoa, esta.deno as est from es_acciones 
 left join tablas prof on prof.tipo='ESESP' and prof.valo=especialidad
 left join tablas tipos on tipos.tipo='ESTIA' and tipos.valo=es_acciones.tipo
 left join tablas esta on esta.tipo='ESEA' and esta.valo=es_acciones.estado 

 left join dispositivos on dispositivos.id=dispositivo where  solicitud=".$solicitud." order by fecha desc";
         $reg=registros($sql);
         $cant=0;
	 while($a=mysqli_fetch_assoc($reg)){
          echo "<tr><td>".ffec($a["fecha"])."</td><td>".$a["nombre"]."</td><td>".$a["profe"]."</td><td>".$a["tipoa"]."</td><td>".
 si($a["modalidad"]=="P","Presencial","Virtual")."</td><td>".$a["observaciones"]."</td><td>".$a["est"]."</td><td>";
 if($_SESSION["glidperfil"]=="58") echo "<button class='btn-sm btn-danger' onclick='aeliminar(".$a["id"].")'>Eliminar</button>";
echo "</td></tr>";
          $cant=$cant+1;
         };
        ?>
	</table>
 </div>
 <?php if($cant==0 && ($_SESSION["menu"]=="mnu_sal")) { ?>
   <button class="btn-danger" onclick="seliminar(<?php echo $solicitud?>)">Eliminar la Solicitud</button>
 <?php };?>
 <?php if($_SESSION["menu"]=="mnu_sal") { ?>
 <br><br>
 <button class="btn-primary" onclick="editar(<?php echo $solicitud?>)">Editar la Solicitud</button>
 <?php };?>

</div>
<script>
function aeliminar(id){
 resp=ejec_sq("sq_es_accion?id="+id);
 if(confirm("Confirmas eliminacion de Accion del "+resp)){
   navega("es_accion_elimina?id="+id);
 };
}
function seliminar(id){
 resp=ejec_sq("sq_es_solicitud?id="+id);
 if(confirm("Confirmas eliminacion de Solicitud del "+resp)){
   navega("es_solicitud_elimina?id="+id);
 };
}

function editar(id){
  navega("es_solicitud_editar?id="+id);
}

</script>
</body>
</html>