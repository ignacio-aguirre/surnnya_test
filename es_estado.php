<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Cambio de estado de Solicitud a Equipo de Salud";
include("encabezado-test.php");
$solicitud=nget("solicitud");
$estado=$_GET["estado"];
$r=un_registro("select * from es_participaciones where id=".$solicitud);
?>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-4">
	Fecha Solicitud <strong> <?php echo ffec($r["fecha_ingreso"])?></strong>
   </div>
   <div class="col-md-4">
	Alcance de la Acci&oacute;n Solicitada <strong> <?php echo si($r["alcance"]=="1","Intervenci&oacute;n","Institucional")?></strong>
   </div>
   <div class="col-md-4">
	Dispositivo Solicitante <strong> <?php echo si($r["solicitante"]=="-1",$r["solicitante_especificar"],un_campo("select nombre from dispositivos where dispositivos.id=".$r["solicitante"]))?></strong>
   </div>

 </div>
 <div class="row">
   <div class="col-md-4">
	Tipo de Acci&oacute;n Solicitada <strong> <?php 
 if($r["tipo"]!=""){
  echo un_campo("select deno from tablas where tipo='ESTIA' and valo=".$r["tipo"]);
 } else {echo $r["accion_especificar"];};?>
</strong>
   </div>
   <div class="col-md-4">
	Especialidad <strong> <?php echo un_campo("select deno from tablas where tipo='ESESP' and valo=".$r["especialidad"]);?></strong>
   </div>
   <div class="col-md-4"><strong>
     <?php
      if($r["legajo"]>0){
        echo "NNYA ".un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$r["legajo"]);
      }else{
      echo "No asociada a un NNYA";};
      ?></strong>
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
  	 echo "<tr><td>".ffec($r["fecha_fin"])."</td><td></td><td>Cerrada</td></tr>";
        };


	?>
	</table>
 </div>
 <form class="form-inline" method="get" action="es_estado_do" onsubmit="return valida()">
  <div class="form-group has-warning">
	<label class="label-form">Fecha del cambio de estado</label>
        <input class="form-control" name="fecha_estado" id="fecha_estado" size="10" maxlength="10" onblur="valida_fecha(this.id)" autofocus required>
  </div><br><br> 
  <div class="form-group has-warning">
	<label class="label-form">Motivo del cambio de estado</label>
        <input class='form-control' name='motivo_estado' id='motivo_estado' maxlength="100" size="80" required></div>
        <input hidden name='estado' value="<?php echo $estado?>">
        <input hidden name='solicitud' value="<?php echo $solicitud?>"><br><br>

 <?php 
if($estado=="np"){ 
  echo "<button class='btn-danger'>Cambiar estado a No Pertinente</button>";
 };
if($estado=="cr"){ 
  echo "<button class='btn-danger'>Cambiar estado a Cerrada</button>";
 };

?> 
  </form>
</div>
<script>
function valida(){
  valida_fecha("fecha_estado");
 if(document.getElementById("fecha_estado").value==""){status("fecha es obligatoria"); return false;};
 valida_0("motivo_estado");
 if(document.getElementById("motivo_estado").value==""){status("motivo es obligatorio"); return false;};
 return true;
}
</script>

</body>
</html>
