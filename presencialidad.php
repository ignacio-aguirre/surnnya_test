<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Presencialidad";
include("encabezado-test.php");
$id=nget("id");
$ha=un_registro("select * from hogares_admision where idhogares_admision=".$id);
$nn=un_registro("select * from sujetos where legajo=".$ha["admi_legajo"]);
$hg=un_registro("select * from dispositivos where dispositivos.id=".$ha["admi_hogar"]);

?>
</div>
<div class="container">
NNYA: <?php echo $nn["Apellidos"].", ".$nn["Nombres"]?><br>
Dispositivo: <?php echo $hg["nombre"]?>
<h4>Historial Presencialidad</h4>
<div class="table-responsive">
<table class="table">
<tr class="bg-primary"><th>Fecha</th><th>Estado</th><th>Observaciones</th></tr>
<?php
$reg=registros("select alojados_presencia.*,deno from alojados_presencia left join tablas on tipo='EPRE' and valo=estado where vacante=".$id." order by fecha_estado");
foreach($reg as $r){
 echo "<tr><td>".ffec($r["fecha_estado"])."</td><td>".$r["deno"]."</td><td>".$r["observaciones"]."</td></tr>";
}
?>
</table>
</div>
<h4>Registrar Novedad</h4>
<form method="GET" action="presencialidad_do" onsubmit="return valida()" class="form">
 <div class="form-group has-warning">
 <label class="label-form">Estado</label>
 <select class="form-control" name="estado" id="estado"required autofocus>
  <option value=""></option>
  <?php echo opc_tabla("EPRE");?>
 </select>
 </div>
 <div class="form-group has-warning">
 <label class="label-form">Fecha Estado</label>
 <input class="form-control" name="fecha_estado" id="fecha_estado" size="10" maxlength="10" onblur="valida_fecha(this.id)" required>
 </div>
 <div class="form-group has-warning">
 <label class="label-form">Observaciones, Detalle</label>
 <input class="form-control" name="observaciones" id="observaciones" size="60" maxlength="80" required>
 </div>

 <input name="id" value="<?php echo $id?>" hidden>
 <button class="btn-primary">Registrar</button>

</form>
</div>
<script>
function valida(){
  estado_actual="<?php echo $ha['presencialidad']?>";
  estado_nuevo=document.getElementById("estado").value;
  if(estado_actual=="1" && estado_nuevo!="2"){status("Con estado actual Presente, solo se puede registrar Ausente con reserva de vacante");return false;};
  if(estado_actual=="2" && estado_nuevo!="1"){status("Con estado actual Ausente, solo se puede registrar Presente");return false;};
  return true;
}
</script>
</body>
</html>