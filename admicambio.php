<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Cambio de dispositivo de alojamiento";
//noconsulta();
include("encabezado-test.php");
$id=$_GET["iid"];
$reg = un_registro("select admi_alta as alta, concat(Apellidos,', ',Nombres) as apyn, admi_hogar, nombre as hoga, Hogares_Mail, admi_legajo  from hogares_admision left join sujetos on legajo=admi_legajo left join dispositivos on dispositivos.id=admi_hogar where idhogares_admision=".$id);
$hoga=$reg['hoga'];
$idhoga=$reg['admi_hogar'];
$alta=ffec($reg['alta']);
$legajo=$reg['admi_legajo'];
$apyn=$reg['apyn'];
$destino=un_campo("select admi_hogar from hogares_admision where admi_legajo=".$legajo." and admi_alta is null and admi_fderiv is not null and admi_susp is null limit 1");
if(!$destino>0) die("no hay dispositivo asignado");
$nombre=un_campo("select nombre from dispositivos where id=".$destino);
?>
<script type="text/javascript">
function valida_datos() {
valida_fecha("fecha");
fecha=fsql(document.getElementById("fecha").value);
legajo="<?php echo $legajo?>";
if (fsql(document.getElementById("fecha").value)>fsql("<?php echo $_SESSION["DiaHoy"];?>")){status("la fecha del cambio no puede ser futura");return false;};
if(fsql("<?php echo $alta?>")>fecha){status("la fecha del cambio no puede ser menor que la de alta");return false;};
cantidad=ejec("sq_altasbajas","1","&legajo="+legajo);
if(parseInt(cantidad)==0) {status("no hay un alojamiento en curso. No puede procesarse este cambioi");return false;};
ultimabaja=ejec("sq_altasbajas","2","&legajo="+legajo);
if(ultimabaja!=""){
  if(fsql(ultimabaja)>fecha){status("este no es el último tramo del alojamiento. No puede procesarse este cambio");return false;};
};
origen="<?php echo $idhoga?>";
destino="<?php echo $destino?>";
if(origen==destino){status("Destino no puede ser Origen");return false;};
status("");
return true;
}

</script>
</div>
<div class="container">
<h4>Cambio de dispositivo dentro del circuito DGSAP</h4>
<br>
<div class="row">
 <div class="col-md-4">
  <?php echo 'NNYA: <strong>'.$apyn.'</strong>';?>
 </div>
 <div class="col-md-4">
  <?php echo 'Origen:<strong>'.$hoga.'</strong>';?>
 </div>
 <div class="col-md-4">
  <?php echo 'Destino:<strong>'.$nombre.'</strong>';?>
 </div>
</div>
<br>
<form class="form-inline" action="admicambio_do" onsubmit="return valida_datos()">
 <div class="form-group has-warning col-md-4">
  <label class="label-form" for="fecha">Fecha del Cambio</label>
  <input class="form-control" size='10' maxlength='10' name="fecha" id='fecha' onblur='valida_fecha(this.id,1)' required autofocus>
 </div>
 <div class="form-group has-warning col-md-6">
  <label class="label-form" for="motivo">Motivo del Cambio</label>
  <input class='form-control' name="motivo" id="motivo" size="40" maxlength="100" required>
 </div><br><br>
 <input type="hidden" name="id" value="<?php echo $id;?>">
 <input type="hidden" name="dispositivo_origen" value="<?php echo $idhoga?>">
 <input type="hidden" name="dispositivo_destino" value="<?php echo $destino?>">

<button class="btn btn-primary">Registrar Cambio</button>

</form>


</div>
</body>
</html>