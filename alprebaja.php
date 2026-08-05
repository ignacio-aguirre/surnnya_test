<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Egreso de Hogar";
noconsulta();
include("encabezado.php");
$id=$_GET["id"];
$reg = un_registro("select admi_alta as alta, concat(Apellidos,', ',Nombres) as apyn, nombre as hoga, Hogares_Mail, admi_legajo  from hogares_admision left join sujetos on legajo=admi_legajo left join dispositivos on dispositivos.id=admi_hogar where idhogares_admision=".$id);
$hoga=$reg['hoga'];
$alta=ffec($reg['alta']);
$legajo=$reg['admi_legajo'];
$apyn=$reg['apyn'];
?>
<script type="text/javascript">
function valida() {
valida_fecha("fecha");
fecha=fsql(document.getElementById("fecha").value);
legajo="<?php echo $legajo?>";
if (fsql(document.getElementById("fecha").value)>fsql("<?php echo $_SESSION["DiaHoy"];?>")){alert("la fecha de baja no puede ser futura");return false;};
if(fsql("<?php echo $alta?>")>fecha){alert("la fecha de baja no puede ser menor que la de alta");return false;};
cantidad=ejec("sq_altasbajas","1","&legajo="+legajo);
if(parseInt(cantidad)==0) {alert("no hay un alojamiento en curso. No puede procesarse esta baja");return false;};
ultimabaja=ejec("sq_altasbajas","2","&legajo="+legajo);
if(ultimabaja!=""){
  if(fsql(ultimabaja)>fecha){alert("este no es el último tramo del alojamiento. No puede procesarse esta baja");return false;};
};
return true;
}


</script>
</div>
<div class="container">
<div class="row">
 <div class="col-md-12">
  <?php echo 'Sujeto:<strong>'.$apyn.'</strong>';?>
 </div>
</div>
<div class="row">
 <div class="col-md-8">
  <?php echo 'Hogar:<strong>'.$hoga.'</strong>';?>
 </div>

 <div class="col-md-4">
  <?php echo 'Alta:<strong>'.$alta.'</strong>';?>
 </div>
</div>
<form class="form-inline" action="alprebaja_do" onsubmit="return valida()">
 <div class="form-group has-warning">
  <label class="label-form" for="fecha">Fecha de Baja</label>
  <input class="form-control" size='10' maxlength='10' id='fecha' name="fecha" onblur='valida_fecha(this.id)' autofocus required>
 </div>
<br><br>
 <div class="form-group has-warning">
  <label class="label-form" for="mote">Motivo de Egreso</label>
  <select class='form-control' id='mote' name="mote" required><option></option><?php echo opc_tabla("MEPRE");?></select>
 </div>
<input type="hidden" name="id" value="<?php echo $id;?>">
<br><br>
<button class="btn-danger">Registrar Baja</button>
</form>

</div>
</body>

</html>